<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Login</title>

</head>
<body>

<div class="container">
    <h2>Login</h2>

    <form method="POST" action="">
        <input type="email" name="email" placeholder="Email" required>

        <input type="password" name="password" placeholder="Password" required>

        <button type="submit" name="login">Login</button>
    </form>

    <p style="text-align:center; margin-top:10px;">
        Don't have an account? <a href="register.php">Register</a>
    </p>
</div>

</body>
</html>


<?php
session_start();
include 'sit.php';

if(isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch();

    if($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: index.html");
    } else {
        echo "Invalid login";
    }
}
?>