<?php
session_start();
include 'connection.php';

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    $sql = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "User not found.";
        exit;
    }
} else {
    echo "Please log in.";
    exit;
}
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
    <h2>My Details</h2>
    <form class="form" method="post" id="editForm">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>"><br><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"><br><br>

        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter new password (optional)">
        
        <div class="popup" id="popup">User details updated successfully.</div>
        <br><br>
        <div class="button-container">
            <button type="button" onclick="window.location.href='userloggedin.php'">Back to Home</button>
            <input type="submit" value="Update">
        </div>
    </form>

    <script>
        document.getElementById('editForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent form submission to handle via JavaScript

            var form = e.target;
            var formData = new FormData(form);

            fetch('update_user.php', {
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