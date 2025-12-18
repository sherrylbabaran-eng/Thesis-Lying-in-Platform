<?php
include "sit.php";

// getting the database outside of the url (POST)
    $id     = $_POST["id"];
    $first  = $_POST["first_name"];
    $last   = $_POST["last_name"];

    $sql = "INSERT INTO users (id, first_name, last_name) 
            VALUES ('$id', '$first', '$last')";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error inserting record: " . $conn->error;
    }

    $conn->close();

?>