<?php
session_start();

if (!isset($_SESSION['logging']) || $_SESSION['logging'] !== true) {
    header("location: adminlogin.php");
    exit();
}

include_once 'connection.php';

// Retrieve the admin's ID and name from the session
$adminId = $_SESSION['admin_id'];
$adminName = $_SESSION['admin_name'];

// Check if the form is submitted for updating user details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit_user"])) {
    // Retrieve form data using $_POST
    $user_id = $_POST["user_id"];
    $username = $_POST["username"];
    $email = $_POST["email"];

    // SQL query to update user data in the database
    $sql = "UPDATE users SET username = '$username', email = '$email' WHERE user_id = $user_id";

    // Execute the SQL query
    if ($conn->query($sql) === TRUE) {
        // Display success message using JavaScript
        echo "<script>
                alert('User information updated successfully');
                window.location.href = 'adminloggedin.php'; // Redirect back to the admin page
              </script>";
    } else {
        // Display error message
        echo "Error updating user information: " . $conn->error;
    }
}

// Check if the form is submitted for adding a new user
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_user"])) {
    // Retrieve form data using $_POST
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Hash the password for security
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // SQL query to insert user data into the database
    $sql = "INSERT INTO users (username, email, password_hash) 
            VALUES ('$username', '$email', '$password_hash')";

    // Execute the SQL query
    if ($conn->query($sql) === TRUE) {
        // Display success message using JavaScript
        echo "<script>
                alert('User added successfully');
                window.location.href = 'adminloggedin.php'; // Redirect back to the admin page
              </script>";
    } else {
        // Display error message
        echo "Error adding user: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        .header {
            position: sticky;
            top: 0;
            background: #f7f7f8;
            border-bottom: 3px solid #87CEEB;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            transition: background-color 0.3s ease; /* Smooth background color transition */
        }
        .welcome {
            color: lightslategrey;
            font-size: 18px;
        }
        .menu {
            display: flex;
            justify-content: center;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        .menu div {
            flex: 1;
            text-align: center;
            padding: 20px;
            margin: 0px;
            border: 1px solid #000;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease; /* Smooth transition for background color and text color */
        }
        .menu div:hover {
            background-color: white; /* Hover background color */
        }
        .view-users {
            background-color: #3c763d;
            color: white;
        }
        .add-user {
            background-color: #87ceeb;
            color: black;
        }
        .edit-user-list {
            background-color: #d3d3d3;
            color: black;
        }
        .form-container {
            display: none;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
<div class="header">
    <div class="wrapper">
        <img src="img/book-vault-logo.png" alt="Book Vault Logo" style="width: 100px; height: auto;">
        <h4 style="text-align: left; margin: 0;">Revolutionize Reading!</h4>
    </div>
    <div class="welcome">
        Welcome, Admin <?php echo htmlspecialchars($adminName); ?>
    </div>
</div>

<div class="menu">
    <div class="view-users" onclick="loadUsersTable()">VIEW USERS</div>
    <div class="add-user" onclick="toggleForm()">ADD USER</div>
    <div class="edit-user-list">EDIT USER LIST</div>
</div>

<div id="addUserFormContainer" class="form-container" style="display: none; text-align: center;">
    <form id="addUserForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" style="width: 300px; margin: 0 auto; padding: 90px; background-color: #f9f9f9; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <label for="username" style="display: block; margin-bottom: 10px;">Username</label>
        <input type="text" name="username" id="username" required style="width: 100%; padding: 10px; margin-bottom: 20px; border-radius: 5px; border: 1px solid #ccc;">
        <br>
        <label for="email" style="display: block; margin-bottom: 10px;">Email</label>
        <input type="email" name="email" id="email" required style="width: 100%; padding: 10px; margin-bottom: 20px; border-radius: 5px; border: 1px solid #ccc;">
        <br>
        <label for="password" style="display: block; margin-bottom: 10px;">Password</label>
        <input type="password" name="password" id="password" required style="width: 100%; padding: 10px; margin-bottom: 20px; border-radius: 5px; border: 1px solid #ccc;">
        <br>
        <input type="submit" name="add_user" value="Add" style="width: 100%; padding: 10px; background-color: #3c763d; color: white; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s;">
     </form>
</div>


<div id="usersTableContainer"></div>

<script>
     function loadUsersTable() {
        var usersTableContainer = document.getElementById("usersTableContainer");
        // Check if the users table is displayed
        if (usersTableContainer.style.display === "block") {
            // If displayed, hide it
            usersTableContainer.style.display = "none";
        } else {
            // If hidden, load and display it
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "viewusers.php", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("usersTableContainer").innerHTML = xhr.responseText;
                }
            };
            xhr.send();
            // Show the users table container
            usersTableContainer.style.display = "block";
            // Hide the Add User form if it's displayed
            var formContainer = document.getElementById("addUserFormContainer");
            if (formContainer.style.display === "block") {
                formContainer.style.display = "none";
            }
        }
    }

   
    function toggleForm() {
        var formContainer = document.getElementById("addUserFormContainer");
        var usersTableContainer = document.getElementById("usersTableContainer");
        console.log("Form container:", formContainer); // Log the form container element to the console
        if (formContainer) {
            formContainer.style.display = (formContainer.style.display === "none") ? "block" : "none";
            if (formContainer.style.display === "block") {
                usersTableContainer.style.display = "none";
            }
        } else {
            console.error("Form container not found."); // Log an error if the form container element is not found
        }
    }
</script>


</body>
</html>
<?php include("body/footer.php"); ?>
