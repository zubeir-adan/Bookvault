<?php
session_start();

if (isset($_SESSION['logging']) && $_SESSION['logging'] === true) {
    header("location: adminloggedin.php");
    exit();
}

require_once("connection.php");

$errorUsername = ""; // Error message for username
$errorPassword = ""; // Error message for password

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        function validate($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $admin_name = validate($_POST['username']);
        $password = validate($_POST['password']);

        if (empty($admin_name) || empty($password)) {
            $errorUsername = "All fields are required";
        } else {
            $sql = "SELECT * FROM admin WHERE admin_name = '$admin_name'";
            $result = $conn->query($sql);
            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                // Verify hashed password
                if (password_verify($password, $row['password_hash'])) {
                    $_SESSION['logging'] = true;
                    $_SESSION['admin_id'] = $row['admin_id'];
                    $_SESSION['admin_name'] = $row['admin_name'];
                    header("location: adminloggedin.php");
                    exit();
                } else {
                    $errorPassword = "Sorry, your password was incorrect. Please double-check your password.";
                }
            } else {
                $errorUsername = "User not found. Please recheck.";
            }
        }
    }
}
?>

    
    
