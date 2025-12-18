<?php
include "sit.php";

$id    = (int)$_GET['id'];
$first = mysqli_real_escape_string($conn, $_POST['first_name']);
$last  = mysqli_real_escape_string($conn, $_POST['last_name']);

$sql = "UPDATE users SET first_name='$first', last_name='$last' WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    header("Location: index.php");
    exit;
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
