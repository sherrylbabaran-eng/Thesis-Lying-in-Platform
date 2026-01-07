<?php
date_default_timezone_set('Asia/Manila');
session_start();
include '../back-end/sit.php';

$message = '';
$error = '';

if(isset($_POST['submit'])) {
    $email = $_POST['email'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if($user) {
        // Generate secure token
        $token = bin2hex(random_bytes(16));
        $expires = date("Y-m-d H:i:s", time() + 3600); // 1 hour expiry

        $update = $conn->prepare("UPDATE users SET reset_token = ?, reset_expires = ? WHERE id = ?");
        $update->bind_param("ssi", $token, $expires, $user['id']);
        $update->execute();

        // For local demo: display token link
        $reset_link = "http://localhost/THESIS/Thesis-Lying-in-Platform/action/reset_password.php?token=$token";


        $message = "Password reset link (demo): <a href='$reset_link'>$reset_link</a>";
    } else {
        $error = "Email not found";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Forgot Password</title>
<link rel="stylesheet" href="../css/login.css">
</head>
<body>
<div class="container">
    <h2>Forgot Password</h2>

    <?php if($message) echo "<p class='success'>$message</p>"; ?>
    <?php if($error) echo "<p class='error'>$error</p>"; ?>

    <form method="POST" action="">
        <input type="email" name="email" placeholder="Enter your email" required>
        <button type="submit" name="submit">Send Reset Link</button>
    </form>

    <p><a href="login.php">Back to Login</a></p>
</div>
</body>
</html>
