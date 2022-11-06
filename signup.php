<?php
    $login = false;
    $showErr = false;
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            include "partials/_dbconnect.php";
            $username = $_POST["username"];
            $password = $_POST["password"];
            $cpassword = $_POST["cpassword"];

            $sqlExits = "SELECT * FROM users WHERE username = '$username' ";
            $result = mysqli_query($conn, $sqlExits);
            $numExitsRows = mysqli_num_rows($result);
            if($numExitsRows > 0 ){
                $showErr = "This Username already exits, Please choose another!";
            }
            else
            {
                if($password == $cpassword)
                {
                    $hash = password_hash($password, PASSWORD_DEFAULT); 
                    $sql = "INSERT INTO `users` (`username`, `password`, `dt`) VALUES ('$username', '$hash', current_timestamp())";
                    $result = mysqli_query($conn, $sql);
                    if($result)
                        {
                            $login = true;
                        }
                }
                else
                {
                    $showErr = "Password do not match";
                }
            }
        }
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  </head>
  <body>
    <?php 
        require "partials/_nav.php";
    ?>
    <?php
        if($login)
        {
            
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Your account created successfully!</strong>,Now you can login.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
        }
        if($showErr)
        {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Wrong</strong> '. $showErr .'
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
    ?>

<!-- Sign details -->
<div class="container">
  <h1 class="text-center my-5">Sign Up here!</h1>
        <!-- <h2 class="text-center">Create your accont for free</h2> -->
        <form action="/login/signup.php" method="post">
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Username</label>
        <input type="text" maxlength="20" name="username" id="username" class="form-control" aria-describedby="emailHelp">
        
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">New Password</label>
        <input type="password" name="password" id="password"  class="form-control">
      </div>
      <div class="mb-3">
        <label for="cpassword" class="form-label">Re-type new</label>
        <input type="password" name="cpassword" id="cpassword" class="form-control">
        <div id="emailHelp" class="form-text">Make sure that, Password and Confirm must be same</div>
      
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
      <div id="emailHelp" class="form-text">We'll never share your details with anyone else.</div>
    </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  </body>
</html>


