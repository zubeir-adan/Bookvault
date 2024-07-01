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
</head>
<>
    <h2>My Details</h2>
    <form method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>"><br><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"><br><br>

        <label for="pass">Password:</label>
        <input type="pass" id="pass" name="pass" value="<?php echo htmlspecialchars($user['password_hash']); ?>"><br><br>
        
        <input type="submit" value="Update">
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password=$_POST['pass'];
    
        // Validate the input (e.g., ensure no fields are empty)
        if (empty($username) || empty($email)) {
            echo "All fields are required.";
            exit();
        }
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
    
        // Update user details
        $sql = "UPDATE users SET username = ?, email = ?, password_hash=? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $username, $email, $password_hash,$userId);
    
        if ($stmt->execute()) {
            echo "User details updated successfully.";
            // Optionally redirect to a different page
            // header("Location: profile.php");
            // exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    
        $stmt->close();
        $conn->close();
    }
    ?>
    <button type="button" onclick="window.location.href='userloggedin.php'">Back to Home</button>
</body>
</html>
