<?php include "sit.php"; ?>

<!-- design of the crud -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">First Name</th>
      <th scope="col">Last Name</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
<!-- gets the record and check the database -->
    <?php $sql = "SELECT * FROM `users`";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    
    while($row = $result->fetch_assoc()) {
    ?>
    <tr>
      <th scope="row"><?php echo $row["id"]; ?></th>
      <td><?php echo $row["first_name"]; ?></td>
      <td><?php echo $row["last_name"]; ?></td>
    <!-- getting the backend or database -->
      <td> <a href="edit.php?id=<?php echo $row['id']; ?>&firstname=<?php echo $row['first_name']; ?>&lastname=<?php echo $row['last_name']; ?>" class="btn btn-warning">Edit</a>
      <a href="delete.php?id=<?php echo $row['id']; ?>" type="button" class="btn btn-danger">Del</a></td>
    </tr>
  <?php  
  }
  } else {
    echo "0 result";
  }
  ?>
  </tbody>
</table>
<a href="add.php" class="btn btn-success">Add</a>
</div>
</body>
</html>