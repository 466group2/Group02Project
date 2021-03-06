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
 * @return subtotal The subtotal of the cart
 */
function printCartItem($itemarray, $num)
{   $subtotal = 0;
    $currentPage= $_SERVER['SCRIPT_NAME'];  // Get the current file name
        foreach($itemarray as $info){
            $img = $info['image'];
            echo "<tr>";
            echo "<td>" . "<img src=$img  width='150' height='auto' >" . "</td>";
            echo "<td>" . $info['name'] . "</td>";
            echo "<td>" . $num . "</td>";
            echo "<td>" . "$" . $info['price'] . "</td>";
            echo "<td>" . "$" . $info['price'] * $num  . "</td>";
            if(basename($currentPage) == 'cart.php'){   // Only show editing quantity option if in cart page
                echo <<<HTML
                <td><form method='POST'>
                    <table><tr><input type='number' value='{$num}' min='0' max="{$itemarray[0]['qty']}" name='SUB'>
                    <button><i class='fa fa-edit'></i></button> </tr></table>
                    <input type='hidden' value="{$info['id']}" name ='ID'>
                    <input type='hidden' value="{$num}" name ='QTY'>
                </form></td>
                HTML;
                echo "</tr>";
            }
        }
        return $subtotal += $info['price'] * $num;
}

/**
 * Function to search for and return the userID of a user
 * @param pdo An sql query
 * @return userID The userID of the user
 */
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
                    if($statement->rowCount()){
                    $userID = $statement->fetchColumn();
                    }

                    //If the user does not exist in the table
                   if($statement->rowCount() == 0){
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
                       $userID = $pdo->lastInsertId();
                      
                    }
                   
            } else {
                echo " <p>Could not query  database for unknown reason.</p>\n";
            }
        } catch (PDOException $e){
            echo "    <p>Could not query from database. PDO Exception: {$e->getMessage()}</p>\n";
        }
        return $userID;
}

/**
 * Get the current amount of the shopping cart
 * @param pdo An sql query
 * @return orderTotal The current amount of the shopping cart
 */
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
            } else {
                echo "    <p>Could not query  database for unknown reason.</p>\n";
            }
        } catch (PDOException $e){
            echo "    <p>Could not query from database. PDO Exception: {$e->getMessage()}</p>\n";
        }       
         
        $orderTotal += $statement->fetchColumn();
    }
    return $orderTotal;
}

/**
 * Insert into Orders table if a user made a purchase. It also returns the order ID 
 * @param pdo An sql query
 * @param userID The user ID of the user that made a purchase
 * @param orderTotal The total of the purchase
 * @return orderID The order ID of the recetly inserted order
 */
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
            } else {
                echo "    <p>Could not query  database for unknown reason.</p>\n";
            }
        } catch (PDOException $e){
            echo "    <p>Could not query from database. PDO Exception: {$e->getMessage()}</p>\n";
        }       

    //Get most recent orderID to insert into OrderDetails table    
    $orderID = $pdo->lastInsertId();
    return $orderID;
}

/**
 * Insert everything from the shopping cart into OrderDetails table
 * @param pdo An sql query
 * @param userID The user ID of the user who made the purchase
 * @param orderTotal The total of the purchase
 * @param orderID The order ID of the purchase
 */
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
            } else {
                echo "    <p>Could not query  database for unknown reason.</p>\n";
            }
        } catch (PDOException $e){
            echo "    <p>Could not query from database. PDO Exception: {$e->getMessage()}</p>\n";
        }       

    }    
}

/**
 * Insert into Payment table credit card information
 * @param pdo An sql query
 * @param userID The user ID of the user who made a purchase
 * @param orderTotal The total order of the purchase
 * @param orderID The order ID of the purchase
 */
function insertCC($pdo, $userID, $orderTotal, $orderID){
        $sql ='INSERT INTO Payment (CreditCardInfo, PaymentAmount, UserID, OrderID) VALUES (:CreditCardInfo, :PaymentAmount, :UserID, :OrderID)';
        $result = false;    
        try {
            $statement = $pdo->prepare($sql);
            if($statement) {
                    $result = $statement->execute([
                        ':CreditCardInfo' => $_POST['credit_card'],
                        ':PaymentAmount' => $orderTotal,
                        ':UserID' => $userID,
                        ':OrderID' => $orderID
                    ]);
                    $cc = $_POST['credit_card'];
            } else {
                echo "    <p>Could not query  database for unknown reason.</p>\n";
            }
        } catch (PDOException $e){
            echo "    <p>Could not query from database. PDO Exception: {$e->getMessage()}</p>\n";
        }       

}    

/**
 * Create an order if a customer has made a purchase
 * @param pdo An sql query
 * @return userinfo An array containing user ID and order ID
 */
function createOrder($pdo)
{   
    $userID = selectUser($pdo);
    $orderTotal	= getCartTotal($pdo);
    $orderID = insertOrder($pdo, $userID, $orderTotal);
    insertOrderDetails($pdo, $userID, $orderTotal, $orderID);
    insertCC($pdo, $userID, $orderTotal, $orderID);
    return $userinfo = array($userID, $orderID);
}

/**
 * Function to draw a table using an sql query
 * @param rows An sql query
 */
function drawTable($rows) {
    if(empty($rows)){
        echo "    <p>No results found.</p>\n";
    } else {
        echo "    <table border=1 cellspacing=1>\n";
        echo "        <tr>\n";
        // Table Headers
        foreach($rows[0] as $key => $value){
            echo "            <th>$key</th>\n";
        }
        echo "        </tr>\n";
        // Table Body
        foreach($rows as $row){
            // Table Row
            echo "        <tr>\n";
            foreach($row as $key => $value){
                // Table Cell
                echo "            <td>$value</td>\n";
            }
            echo "        </tr>\n";
        }
        echo "    </table>\n"; 
    }
}

/**
 * This function calls the query to get table row information and then passes it into drawTable
 * @param pdo An sql query
 */
function drawTablePending(&$pdo){
    try {
        drawTable($pdo->query("SELECT * FROM Orders WHERE Status = 'Pending';")->fetchAll(PDO::FETCH_ASSOC));
    } catch(PDOexception $error) {
        echo 'Query failed: ' . $error->getMessage();
    }
}

/**
 * Function to draw out an orders table
 * @param pdo An sql query
 */
function drawTableOrders(&$pdo){
    try {
        drawTable($pdo->query("SELECT * FROM Orders WHERE NOT Status = 'Pending';")->fetchAll(PDO::FETCH_ASSOC));
    } catch(PDOexception $error) {
        echo 'Query failed: ' . $error->getMessage();
    }
}

/**
 * Remove from Products the amount after a customer has made a purche
 * @param merch The prodcut ID of the item to remove
 * @param howmuch The quantity to be removed from Prodcuts table
 * @param pdo An sql query
 * @return result The result of the query
 */
function buy($merch, $howmuch, &$pdo){
        $sql = 'UPDATE Products SET qty = qty - :QTY WHERE id=:id';
        $result = false;
        try {
            $stmnt = $pdo->prepare($sql);
            $result = $stmnt->execute([
                ':QTY' => $howmuch,
                ':id' => $merch
            ]);
        } catch (PDOexception $error) {
            echo '    <p> Query failed: ' . $error->getMessage() . "</p>\n";
        }
        return $result;
    }

?>