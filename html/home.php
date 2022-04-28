<?php
declare(strict_types = 1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
include '../lib/db.php';
include '../lib/functions.php';

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

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store home</title>
    <link rel="stylesheet" href="style.css">

    <style>
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
    transition-duration: 0.4s;
    cursor: pointer;
    }

    .button1 {
    background-color: grey; 
    color: black; 
    border: 2px solid #4CAF50;
    }

    .button1:hover {
    background-color: #4CAF50;
    color: white;
    }

    .button2 {
    background-color: white; 
    color: black; 
    border: 2px solid #008CBA;
    }

    .button2:hover {
    background-color: #008CBA;
    color: white;
    }

    .button3 {
    background-color: white; 
    color: black; 
    border: 2px solid #f44336;
    }

    .button3:hover {
    background-color: #f44336;
    color: white;
    }

    .button4 {
    background-color: white;
    color: black;
    border: 2px solid #e7e7e7;
    }

    .button4:hover {background-color: #e7e7e7;}

    .button5 {
    background-color: white;
    color: black;
    border: 2px solid #555555;
    }

    .button5:hover {
    background-color: #555555;
    color: white;
    }
</style>

</head>
<body>
    <h1>CSCI 466 Group Project</h1>    
    <h2>Welcome to The Norvinsk Region</h2>
    <form method="POST">     
        <button class="button button1" name="armor">Armor</button>
        <button class="button button2" name="food">Food</button>
        <button class="button button3" name="meds">Medicine</button> 
        <br>
        <button class="button button4" name="cart">Cart</button>
        <button class="button button5" name="orders">Order History</button>
    </form>

</body>
</html>
