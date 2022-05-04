<?php
/**
 * Purpose: Homepage
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

    //link all pages from home page
    if(isset($_POST["armor"]))  
    {  
        header("location:armor.php"); 
    }

    if(isset($_POST["food"]))  
    {  
        header("location:food.php"); 
    }

    if(isset($_POST["meds"]))  
    {  
        header("location:meds.php"); 
    }

    if(isset($_POST["cart"]))  
    {  
        header("location:cart.php"); 
    }

    if(isset($_POST["orders"]))  
    {  
        header("location:orders.php"); 
    }

    if(isset($_POST["employee"]))
    {
        header("location:login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Store home</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <style>
        body {
        height: 100%;
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        background-image: url("img/labs1.webp");
        max-width: 1000px !important;
        margin: auto !important;
        }
        .button {
        background-color: #4CAF50; /* Green */
        border: none;
        color: white;
        padding: 16px 64px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 25px;
        margin: 40px 30px;
        transition-duration: 0.3s;
        cursor: pointer;
        }

        .button1 {
        background-color: lightgrey; 
        color: black; 
        border: 2px solid #4CAF50;
        }

        .button1:hover {
        background-color: #4CAF50;
        color: white;
        }

        .button2 {
        background-color: lightgrey; 
        color: black; 
        border: 2px solid #008CBA;
        }

        .button2:hover {
        background-color: #008CBA;
        color: white;
        }

        .button3 {
        background-color: lightgrey; 
        color: black; 
        border: 2px solid #f44336;
        }

        .button3:hover {
        background-color: #f44336;
        color: white;
        }

        .button4 {
        background-color: lightgrey;
        color: black;
        border: 2px solid #e7e7e7;
        }

        .button4:hover {
        background-color: #555555;
        color: white;
        }

        .button5 {
        background-color: lightgrey;
        color: black;
        border: 2px solid #e7e7e7;
        }

        .button5:hover {
        background-color: #555555;
        color: white;
        }

        .employee {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
        }
        .employee:hover {
            background-color: #FFFFFF;
            color: green;
        }
        </style>
    </head>
    <body>
        <h1>CSCI 466 Group Project</h1>    
        <h2>Welcome to The Norvinsk Region</h2>
        <br></br>
        <h2>Items for sale</h3>
        <form method="POST">     
            <button class="button button1" name="armor">
                Armor <i class="fa fa-shield"></i>
            </button>
            <button class="button button2" name="food">
                Food <i class="fa fa-apple fa-flip-horizontal"></i>
            </button>
            <button class="button button3" name="meds">
                Medicine <i class="fa fa-medkit"></i>
            </button> 
            <br>
            <h2>Review your orders</h3>
            <button class="button button4" name="cart">
                Cart <i class="fa fa-shopping-cart"></i></button>
            <button class="button button5" name="orders">
                Order History <i class="fa fa-history"></i>
            </button>
            <button class="button employee" name="employee">
                Employee Login <i class="fa fa-key"></i>
            </button>
        </form>
    </body>
</html>
