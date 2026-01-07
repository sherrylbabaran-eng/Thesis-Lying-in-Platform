<?php
session_start();
include '../back-end/sit.php';

$error = '';
$max_attempts = 5;
$lockout_time = 300; // 5 minutes

if(isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if($user) {

        // Account-based lockout
        if($user['failed_attempts'] >= $max_attempts &&
           strtotime($user['last_failed_login']) > time() - $lockout_time) {

            $error = "Too many login attempts. Try again later.";

        } else {

            if(password_verify($password, $user['password'])) {

                $reset = $conn->prepare("UPDATE users SET failed_attempts = 0, last_failed_login = NULL WHERE id = ?");
                $reset->bind_param("i", $user['id']);
                $reset->execute();

                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id'];
                header("Location: ../index.html");
                exit();

            } else {
                $failed = $conn->prepare("UPDATE users SET failed_attempts = failed_attempts + 1, last_failed_login = NOW() WHERE id = ?");
                $failed->bind_param("i", $user['id']);
                $failed->execute();

                $error = "Invalid login credentials";
            }
        }

    } else {
        $error = "Invalid login credentials";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - Cavite Lying-In Clinic</title>
<link rel="stylesheet" href="../css/login.css">
<script>
    const errorMessage = <?php echo json_encode($error); ?>;
</script>
<script src="../js/popup.js" defer></script>
</head>
<body>

<header>
  <a href="../index.html" class="brand">
    <img src="../components/logo.svg" alt="Logo">
    <span>Cavite Lying-In Clinic</span>
  </a>
  <nav>
    <a href="../index.html">Home</a>
    <a href="login.php" class="active">Login</a>
    <a href="register.php">Register</a>
  </nav>
</header>

<div class="container">
    <h2>Login</h2>

    <?php if(!empty($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="POST" action="">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
    </form>

   
    <p><a href="forgot_password.php">Forgot Password?</a></p>

    <p>Don't have an account? <a href="register.php">Register</a></p>
</div>



</body>
</html>
