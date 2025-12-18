<!-- Backend of the edit --> 
<?php 
include  "sit.php";
// getting the submitted data from form 
echo $id= $_POST["id"];
echo $first = $_POST["first_name"];
echo $last = $_POST["last_name"];
$sql = "UPDATE users SET first_name = '$first', last_name = '$last' WHERE id= '$id'";

if ($conn->query($sql) === TRUE) {
         
     
        header("location: index.php");
      
} else {
  echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
