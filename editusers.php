<?php
session_start();
include 'connection.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    echo "Please log in as admin.";
    exit;
}

// Initialize variables
$user_id = "";
$username = "";
$email = "";

// Check if user_id is provided in the URL
if (isset($_GET["id"])) {
    $user_id = $_GET["id"];

    // Fetch user details from the database based on user_id
    $sql = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the user details
        $row = $result->fetch_assoc();
        $username = $row["username"];
        $email = $row["email"];
    } else {
        echo "User not found.";
        exit;
    }
}

// Handle form submission for updating user details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate input
    if (empty($username) || empty($email)) {
        echo "Username and Email are required.";
        exit;
    }

    // Update user details (username, email, and optionally password)
    if (!empty($password)) {
        // If password is provided, hash it
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET username = ?, email = ?, password_hash = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $username, $email, $password_hash, $user_id);
    } else {
        // If password is not provided, update without changing the password
        $sql = "UPDATE users SET username = ?, email = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $username, $email, $user_id);
    }

    // Execute the update query
    if ($stmt->execute()) {
        $response = [
            'success' => true,
            'message' => 'User details updated successfully.'
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Error updating user details: ' . $stmt->error
        ];
    }

    // Output JSON response
    header('Content-Type: application/json');
    echo json_encode($response);

    exit; // Ensure no further output
}

// Close prepared statement and database connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User Details</title>
    <link rel="stylesheet" type="text/css" href="decorate.css">
    <style>
        h2 {
            margin-left: 130px;
        }
        form {
            align-items: center;
        }
        .button-container {
            display: flex;
            justify-content: space-between;
        }
        .popup {
            display: none;
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h2>Edit User Information</h2>
    <form class="form" method="post" id="editForm">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>"><br><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>"><br><br>

        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter new password (optional)">
        
        <div class="popup" id="popup">User details updated successfully.</div>
        <br><br>
        <div class="button-container">
            <button type="button" style="cursor: pointer;" onclick="window.location.href='adminloggedin.php'">Back</button>
            <input type="submit" value="Update">
        </div>
    </form>

    <script>
        document.getElementById('editForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent form submission to handle via JavaScript

            var form = e.target;
            var formData = new FormData(form);

            fetch('editusers.php?id=<?php echo $user_id; ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                var popup = document.getElementById('popup');
                popup.innerText = data.message;
                popup.style.display = 'block';
                setTimeout(function() {
                    popup.style.display = 'none';
                    if (data.success) {
                        location.reload(); // Reload the page to show updated details
                    }
                }, 3000);
            })
            .catch(error => {
                var popup = document.getElementById('popup');
                popup.innerText = "An error occurred: " + error;
                popup.style.display = 'block';
                setTimeout(function() {
                    popup.style.display = 'none';
                }, 3000);
            });
        });
    </script>
</body>
</html>
