<?php 
/*Alex Peterson Z1912480
CSCI 466 Group Project
Due 5/4/22 11:59p
library.php
*/

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
{
    echo "<table border='1'>
        <tr>
        <th>Image</th>
        <th>Name</th>
        <th>QTY</th>
        <th>Price</th>
        </tr>";

        foreach($itemarray as $info){
            $img = $info['image'];
            echo "<tr>";
            echo "<td>" . "<img src=$img  width='100' height='100' >" . "</td>";
            echo "<td>" . $info['name'] . "</td>";
            echo "<td>" . $num . "</td>";
            echo "<td>" . $info['price'] . "</td>";
            echo "</tr>";
        }
    echo "</table>";
}

?>

