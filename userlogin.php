<?php
session_start();

if(isset($_SESSION['logging']) && $_SESSION['logging'] === true){
    header("location: userloggedin.php");
    exit();
}

require_once("connection.php");

$errorUsername = ""; // Error message for username
$errorPassword = ""; // Error message for password

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['username']) && isset($_POST['password'])){
        function validate($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $username = validate($_POST['username']);
        $password = validate($_POST['password']);

        if(empty($username) || empty($password)){
            $errorUsername = "All fields are required";
        }else{
            $sql = "SELECT * FROM users WHERE username ='$username'";
            $result = $conn->query($sql);
            if($result->num_rows === 1){
                $row = $result->fetch_assoc();
                // Verify hashed password
                if(password_verify($password, $row['password_hash'])){
                    $_SESSION['logging'] = true;
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['username'] = $row['username'];
                    header("location: userloggedin.php");
                    exit();
                }else{
                    $errorPassword = "Sorry, your password was incorrect. Please double-check your password.";
                }
            }else{
                $errorUsername = "User not found. Please recheck.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> User login</title>
    <style>
        
        body {
          background-color: #e4d9d9;
          font-family:'Times New Roman', Times, serif;
        
        }
        
        h2 {
        color: white;
        text-align:center;
          text-indent: -420px; 
        }
        
        
        form {
            width: 300px; /* Adjust width as needed */
            margin-left: 300px; /* Move the form to the left */
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        label {
        display: block;
        margin-bottom: 10px;
        color: #333;
        }
        
        input[type="text"],
        input[type="password"] {
        width: 200px;
        padding: 5px;
        border: 1px solid #ddd;
        border-radius: 3px;
        }
        
        
        input[type="submit"] {
        background-color: burlywood;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        }
        
        input[type="submit"]:hover {
          background-color: #4c7f1e;
        }
        
          body {
            background-image: url('img/6use.jpg');
            background-size: cover;
            background-position: center;
          }
            </style>
</head>
<body>
    <h2>Login</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username" style="color: whitesmoke;">Username </label>
        <input type="text" id="username" name="username" required>
        <br>
        <br>
        <?php if(!empty($errorUsername)): ?>
            <p style="color: red;"><?php echo $errorUsername; ?></p>
        <?php endif; ?>
        <label for="password" style="color: whitesmoke;">Password</label>
        <input type="password" id="password" name="password" required>
        <br>
        <br>
        <?php if(!empty($errorPassword)): ?>
            <p style="color: red;"><?php echo $errorPassword; ?></p>
        <?php endif; ?>
        <input type="submit" value="Submit">
    </form>
    <a href="usersignup.html"
     style="display: block; 
     text-align: left; 
     margin-left: 300px; 
     color: cornsilk;
      text-decoration: none;
      " onmouseover="this.style.color='black'"
       onmouseout="this.style.color='white'">Don't have an account? Register here</a>
</body>
</html>
