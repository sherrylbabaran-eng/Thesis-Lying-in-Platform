<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Registration</title>
</head>
<body>

<div class="container">
    <h2>Register</h2>

    <form method="POST" action="">
        <input type="text" name="first_name" placeholder="First Name" required>

        <input type="text" name="last_name" placeholder="Last Name" required>

        <input type="email" name="email" placeholder="Email" required>

        <input type="password" name="password" placeholder="Password" required>

        <button type="submit" name="register">Register</button>
    </form>

</div>

</body>
</html>


<?php
include 'sit.php';

if(isset($_POST['register'])) {
    $first = $_POST['first_name'];
    $last = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (first_name, last_name, email, password)
            VALUES (:first_name, :last_name, :email, :password)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':first_name' => $first,
        ':last_name' => $last,
        ':email' => $email,
        ':password' => $password
    ]);

    echo "Registration successful";
}
?>