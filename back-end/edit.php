<!-- connection -->
<?php include "sit.php";?>

<!-- design and form of the update -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<!-- connection and url getting form --> 
    <form action="update.php" method="POST">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">id</label>
    <input type="number" name="id" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $_GET["id"]; ?>"> 

  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">First Name</label>
    <input type="text" name="first_name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $_GET["firstname"]; ?>"> 

  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Last Name</label>
    <input type="text" name="last_name" class="form-control" id="exampleInputPassword1"  value="<?php echo $_GET["lastname"]; ?>">
  
</div>
  <button type="submit" class="btn btn-primary">Update</button>
</form>
</head>