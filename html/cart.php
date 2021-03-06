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
    session_name('cart');
    session_start();
    $_SESSION['items'] = NULL;

    if(isset($_POST["clear"]))
    {   
        unset($_SESSION['cart']);
        unset($_SESSION['items']);
        unset($_SESSION['total']);
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
            /* .remove{
                position: relative;
                display: inline-block;
                top: 215px;
                font-size: 15px;
                margin: 10px 10px;
            } */
            .p1{
                font-family: Arial;
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
    
        <?php
        // this php block receives an item qty/id from item page
            if ( isset($_POST['ID'], $_POST['QTY']) || isset($_POST['ID'], $_POST['QTY'],$_POST['SUB']) ) {
                $id = $_POST['ID'];
                $qty = $_POST['QTY'];

                if( isset($_POST['SUB']) ){
                    $sub = $_POST['SUB'];
                    if( array_key_exists($id, $_SESSION['cart']) /*&& ($qty != $sub)*/ ){
                        $_SESSION['cart'][$id] = $sub;
                    }
                    if( $sub == 0 ) {
                        foreach($_SESSION['cart'] as $k => $v) {
                            if($k == $id)
                              unset($_SESSION['cart'][$k]);
                        }
                    }
                    unset($sub);
                }
                if(($id && $qty > 0) && ( !isset($_POST['SUB']) )){
                    if( isset($_SESSION['cart']) ){
                        if( array_key_exists($id, $_SESSION['cart']) ){
                            $_SESSION['cart'][$id] += $qty;
                        }
                        else{
                            $_SESSION['cart'][$id] = $qty;
                        }
                    }
                    else
                    {
                        $_SESSION['cart'] = array($id=>$qty);
                    }
                }
            }
            if($_SESSION){
                //testing out session
                $total = 0;
                echo "<table border='1'>
                <tr>
                <th>Image</th>
                <th>Name</th>
                <th>QTY</th>
                <th>Price</th>
                <th>Total</th>
                <th>Edit Quantity</th>
                </tr>";
                
                if(isset($_SESSION['cart']) && !empty($_SESSION['cart']))
                { // If cart is not empty, show what is in cart
                    foreach($_SESSION['cart'] as $idnum => $numof)
                    {
                        $item = getItem($idnum,$pdo);
                        $total +=  printCartItem($item,$numof);
                        $_SESSION['items'][$idnum] = $item[0]['price'];
                    }
                } else { // If carty is empty, print out message
                    echo "<h3 class='p1'>Cart is empty</h3>";
                    echo "<br></br>";
                }

                echo "<tr>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td>" . "SUBTOTAL:" . "</td>";
                echo "<td>" . "$" . $total . "</td>";
                echo "<td></td>";
                echo "</tr>";
                echo "</table>";
                $_SESSION['total'] = $total;
            }
        ?>
    </body>
</html>