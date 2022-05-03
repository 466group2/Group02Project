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
            if ( isset($_POST['ID'], $_POST['QTY']) ) {
                $id = $_POST['ID'];
                $qty = $_POST['QTY'];
                
                if($id && $qty > 0){
                    if( isset($_SESSION['cart']) && is_array($_SESSION['cart']) ){
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
                echo "<pre>";
                echo "<table border='1'>
                <tr>
                <th>Image</th>
                <th>Name</th>
                <th>QTY</th>
                <th>Price</th>
                <th>Total</th>
                </tr>";
                
                foreach($_SESSION['cart'] as $idnum => $numof)
                {
                    $item = getItem($idnum,$pdo);
                    $total +=  printCartItem($item,$numof);
                    $_SESSION['items'][$idnum] = $item[0]['price'];
                }

                echo "<tr>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td>" . "SUBTOTAL:" . "</td>";
                echo "<td>" . "$" . $total . "</td>";
                echo "</tr>";
                echo "</pre>";
                echo "</table>";
                $_SESSION['total'] = $total;
                print_r($_SESSION['items']);
            }
        ?>
    </body>
</html>