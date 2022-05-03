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
    session_name('cart');
    session_start();

    echo "Was the submit button pushed?:";
    if(isset($_POST["submit_checkout"]))
    {
        if(isset($_POST["shipping_is_billing"]))    
        {   
            echo "</br>";
            echo "shipping = billing button checked";
            echo "</br>";
            $_POST["shipping_address"] = $_POST["billing_address"];
            echo "</br>";
            echo "shipping = billing button set";
            echo "</br>";
        }
        echo "yes, submit button pushed";
        createOrder($pdo);
    } else {echo "no";}
    

    
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

            input[type="number"]{
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
        </style>
    </head>
    <body>
        <form method="POST"> <!--start form bracket-->
            <button class="button home" name="home">Home 
                <i class="fa fa-home"></i>
            </button>
     
        <h1>Checkout</h1>    
        <h2>Please review your final order request:</h2>

        <?php
            if($_SESSION)
            {
                $total = 0;
                echo "<table border='1'>
                <tr>
                <th>Image</th>
                <th>Name</th>
                <th>QTY</th>
                <th>Price</th>
                <th>Total</th>
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
                echo "</tr>";
                echo "</pre>";
                echo "</table>";
            }
        ?>

        <h4>Accepted Cards</h4>
        <div class="icon-container">
            <i class="fa fa-cc-visa" style="color:white;"></i>
            <i class="fa fa-cc-mastercard" style="color:white;"></i>
            <i class="fa fa-cc-amex" style="color:white;"></i>
            <i class="fa fa-cc-discover" style="color:white;"></i>
        </div>
        
            <div>
                <label>Credit Card</label>
                <input type="number" id="CREDIT_CARD" name="credit_card"
                placeholder="1234123412341234">
            </div>
      
        <h3>Billing Address</h3>
    
            <div>
                <label><i class="fa fa-user"></i>
                    Full Name</label>
                <input type="text" id="FULL_NAME" name="name"
                placeholder="Homer J. Simpsons">
                <label><i class="fa fa-address-card-o"></i>
                    Address</label>
                <input type="text" id="BILL_ADDR"  name="billing_address"
                placeholder="744 Evergreen Terrace, Springfield">
                <label><i class="fa fa-envelope"></i>
                    Email Address</label>
                <input type="text" id="EMAIL" name="email"
                placeholder="chunkylover53@aol.com">
                <label><i class="fa fa-phone"></i>
                    Phone Number</label>
                <input type="text" id="PHONE" name="phone"
                placeholder="(939)-555-0113">
            </div>
        

        <br></br>
        
            <input type="checkbox" id="ship" name="shipping_is_billing">
            Check if shipping address is same as
                billing address.
        

        <h3>Shipping Address</h3>
        
            <div>
                <label><i class="fa fa-address-card-o"></i>
                    Address</label>
                <input type="text" id="SHIP_ADDR" name="shipping_address"
                placeholder="742 Evergreen Terrance, Springfield">
            </div>
            <button class="button submit" name="submit_checkout" id="checkout">
                Submit <i class="fa fa-check"></i>
            </button>
        </form> <!--end form bracket-->

        <?php
        // If shipping and billing address are the same
            if(isset($_POST["ship"]))
        ?>
    </body>
</html>