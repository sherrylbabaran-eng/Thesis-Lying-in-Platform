<?php
include "sit.php"; // adjust the path to your DB connection

?>

<!-- design and add form of the adding -->
<!DOCTYPE html>
<html>
<head>
    <title>Add User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Add New User</h2>
    <form method="POST" action="adding.php">
        <div class="mb-3">
            <label>ID</label>
            <input type="number" name="id" class="form-control"  required>
        </div>
        <div class="mb-3">
            <label>First Name</label>
            <input type="text" name="first_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Last Name</label>
            <input type="text" name="last_name" class="form-control" required>
        </div>
        <input type="submit" class="btn btn-primary">
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
</body>
</html>
