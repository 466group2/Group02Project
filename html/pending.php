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
    // Go to inventory management if db button is clicked
    if(isset($_POST["db"]))
    {
        header("location:database.php");
    }
    //connect to mariadb
    $pdo = connectdb();

    if(isset($_POST["delete"])){
        $deleteArray = array("DELETE FROM Payment WHERE UserID = :UserID;",
        "DELETE FROM OrderDetails WHERE UserID = :UserID;",
        "DELETE FROM Orders WHERE UserID = :UserID;",
        "DELETE FROM User WHERE UserID = :UserID;");
        foreach($deleteArray as $stm)
        { 
            $sql = $stm;
    
            $result = false;    
            try {
                $statement = $pdo->prepare($sql);
                if($statement) {
                        $result = $statement->execute([
                            ':UserID' => $_POST['UserID']
                        ]);
                       
                } else {
                    echo "    <p>Could not query database for unknown reason.</p>\n";
                }
            } catch (PDOException $e){
                echo "    <p>Could not query from database. PDO Exception: {$e->getMessage()}</p>\n";
            }       
        }
        $usr = $_POST['UserID'];
        echo "</br>"; 
        echo "User# $usr's UserID, payment, and orders deleted.";
        echo "</br>";

    }

    if(isset($_POST["modify"]))
    {
        if($_POST['notes'] != NULL){
            $sql ='UPDATE Orders SET Notes = :notes WHERE OrderID = :orderID;';
            $result = false;    
            try {
                $statement = $pdo->prepare($sql);
                if($statement) {
                        $result = $statement->execute([
                            ':notes' => $_POST['notes'],
                            ':orderID' => $_POST['orderID']
                        ]);
                        echo "</br>"; 
                        echo "Notes updated.";
                        echo "</br>";
                } else {
                    echo "    <p>Could not query database for unknown reason.</p>\n";
                }
            } catch (PDOException $e){
                echo "    <p>Could not query from database. PDO Exception: {$e->getMessage()}</p>\n";
            }       
    
        }
        if($_POST['tracking'] != NULL){
            $sql ='UPDATE Orders SET TrackingNum = :tracking WHERE OrderID = :orderID;';
            $result = false;    
            try {
                $statement = $pdo->prepare($sql);
                if($statement) {
                        $result = $statement->execute([
                            ':tracking' => $_POST['tracking'],
                            ':orderID' => $_POST['orderID']
                        ]);
                        echo "</br>"; 
                        echo "Tracking updated.";
                        echo "</br>";
                } else {
                    echo "    <p>Could not query database for unknown reason.</p>\n";
                }
            } catch (PDOException $e){
                echo "    <p>Could not query from database. PDO Exception: {$e->getMessage()}</p>\n";
            }       
        }if($_POST['status'] != NULL){
            $sql ='UPDATE Orders SET Status = :status WHERE OrderID = :orderID;';
            $result = false;    
            try {
                $statement = $pdo->prepare($sql);
                if($statement) {
                        $result = $statement->execute([
                            ':status' => $_POST['status'],
                            ':orderID' => $_POST['orderID']
                        ]);
                        echo "</br>"; 
                        echo "Status updated.";
                        echo "</br>";
                } else {
                    echo "    <p>Could not query database for unknown reason.</p>\n";
                }
            } catch (PDOException $e){
                echo "    <p>Could not query from database. PDO Exception: {$e->getMessage()}</p>\n";
            }       
        }

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
            background-position: right bottom;
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
        .db{
            position: absolute;
            top: 60px;
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
        <h1>Employee Page - Pending Orders</h1>    
        <h2>Pending Orders below:</h2>
        <form method="POST">
            <button class="button home" name="home">Home 
                <i class="fa fa-home"></i>
            </button>
        </form>

        <form method="POST">
            <button class="button db" name="db">Inventory Management 
                <i class="fa fa-folder"></i>
            </button>
        </form>

        <?php drawTablePending($pdo); ?>

        <h2>Update Tracking, Status, and Notes:</h2>
        <form method="POST">   
            <label for="orderID"><i class="fa fa-pencil"></i>
                Order to modify:</label>
            <input type="number" id="orderID" name="orderID"></br>
            <label for="notes"><i class="fa fa-sticky-note"></i>
                Notes:</label>
            <input type="text" id="notes" name="notes"></br>
            <label for="tracking"><i class="fa fa-truck"></i>
                Tracking:</label>
            <input type="tracking" id="tracking" name="tracking"></br>
            <label for="status"><i class="fa fa-info-circle"></i>
                Status:</label>
            <input type="text" id="status" name="status"></br>
            <button class="button submit" name="modify" id="checkout">
            Modify order <i class="fa fa-check"></i>
            </button></br>
       
        </form>

        <h2>All orders not pending below:</h2>
        <?php drawTableOrders($pdo); ?>

        <h2>Users:</h2>   
        <?php 
        try {
        drawTable($pdo->query("SELECT * FROM User")->fetchAll(PDO::FETCH_ASSOC));
            } catch(PDOexception $error) {
                echo 'Query failed: ' . $error->getMessage();
            }
             
        ?>
            <br>
            <form method="POST">   
            <input type="number" id="UserID" name="UserID"
            placeholder="Please enter a User ID to delete their account.">
            <button class="button submit" name="delete" id="delete" value="delete">
            Delete user and their orders <i class="fa fa-trash"></i>
            </button>
       
        </form>

    </body>
</html>