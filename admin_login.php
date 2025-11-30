<?php
session_start();
include 'config.php';
$fixed_admin_username = "tanvinimbalkar1502@gmail.com";
$fixed_admin_password = "satara123";
 // Change this as needed

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    


    if ($username === $fixed_admin_username && $password === $fixed_admin_password ) {
        $_SESSION['admin'] = $username;
        header("Location: admin_dashboard.php");
        exit();
    }else{
        echo "<p style='color:red;'>Invalid Username or password</p>";
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>

    
       
    <style>
        /* Add background image */
        body { 
            font-family: Arial, sans-serif; 
            background: url("/farm_gear_rentals/image/bg2.jpg") no-repeat center center/cover;
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat; 
            text-align: center; 
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
           width: 300px;
          margin: auto;
          padding: 20px;
          border-radius: 10px;
          box-shadow: 0px 0px 10px 0pxrgba(133, 28, 28, 0.1);
        margin-top: 50px;
        }
        
         
        input { 
            width: 90%; 
            padding: 10px; 
            margin: 10px 0; 
            border: 1px solid #ddd; 
            border-radius: 5px; 
        }
        button { 
            width: 100%; 
            padding: 10px; 
            background:#28a745; 
            color: white; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
        }
        button:hover { 
            background: #218838; 
        }
        .error { 
            color: red; 
        }
        h3{
            font-size: 28px;
            font-weight: bold;
            text-align: center'
            text-shadow: 2px 2px 4px black;
        }
    </style>
 
            


</head>
<body>
<div class="container">
    <h3>Admin Login</h3>
    <form action="admin_login.php" method="POST">
        <label for="name">username:</label><br>
        <input type="text" name="username" id="username" required><br><br>
        
        <label for="password">Password:</label><br>
        <input type="password" name="password" id="password" required><br><br>

       
        
        <button type="submit">Login</button>
    </form>
    </div>
</body>
</html> 