<?php
include "sit.php";

/*
Expected URL:
edit.php?id=1&firstname=Juan&lastname=Dela%20Cruz
*/

$id        = $_GET['id'];
$firstname = $_GET['firstname'];
$lastname  = $_GET['lastname'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">
    <h2>Edit User</h2>

    <!-- ID is passed via URL, NOT hidden input -->
    <form action="update.php?id=<?php echo $id; ?>" method="POST">

        <div class="mb-3">
            <label class="form-label">First Name</label>
            <input
                type="text"
                name="first_name"
                class="form-control"
                value="<?php echo $firstname; ?>"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Last Name</label>
            <input
                type="text"
                name="last_name"
                class="form-control"
                value="<?php echo $lastname; ?>"
                required
            >
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>

    </form>
</div>

</body>
</html>
