<?php
date_default_timezone_set('Asia/Manila');
session_start();
include '../back-end/sit.php';

$error = '';
$success = '';
$user = null;
$token = $_GET['token'] ?? '';

if ($token) {
    $stmt = $conn->prepare(
        "SELECT id FROM users 
         WHERE reset_token = ? AND reset_expires > NOW()"
    );
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        $error = "Invalid or expired token";
    }
} else {
    $error = "No token provided";
}

if (isset($_POST['reset'])) {
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];
    $token    = $_POST['token'];

    if ($password !== $confirm) {
        $error = "Passwords do not match.";
    }
    elseif (
        strlen($password) < 8 ||
        !preg_match('/[A-Z]/', $password) ||
        !preg_match('/[a-z]/', $password) ||
        !preg_match('/[0-9]/', $password)
    ) {
        $error = "Password must be at least 8 characters and include uppercase, lowercase, and a number.";
    }
    else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare(
            "SELECT id FROM users 
             WHERE reset_token = ? AND reset_expires > NOW()"
        );
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            $update = $conn->prepare(
                "UPDATE users 
                 SET password = ?, reset_token = NULL, reset_expires = NULL 
                 WHERE id = ?"
            );
            $update->bind_param("si", $hashed, $user['id']);

            if ($update->execute()) {
                $success = "Password reset successful. Redirecting to login...";

                $user = null; // hide form after success
            } else {
                $error = "Failed to reset password.";
            }
        } else {
            $error = "Invalid or expired token.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reset Password</title>
<link rel="stylesheet" href="../css/login.css">
</head>
<body>

<div class="container">
    <h2>Reset Password</h2>

    <?php if ($success): ?>
    <p class="success"><?= $success ?></p>
    <script>
        setTimeout(() => {
            window.location.href = 'login.php';
        }, 2500);
    </script>
<?php endif; ?>

    <?php if ($error): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <?php if (!$success && $user): ?>
    <form method="POST">
        <input type="password" id="password" name="password" placeholder="New Password" required>
        <div class="strength">
            <div id="strength-bar"></div>
        </div>

        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

        <button type="submit" name="reset">Reset Password</button>
    </form>
    <?php endif; ?>
</div>

<script src="../js/password-strength.js" defer></script>

</body>
</html>
