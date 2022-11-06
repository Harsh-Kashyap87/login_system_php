<?php

$login = false;
$showErr = false;
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        include "partials/_dbconnect.php";
        $username = $_POST["username"];
        $password = $_POST["password"];

        
        // $sql = "Select * from users where username='$username' AND password='$password'";
        $sql = "Select * from users where username='$username'";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        if($num ==1 )
        {
            while($row=mysqli_fetch_assoc($result))
            {
                if(password_verify($password, $row['password']))
                {
                    $login = true;
                    session_start();
                    $_SESSION['loggedin'] = true;
                    $_SESSION['username'] = $username;
                    header("location: welcome.php");
                }
                else
                {
                    $showErr = "Password Invalid";
                }
            }
        }
        else
        {
            $showErr = "Username / Password Invalid";
        }
    }
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>

<body>
    <?php 
        require "partials/_nav.php";
    ?>
    <?php
        if($login)
        {
            
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success </strong> Logged in successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
        }
        if($showErr)
        {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong> Oops! </strong> '. $showErr .'
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
    ?>

    <!-- Sign details -->
    <h1 class="text-center my-5">Login here!</h1>
    <div class="container">
        <!-- <h2 class="text-center">Create your accont for free</h2> -->
        <form action="/login/login.php" method="post">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" aria-describedby="emailHelp">

            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            <div class="mb-3">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
            <div id="emailHelp" class="form-text">We'll never share your details with anyone else.</div>
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>
</body>

</html>