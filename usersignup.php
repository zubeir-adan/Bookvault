<?php

// Display message to indicate script execution
echo "We're here in the next page.\n";

// Include the connection file
require_once("connection.php");

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
    echo "<script>alert('Data inserted successfully')</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Redirect the user to a new page after insertion
header("location: userlogin.html");

// Close the database connection
$conn->close();

?>
