<?php
session_start();
include 'connection.php';

$response = array('success' => false, 'message' => 'An error occurred.');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate the input (e.g., ensure no fields are empty)
    if (empty($username) || empty($email)) {
        $response['message'] = "Username and Email are required.";
        echo json_encode($response);
        exit();
    }

    // Update user details
    if (!empty($password)) {
        // If password is provided, hash it
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET username = ?, email = ?, password_hash = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $username, $email, $password_hash, $userId);
    } else {
        // If password is not provided, update without changing the password
        $sql = "UPDATE users SET username = ?, email = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $username, $email, $userId);
    }

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "User details updated successfully.";
    } else {
        $response['message'] = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    $response['message'] = "Invalid request.";
}

echo json_encode($response);
?>