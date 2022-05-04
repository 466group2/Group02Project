<?php
    /**
     * Purpose: Php page for employee to login
     * CSCI 466 - 1
     * Group 02
     * Spring 2022
     * Group Members:
     * Moses Mang
     * Maricarmen Paniagua
     * Alexander Peterson
     * Maria Sofia
     */
    declare(strict_types = 1);
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    include '../lib/db.php';
    include '../lib/functions.php';

    if(isset($_POST["home"]))
    {
        header("location:home.php");
    }
    $password = 1234;
    // If login button has been pushed
    if(isset($_POST["login"]))
    {
        // Check to see if correct password has been entered
        if($_POST['PASSWORD'] == $password)
        {   echo "Correct password!";
            header("location:pending.php");
        } else {
            echo "Wrong password. Try again";
        }
    }

    //connect to mariadb
    $pdo = connectdb();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <style>
            body{
                height: 100%;
                background-attachment: fixed;
                background-position: center;
                background-repeat: no-repeat;
                background-image: url("img/grail.png");
            }
            input[type=password]{
                width:30%;
                padding: 14px 14px;
                margin: 8px 0;
                display: inline-block;
            }
            .home{
                position: absolute;
                top: 10px;
                left: 10px;
                font-size: 25px;
                margin: 20px 10px;
            }
            .login{
                position: relative;
                font-size: 25px;
                margin: 20px 10px;
        }
        </style>
    </head>
    <body>
        <form method="POST">
            <button class="button home" name="home">Home 
                <i class="fa fa-home"></i>
            </button>
        </form>
        <h1>Employee Page</h1>    
        <h3>Please enter password</h3>
        <form method="POST">
            <div>
                <input type="password" 
                placeholder="TA, for grading purpose: 1234";
                name="PASSWORD" required>
                <br>
                <button class="button login" type="submit" name="login">
                    Login <i class="fa fa-key"></i>
                </button>
            </div>
        </form>
    </body>
</html>