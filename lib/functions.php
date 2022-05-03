<?php 
/**
 * This function takes an id and reaches for the information of that item
 * @param itemid Id of the item
 * @param pdo SQL query
 * @return item Info of that item as an array
 */
function getItem($itemid, $pdo)
{
    $sql = <<<SQL
    SELECT id,name,image,price,qty
    FROM Products
    WHERE id = $itemid
    SQL;
    try {
        $statement = $pdo->query($sql);
        if($statement) {
            $item = $statement->fetchAll(PDO::FETCH_ASSOC);
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
    return $item;
}

/**
 * This function prints a cart item
 * @param itemarray A session array
 * @param num The number of items in a cart
 */
function printCartItem($itemarray, $num)
{   $subtotal = 0;
        foreach($itemarray as $info){
            $img = $info['image'];
            echo "<tr>";
            echo "<td>" . "<img src=$img  width='150' height='auto' >" . "</td>";
            echo "<td>" . $info['name'] . "</td>";
            echo "<td>" . $num . "</td>";
            echo "<td>" . "$" . $info['price'] . "</td>";
            echo "<td>" . "$" . $info['price'] * $num  . "</td>";
            echo "</tr>"; 
        }
        return $subtotal += $info['price'] * $num;
}

function selectUser($pdo){
    $sql ='SELECT UserID FROM User WHERE Name = :Name AND :BillingAddress = BillingAddress AND :ShippingAddress = ShippingAddress AND :Phone = Phone AND :Email = Email';
    $result = false;    
        try {
            $statement = $pdo->prepare($sql);
            if($statement) {
                    $result = $statement->execute([
                        ':Name' => $_POST['name'],
                        ':BillingAddress' => $_POST['billing_address'],
                        ':ShippingAddress' => $_POST['shipping_address'],
                        ':Phone' => $_POST['phone'],
                        ':Email' => $_POST['email']
                    ]);
                    //If user already exists, userID is the user from the above SELECT
                    if($statement->rowCount() == 1){
                    $userID = $statement->fetchColumn();
                    echo "userID which exists: ";
                    print_r($userID);
                    echo "</br>";
                    echo " User found, selecting from user table ";
                    echo "</br>";
                    }

                    //If the user does not exist in the table
                   if($statement->rowCount() == 0){
                       echo "</br>"; 
                       echo " User not found, inserting into user table ";
                       echo "</br>";
                       //insert into user table 
                       $sql ='INSERT INTO User (Name, BillingAddress, ShippingAddress, Phone, Email) VALUES (:Name, :BillingAddress, :ShippingAddress, :Phone, :Email)';
                       $result = false;  
                       $statement = $pdo->prepare($sql);
                       if($statement){
                        $result = $statement->execute([
                            ':Name' => $_POST['name'],
                            ':BillingAddress' => $_POST['billing_address'],
                            ':ShippingAddress' => $_POST['shipping_address'],
                            ':Phone' => $_POST['phone'],
                            ':Email' => $_POST['email']
                        ]);
                       }
                       //call getUser using POST array and fill userID with most recent user in User table
                       echo "most recent user: ";
                       $userID = $pdo->lastInsertId();
                       print_r($userID);
                    }
                   
            } else {
                echo " <p>Could not query  database for unknown reason.</p>\n";
            }
        } catch (PDOException $e){
            echo "    <p>Could not query from database. PDO Exception: {$e->getMessage()}</p>\n";
        }
        return $userID;
}

function getCartTotal($pdo){
    $orderTotal= NULL;
    foreach($_SESSION['cart'] as $pid => $quantity)
    {    
    $sql ='SELECT price FROM Products WHERE :PID = id';
    $result = false;    
        try {
            $statement = $pdo->prepare($sql);
            if($statement) {
                    $result = $statement->execute([
                        ':PID' => $pid,
                    ]);
                    echo "</br>"; 
                    echo " price found ";
                    echo "</br>";
            } else {
                echo "    <p>Could not query  database for unknown reason.</p>\n";
            }
        } catch (PDOException $e){
            echo "    <p>Could not query from database. PDO Exception: {$e->getMessage()}</p>\n";
        }       
         
        $orderTotal += $statement->fetchColumn();
        echo "</br>"; 
                    echo " the total is currently: ";
                    echo $orderTotal;
                    echo "</br>";
    }
    return $orderTotal;
}

function insertOrder($pdo, $userID, $orderTotal)
{
    $sql ='INSERT INTO Orders (Total, UserID) VALUES (:Total, :UserID)';
    $result = false;    
        try {
            $statement = $pdo->prepare($sql);
            if($statement) {
                    $result = $statement->execute([
                        ':Total' => $orderTotal,
                        ':UserID' => $userID 
                    ]);
                    echo "</br>"; 
                    echo " Order inserted into Orders table ";
                    echo "</br>";
            } else {
                echo "    <p>Could not query  database for unknown reason.</p>\n";
            }
        } catch (PDOException $e){
            echo "    <p>Could not query from database. PDO Exception: {$e->getMessage()}</p>\n";
        }       

    //Get most recent orderID to insert into OrderDetails table    
    echo " Order number: ";
    $orderID = $pdo->lastInsertId();
    print_r($orderID);
    return $orderID;
}

function insertOrderDetails($pdo, $userID, $orderTotal, $orderID)
{
    foreach($_SESSION['cart'] as $pid => $quantity)
    {   $itemPrice = NULL;
        $itemPrice = getItem($pid, $pdo);
        //print_r($itemPrice[0]);

        $sql ='INSERT INTO OrderDetails (UserID, OrderID, Price, QTYOrdered, ItemID) VALUES (:UserID, :OrderID, :Price, :QTYOrdered, :ItemID)';
        $result = false;    
        try {
            $statement = $pdo->prepare($sql);
            if($statement) {
                    $result = $statement->execute([
                        ':UserID' => $userID,
                        ':OrderID' => $orderID,
                        ':Price' => $itemPrice[0]['price'],
                        ':QTYOrdered' => $quantity,
                        ':ItemID' => $pid
                    ]);
                    echo "</br>"; 
                    echo "Row for PN $pid inserted into OrderDetails table ";
                    echo "</br>";
            } else {
                echo "    <p>Could not query  database for unknown reason.</p>\n";
            }
        } catch (PDOException $e){
            echo "    <p>Could not query from database. PDO Exception: {$e->getMessage()}</p>\n";
        }       

    }    
}

function createOrder($pdo)
{
    $userID = selectUser($pdo);
    $orderTotal	= getCartTotal($pdo);
    $orderID = insertOrder($pdo, $userID, $orderTotal);
    insertOrderDetails($pdo, $userID, $orderTotal, $orderID);

}

/*
function createOrder($pdo)
{
    //User find
    $sql ='SELECT UserID FROM User WHERE Name = :Name AND :BillingAddress = BillingAddress AND :ShippingAddress = ShippingAddress AND :Phone = Phone AND :Email = Email';
    $result = false;    
        try {
            $statement = $pdo->prepare($sql);
            if($statement) {
                    $result = $statement->execute([
                        ':Name' => $_POST['name'],
                        ':BillingAddress' => $_POST['billing_address'],
                        ':ShippingAddress' => $_POST['shipping_address'],
                        ':Phone' => $_POST['phone'],
                        ':Email' => $_POST['email']
                    ]);
                    //If user already exists, userID is the user from the above SELECT
                    if($statement->rowCount() == 1){
                    $userID = $statement->fetchColumn();
                    echo "userID which exists: ";
                    print_r($userID);
                    echo "</br>";
                    echo " User found, selecting from user table ";
                    echo "</br>";
                    }

                    //If the user does not exist in the table
                   if($statement->rowCount() == 0){
                       echo "</br>"; 
                       echo " User not found, inserting into user table ";
                       echo "</br>";
                       //insert into user table 
                       $sql ='INSERT INTO User (Name, BillingAddress, ShippingAddress, Phone, Email) VALUES (:Name, :BillingAddress, :ShippingAddress, :Phone, :Email)';
                       $result = false;  
                       $statement = $pdo->prepare($sql);
                       if($statement){
                        $result = $statement->execute([
                            ':Name' => $_POST['name'],
                            ':BillingAddress' => $_POST['billing_address'],
                            ':ShippingAddress' => $_POST['shipping_address'],
                            ':Phone' => $_POST['phone'],
                            ':Email' => $_POST['email']
                        ]);
                       }
                       //call getUser using POST array and fill userID with most recent user in User table
                       echo "most recent user: ";
                       $userID = $pdo->lastInsertId();
                       print_r($userID);
                    }
                   
            } else {
                echo " <p>Could not query  database for unknown reason.</p>\n";
            }
        } catch (PDOException $e){
            echo "    <p>Could not query from database. PDO Exception: {$e->getMessage()}</p>\n";
        }

    //Gets cart $ total to fill $orderTotal for inserting into Orders table
    $orderTotal= NULL;
    foreach($_SESSION['cart'] as $pid => $quantity)
    {    
    $sql ='SELECT price FROM Products WHERE :PID = id';
    $result = false;    
        try {
            $statement = $pdo->prepare($sql);
            if($statement) {
                    $result = $statement->execute([
                        ':PID' => $pid,
                    ]);
                    echo "</br>"; 
                    echo " price found ";
                    echo "</br>";
            } else {
                echo "    <p>Could not query  database for unknown reason.</p>\n";
            }
        } catch (PDOException $e){
            echo "    <p>Could not query from database. PDO Exception: {$e->getMessage()}</p>\n";
        }       
         
        $orderTotal += $statement->fetchColumn();
        echo "</br>"; 
                    echo " the total is currently: ";
                    echo $orderTotal;
                    echo "</br>";
    }

    //Order insert
    $sql ='INSERT INTO Orders (Total, UserID) VALUES (:Total, :UserID)';
    $result = false;    
        try {
            $statement = $pdo->prepare($sql);
            if($statement) {
                    $result = $statement->execute([
                        ':Total' => $orderTotal,
                        ':UserID' => $userID 
                    ]);
                    echo "</br>"; 
                    echo " Order inserted into Orders table ";
                    echo "</br>";
            } else {
                echo "    <p>Could not query  database for unknown reason.</p>\n";
            }
        } catch (PDOException $e){
            echo "    <p>Could not query from database. PDO Exception: {$e->getMessage()}</p>\n";
        }       

    //Get most recent orderID to insert into OrderDetails table    
    echo " Order number: ";
    $orderID = $pdo->lastInsertId();
    print_r($orderID);
   
    //Insert new order details into OrderDetails table   
    foreach($_SESSION['cart'] as $pid => $quantity)
    {   $itemPrice = NULL;
        $itemPrice = getItem($pid, $pdo);
        //print_r($itemPrice[0]);

        $sql ='INSERT INTO OrderDetails (UserID, OrderID, Price, QTYOrdered, ItemID) VALUES (:UserID, :OrderID, :Price, :QTYOrdered, :ItemID)';
        $result = false;    
        try {
            $statement = $pdo->prepare($sql);
            if($statement) {
                    $result = $statement->execute([
                        ':UserID' => $userID,
                        ':OrderID' => $orderID,
                        ':Price' => $itemPrice[0]['price'],
                        ':QTYOrdered' => $quantity,
                        ':ItemID' => $pid
                    ]);
                    echo "</br>"; 
                    echo "Row for PN $pid inserted into OrderDetails table ";
                    echo "</br>";
            } else {
                echo "    <p>Could not query  database for unknown reason.</p>\n";
            }
        } catch (PDOException $e){
            echo "    <p>Could not query from database. PDO Exception: {$e->getMessage()}</p>\n";
        }       

    }    
} */
?>

