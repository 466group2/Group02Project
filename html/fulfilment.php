<?php
//php block 1
    declare(strict_types = 1);
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    include 'secrets.php';
    include 'library.php';

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
    </head>
    <body>
        <h1>Employee Page - Order Fulfilment</h1>    
        <h2>Manage orders:</h2>
    </body>
</html>