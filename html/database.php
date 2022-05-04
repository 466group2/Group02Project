<?php
    declare(strict_types = 1);
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    include '../lib/db.php';
    include '../lib/functions.php';
    session_start();
    // Go home if home button is clicked
    if(isset($_POST["home"]))
    {
        header("location:home.php");
    }
    //connect to mariadb
    $pdo = connectdb();

   
    if(isset($_POST["modify"])){
       

        $sql = "UPDATE Products SET qty = :qty WHERE id = :itemID;";
        $result = false;    
        try {
            $statement = $pdo->prepare($sql);
            if($statement) {
                    $result = $statement->execute([
                        ':itemID' => $_POST['itemID'],
                        ':qty' => $_POST['qty']
                    ]);
                    
            } else {
                echo "    <p>Could not query database for unknown reason.</p>\n";
            }
        } catch (PDOException $e){
            echo "    <p>Could not query from database. PDO Exception: {$e->getMessage()}</p>\n";
        }       

        $itemID = $_POST['itemID'];
        $qty = $_POST['qty'];
        echo "</br>"; 
        echo "<hr>";
        echo "Item# $itemID updated to quantity $qty.";
        echo "<hr>";
        echo "</br>";
    }

  
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Employee Page</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
        body{
            height: 50;
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-image: url("img/romanesenutdomus.png");
        }
        .home{
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 25px;
            margin: 20px 10px;
        }
        .submit{
            position: relative;
            right: 10px;
            font-size: 25px;
            margin: 20px 10px;
        }
        label{
                display: block;
                margin-bottom: 10px;
        }
        input[type=number]{
                width: 50%;
                margin-bottom: 10px;
                padding: 8px;
        }
        input[type=text]{
                width: 50%;
                margin-bottom: 10px;
                padding: 8px;
        }
        input[type=tracking]{
                width: 50%;
                margin-bottom: 10px;
                padding: 8px;
        }

        </style>
    </head>
    <body>
        <h1>Employee Page - Inventory Management</h1>    
        <form method="POST">
            <button class="button home" name="home">Home 
                <i class="fa fa-home"></i>
            </button>
        </form>

        <?php
            
            try {
                drawTable($pdo->query("SELECT id, name, price, qty, type FROM Products;")->fetchAll(PDO::FETCH_ASSOC));
            } catch(PDOexception $error) {
                echo 'Query failed: ' . $error->getMessage();
            } 
        ?>

        

        <h2>Update inventory:</h2>
        <form method="POST">   
            <label for="itemID"><i class="fa fa-pencil"></i>
                Item to modify:</label>
            <input type="number" min="0" id="itemID" name="itemID"></br>
            <label for="qty"><i class="fa fa-sticky-note"></i>
                Quantity:</label>
            <input type="number" min="0" max="999" id="qty" name="qty"></br>
            <button class="button submit" name="modify" id="modify">
            Update quantity <i class="fa fa-check"></i>
            </button></br>
       
        </form>


    </body>
</html>