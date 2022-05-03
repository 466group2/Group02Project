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

function createOrder($pdo)
{
    $sql ='INSERT INTO User (Name, BillingAddress, ShippingAddress, Phone, Email) VALUES (:Name, :BillingAddress, :ShippingAddress, :Phone, :Email)';
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

            } else {
                echo "    <p>Could not query  database for unknown reason.</p>\n";
            }
        } catch (PDOException $e){
            echo "    <p>Could not query from database. PDO Exception: {$e->getMessage()}</p>\n";
        }

    $sql ='INSERT INTO Orders (ItemID, Price, QTYOrdered, UserID) VALUES (:ItemID, :Price, :QTYOrdered, :UserID)';
    $result = false;    
        try {
            $statement = $pdo->prepare($sql);
            if($statement) {
                    $result = $statement->execute([
                        ':Price' => $_POST['name'],
                        ':ItemID' => $_POST['name'],
                        ':QTYOrdered' => $_POST['billing_address'],
                        ':UserID' => $_POST['shipping_address'],
                    ]);

            } else {
                echo "    <p>Could not query  database for unknown reason.</p>\n";
            }
        } catch (PDOException $e){
            echo "    <p>Could not query from database. PDO Exception: {$e->getMessage()}</p>\n";
        }       

        
}
?>

