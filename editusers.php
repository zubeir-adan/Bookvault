<?php
require_once("connection.php");

$user_id = "";
$username = "";
$email = "";

// Check if user_id is provided in the URL
if (isset($_GET["id"])) {
    $user_id = $_GET["id"];

    // Fetch user details from the database based on user_id
    $sql = "SELECT * FROM users WHERE user_id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the user details
        $row = $result->fetch_assoc();
        $username = $row["username"];
        $email = $row["email"];
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
   <style>
    body {
    background-image: url('img/5use.jpg');      
    background-size: cover; 
    background-position: center; 
    font-family: Arial, sans-serif;
}

h1 {
    color: black;
    text-align: left;
    text-indent: -490px; 
}

form {
    max-width: 400px;
    margin-left: 130px;
    padding: 20px;
    background-color: cream;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    color: darkbrown;
    border-color: darkbrown;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

input[type="text"],
input[type="email"] {
    width: calc(100% - 24px); /* Adjusted width to accommodate border */
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type="submit"] {
    background-color: whitesmoke;
    color: #333;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

   </style>
</head>
<body>
    <h1>Edit User Information</h1>
    <form action="adminloggedin.php" method="post">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" maxlength="50" required value="<?php echo $username; ?>">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" maxlength="50" required value="<?php echo $email; ?>">
        <br><br>
        <input type="submit" name="edit_user" value="Edit">
    </form>
</body>
</html>
