<?php
//php block 1
    declare(strict_types = 1);
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    include '../lib/db.php';
    include '../lib/functions.php';

    //link to cart and home pages
    if(isset($_POST["cart"]))
    {
        header("location:cart.php");
    }
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
        <title>Meds</title>
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
            }
            .row { background-color: rgba(0, 0, 0, 0.5); }
            /* Three image containers (use 25% for four, and 50% for two, etc) *****/
            .column {
                float: left;
                width: 33%;
                padding:0px;
                text-align: center;
            }
            /* Clear floats after image containers */
            .row::after {
                content: "";
                clear: both;
                display: table;
            }
            img{
                width:200px;
                height:auto;
                
            }
            .cart {
                position: absolute;
                top: 10px;
                right: 10px;
                font-size: 25px;
                margin: 20px 10px;
            }
            .home{
                position: absolute;
                top: 10px;
                left: 10px;
                font-size: 25px;
                margin: 20px 10px;
            }
        </style>
    </head>
    <body>
        <h1>Medicine</h1>
        <h2>Things to plug your holes and keep you alive</h2>
        <form method="POST">
            <button class="button cart" name="cart">Shopping Cart 
                <i class="fa fa-shopping-cart"></i>
            </button>
        </form>
        <form method="POST">
            <button class="button home" name="home">Home 
                <i class="fa fa-home"></i>
            </button>
        </form>
        <?php
        //php block 2
            $sql = <<<SQL
            SELECT item_id, Meds.type, Products.name, tagline, image
            FROM Meds
            INNER JOIN Products ON Products.id = Meds.item_id;
            SQL;
            try {
                $statement = $pdo->query($sql);
                if($statement) {
                    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
                    if($statement->rowCount() != 0) {
                        // echo "    <p>Got rows!</p>\n<pre>\n";
                    } else {
                        echo "    <p>No rows!</p>\n";
                    }
                } else {
                    echo "    <p>Could not query armor items from database for unknown reason.</p>\n";
                }
            } catch (PDOException $e){
                echo "    <p>Could not query armor items from database. PDO Exception: {$e->getMessage()}</p>\n";
            }
            if (!empty($rows)) {
                $types = [
                    'Painkiller',
                    'Wound treatment',
                    'Surgical treatment'
                ];
                foreach($types as $type){
                    echo <<<HTML
                    <h3>$type</h3>
                    <div class="row">\n
                    HTML;
                    // only meds of current type
                    $meds = array_filter($rows, function ($row) use ($type) {
                        return $row['type'] == $type;
                    });
                    foreach($meds as $med) {
                    echo <<<HTML
                    <div class="column">
                    <a href="item.php?id={$med['item_id']}" class="item">
                        <img src="{$med['image']}" class="item" /><br />
                        {$med['name']}
                    </a> <br>
                        <form action="" name="addtocart" method="POST">
                            <label for=""></label>
                            &nbsp;<label for="quantity">QTY:</label>
                            <input type="number" min="0" id="quantity" name="QTY">
                            <input type="submit"  value="Add to cart">
                        </form>
                        <!--- <p>{$med['tagline']}</p> --->
                    </div>\n
                    HTML;
                    }
                echo "    </div>\n";
                }
            }
        ?>
    </body>
</html>