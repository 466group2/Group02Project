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
    //php block 1
    declare(strict_types = 1);
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    include '../lib/db.php';
    include '../lib/functions.php';

    // Go home if home button is clicked
    if(isset($_POST["home"]))
    {
        header("location:home.php");
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
        <title>Checkout</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            .home{
                position: absolute;
                top: 10px;
                left: 10px;
                font-size: 25px;
                margin: 20px 10px;
            }
            .submit{
                position: relative;
                font-size: 25px;
                margin: 20px 10px;
            }

            input[type=text]{
                width: 50%;
                margin-bottom: 10px;
                padding: 8px;
            }

            label{
                display: block;
                margin-bottom: 10px;
            }
            .icon-container {
                margin-bottom: 20px;
                padding: 7px 0;
                font-size: 30px;
            }

            .row {
                display: -ms-flexbox;
                display: flex;
                -ms-flex-wrap: wrap;
                flex-wrap: wrap;
                margin: 0 -16px;
            }
        </style>
    </head>
    <body>
        <form method="POST">
            <button class="button home" name="home">Home 
                <i class="fa fa-home"></i>
            </button>
        </form>
        <h1>Checkout</h1>    
        <h2>Please review your final order request:</h2>
        <h3>Payment</h3>
        <h4>Accepted Cards</h4>
        <div class="icon-container">
            <i class="fa fa-cc-visa" style="color:white;"></i>
            <i class="fa fa-cc-mastercard" style="color:white;"></i>
            <i class="fa fa-cc-amex" style="color:white;"></i>
            <i class="fa fa-cc-discover" style="color:white;"></i>
        </div>
        <form method="POST">
            <div>
                <label>Credit Card</label>
                <input type="text" id="CREDIT_CARD"
                placeholder="1234-1234-1234-1234">
                <label>
            </div>
        </form>
        <h3>Billing Address</h3>
        <form method="POST">
            <div>
                <label><i class="fa fa-user"></i>
                    Full Name</label>
                <input type="text" id="FULL_NAME"
                placeholder="Homer J. Simpsons">
                <label><i class="fa fa-address-card-o"></i>
                    Address</label>
                <input type="text" id="BILL_ADDR"
                placeholder="744 Evergreen Terrace, Springfield">
                <label><i class="fa fa-envelope"></i>
                    Email Address</label>
                <input type="text" id="EMIAL"
                placeholder="chunkylover53@aol.com">
                <label><i class="fa fa-phone"></i>
                    Phone Number</label>
                <input type="text" id="PHONE"
                placeholder="(939)-555-0113">
            </div>
        </form>

        <br></br>
        <form method="POST">
            <input type="checkbox" id="ship" name="ship">
            Check if shipping address is same as
                billing address.
        </form>

        <h3>Shipping Address</h3>
        <form method="POST">
            <div>
                <label><i class="fa fa-address-card-o"></i>
                    Address</label>
                <input type="text" id="SHIP_ADDR"
                placeholder="742 Evergreen Terrance, Springfield">
            </div>
            <button class="button submit" name="submit">
                Submit <i class="fa fa-check"></i>
            </button>
        </form>

        <?php
        // If shipping and billing address are the same
            if(isset($_POST["ship"]))
        ?>
    </body>
</html>