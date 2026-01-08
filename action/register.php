<?php 

$error = '';
$success = '';

if(isset($_POST['register'])) {
    $first = $_POST['first_name'];
    $last = $_POST['last_name'];
    $email = $_POST['email'];
    $password_input = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // --- PASSWORD POLICY CHECK ---
    if ($password_input !== $confirm_password) {
        $error = "Passwords do not match.";
    } elseif (strlen($password_input) < 8 ||
        !preg_match('/[A-Z]/', $password_input) ||
        !preg_match('/[a-z]/', $password_input) ||
        !preg_match('/[0-9]/', $password_input)) {

        $error = "Password must be at least 8 characters, with at least 1 uppercase letter, 1 lowercase letter, and 1 number.";

    } else {
        $password = password_hash($password_input, PASSWORD_DEFAULT);

        // Check if email exists
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if($check->num_rows > 0) {
            $error = "Email already exists";
        } else {
            $sql = $conn->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
            $sql->bind_param("ssss", $first, $last, $email, $password);

            if($sql->execute()) {
                $success = "You are successfully registered!";
            } else {
                $error = "Registration failed. Please try again.";
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
<title>Register - Cavite Lying-In Clinic</title>
<link rel="stylesheet" href="../css/popup.css">

<script>
    const errorMessage = <?php echo json_encode($error); ?>;
    const successMessage = <?php echo json_encode($success); ?>;
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
    <a href="login.php">Login</a>
    <a href="register.php" class="active">Register</a>
  </nav>
</header>

<div class="container">
    <h2>Register</h2>

    <form method="POST" action="">
        <input type="text" name="first_name" placeholder="First Name" required>
        <input type="text" name="last_name" placeholder="Last Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <button type="submit" name="register">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login</a></p>
</div>

<!-- Popup modal -->
<div id="popup" class="popup-modal">
    <div class="popup-content">
        <span id="popup-message"></span>
        <button id="popup-close">OK</button>
    </div>
</div>

<!-- Confetti container -->
<div id="confetti-container"></div>

</body>
</html>
