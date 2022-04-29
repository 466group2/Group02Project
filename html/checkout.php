<?php
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
        div {
            margin-bottom: 10px;
        }
        label{
            display: inline-block;
            width: 100px;
        }
    </style>
</head>
<body>
    <h1>Checkout</h1>    
    <h2>Please review your final order request:</h2>
    <form method="POST">
        <button class="button home" name="home">Home 
            <i class="fa fa-home"></i>
        </button>
    </form>
<?php

//Connect to mariadb
try {
    $dsn = "mysql:host=courses;dbname=$dbname";
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch(PDOexception $error){  
    die('    <p> Connection to database failed: ' . $error->getMessage() . "</p>\n </body></html>"); 
} ?>

<h3>Payment</h3>
<form method="POST">
    <div>
        <label>Credit Card:</label>
        <input type="text" id="CREDIT_CARD"/>
    </div>
</form>

<h3>Shipping Address</h3>
<form method="POST">
    <div>
        <label>Street:</label>
        <input type="text" id="STREET_NAME"/>
    </div>
    <div>
        <label>City:</label>
        <input type="text" id="CITY"/>
    </div>
    <div>
        <label>State:</label>
        <input type="text" id="STATE"/>
    </div>
    <div>
        <label>ZIP Code:</label>
        <input type="text" id="ZIP"/>
    </div>
    <button class="button submit" name="submit">
        Submit <i class="fa fa-check"></i>
    </button>
    
</form>

</body>
</html>