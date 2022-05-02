<?php
    //php block 1
    declare(strict_types = 1);
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);

    include '../lib/db.php';
    include '../lib/functions.php';

    // Go to checkout if checkout button is clicked
    if(isset($_POST["checkout"]))
    {
        header("location:checkout.php");
    }
    // Go to home if home button is clicked
    if(isset($_POST["home"]))
    {
        header("location:home.php");
    }
    //connect to mariadb
    $pdo = connectdb();
    // start session
    session_start();

    if(isset($_POST["clear"]))
    {
        session_destroy();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My Cart</title>
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
            .buy{
                position: absolute;
                top: 10px;
                right: 10px;
                font-size: 25px;
                margin: 20px 10px;
            }
            .clear{
                position: absolute;
                top: 80px;
                right: 10px;
                font-size: 25px;
                margin: 20px 10px;
            }
        </style>
    </head>
    <body>
        <h1>Shopping Cart</h1>    
        <h2>Your cart contains:</h2>
        <form method="POST">
            <button class="button home" name="home">
                Home <i class="fa fa-home"></i>
            </button>
            <button class="button buy" name="checkout">
                Checkout <i class="fa fa-money"></i>
            </button>
            <button class="button clear" name="clear">
                Clear Cart <i class="fa fa-trash"></i>
            </button>
        </form>
    </body>
</html>
<?php
// this php block receives an item qty/id from item page
    if ( isset($_POST['ID'], $_POST['QTY']) ) {
        $id = $_POST['ID'];
        $qty = $_POST['QTY'];

        echo "<p>{$id}, {$qty}</p>";
    }

    // testing out session
    foreach($_SESSION['cart'] as $shop){
        print_r($shop);
    }
?>