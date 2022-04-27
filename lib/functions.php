<?php 
/*Alex Peterson Z1912480
CSCI 466 Assignment 9 PHP with forms
Due 4/8/22 11:59p
library.php
*/
//This function prints the tables and rows using the info from the SQL in drawTableName
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

//This function calls the query to get table row information and then passes it into drawTable
function drawTableName(&$pdo, $tableName){
    try {
        drawTable($pdo->query("SELECT * FROM $tableName;")->fetchAll(PDO::FETCH_ASSOC));
    } catch(PDOexception $error) {
        echo 'Query failed: ' . $error->getMessage();
    }
}

//Deduct qty of a part from a supplier
function buy(&$pdo, $supp, $part, $qty){
    $sql = 'UPDATE SP SET QTY = QTY - :QTY WHERE S=:S AND P=:P';
    $result = false;
    try {
        $stmnt = $pdo->prepare($sql);
        $result = $stmnt->execute([
            ':QTY' => $qty,
            ':S' => $supp,
            ':P' => $part
        ]);
    } catch (PDOexception $error) {
        echo '    <p> Query failed: ' . $error->getMessage() . "</p>\n";
    }
    return $result;
}

//Add inventory to a supplier, either update an existing qty or add a new entry with that qty 
function addinv(&$pdo, $supp, $part, $qty){
    //Return the number of cells from SP table where S and P match request
    $sql = 'SELECT COUNT(*) FROM SP WHERE S=:S AND P=:P';
    try {
        $stmnt = $pdo->prepare($sql);
        $result = $stmnt->execute([
            ':S' => $supp,
            ':P' => $part
        ]);
        //Fill in variables for printing
        $suppname = getSuppName($pdo, $supp);
        $partname = getPartName($pdo,$part);
        $color = getColor($pdo, $part);
        
        if($result){
            // Insert the new item into SP 
            if($stmnt->fetchColumn() == 0){
                $sql = 'INSERT INTO SP (S,P,QTY) VALUES (:S,:P,:QTY);';
                echo "<p>You've inserted a new entry of quantity {$_POST['QTY']} PN#{$_POST['P']} $color $partname to {$_POST['S']} {$suppname}.</p>\n";
            } else { 
                // Update the qty of S based on QTY given 
                $sql = 'UPDATE SP SET QTY = :QTY WHERE S=:S AND P=:P';
                echo "<p>You've adjusted quantity {$_POST['QTY']} of PN#{$_POST['P']}  $color $partname to {$_POST['S']} {$suppname}.</p>\n";
            }
        } else {
            echo "    <p> Query failed for unknown reason. </p>\n";
        }       
    } catch (PDOexception $error) {
        echo '    <p> Query failed: ' . $error->getMessage() . "</p>\n";
        return false;
    }

    // Reset $result for next try-catch
    $result = false;
    try {
        //Execute either the INSERT or UPDATE from above 
        $stmnt = $pdo->prepare($sql);
        $result = $stmnt->execute([
            ':QTY' => $qty,
            ':S' => $supp,
            ':P' => $part
        ]);
    } catch (PDOexception $error) {
        echo '    <p> Query failed: ' . $error->getMessage() . "</p>\n";
    }
    return $result;
}

//Checks to see if a cell of $value exists in the S table 
function checkCellCountS(&$pdo, $value){
    $sql = 'SELECT COUNT(*) FROM S WHERE S = :value;';
    try {
        $stmnt = $pdo->prepare($sql);
        $result = $stmnt->execute([
            ':value' => $value
        ]);
        return (int)$stmnt->fetchColumn(); 
    } catch (PDOexception $error) {
        echo '    <p> Query failed: ' . $error->getMessage() . "</p>\n";
        return false;
    }
}

//Checks to see if a cell of $value exists in the P table 
function checkCellCountP(&$pdo, $value){
    $sql = 'SELECT COUNT(*) FROM P WHERE P = :value;';
    try {
        $stmnt = $pdo->prepare($sql);
        $result = $stmnt->execute([
            ':value' => $value
        ]);
        return (int)$stmnt->fetchColumn(); 
    } catch (PDOexception $error) {
        echo '    <p> Query failed: ' . $error->getMessage() . "</p>\n";
        return false;
    }
}

//Checks to see if $part is available from a supplier $supp
function getPartAvail(&$pdo, $supp, $part){
    $partAvail = 0;
    $sql = 'SELECT QTY FROM SP WHERE P=:P AND S=:S';
    try {
        $stmnt = $pdo->prepare($sql);
        $result = $stmnt->execute([
            ':S' => $supp,
            ':P' => $part
        ]);
        if($result){
            //If now rows are returned
            if($stmnt->rowCount() == 0){
                echo "    <p> $part is not sold by $supp. </p>\n";
            } else { 
                //Store the quantity available in $partAvail
                $partAvail = $stmnt->fetchColumn();
            }
        } else {
            echo "    <p> Query failed for unknown reason. </p>\n";
        }       

    } catch (PDOexception $error) {
        echo '    <p> Query failed: ' . $error->getMessage() . "</p>\n";
    }
    return $partAvail;
}

function getColor(&$pdo, &$part){
    $sql = 'SELECT COLOR FROM P WHERE P = :P';
    try {
        $stmnt = $pdo->prepare($sql);
        $stmnt->execute([
            ':P' => $part,
        ]);
        return $stmnt->fetchColumn();
    } catch (PDOexception $error) {
        echo '    <p> Query failed: ' . $error->getMessage() . "</p>\n";
    }
    }

function getPartName($pdo,$part){
    $sql = 'SELECT PNAME FROM P WHERE P = :P';
    try {
        $stmnt = $pdo->prepare($sql);
        $stmnt->execute([
            ':P' => $part,
        ]);
        return $stmnt->fetchColumn();
    } catch (PDOexception $error) {
        echo '    <p> Query failed: ' . $error->getMessage() . "</p>\n";
    }
}

function getSuppName($pdo,$supp){
    $sql = 'SELECT SNAME FROM S WHERE S = :S';
    try {
        $stmnt = $pdo->prepare($sql);
        $stmnt->execute([
            ':S' => $supp,
        ]);
        return $stmnt->fetchColumn();
    } catch (PDOexception $error) {
        echo '    <p> Query failed: ' . $error->getMessage() . "</p>\n";
    }
}
?>

