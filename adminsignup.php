<?php

// Include the connection file
require_once("connection.php");

// Retrieve form data using $_POST
$admin_name = $_POST["admin_name"];
$email = $_POST["email"];
$password = $_POST["password"];

// Hash the password for security
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Check if the number of admins is less than 2
$sql_count = "SELECT COUNT(*) as count FROM admin";
$result = $conn->query($sql_count);
$row = $result->fetch_assoc();
$count = $row['count'];

if ($count >= 2) {
    // Redirect to error page if more than 2 admins
    header("Location: adminlimitreached.html");
    exit; // Stop further execution
}

// SQL query to insert user data into the database
$sql = "INSERT INTO admin (admin_name, email, password_hash) 
        VALUES ('$admin_name', '$email', '$password_hash')";

// Execute the SQL query
if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Data inserted successfully')</script>";
    header("Location: adminlogin.html");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();

?>
