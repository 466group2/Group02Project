<?php
declare(strict_types = 1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
include '../lib/db.php';
include '../lib/functions.php';
?><!DOCTYPE html>
<html lang="en">

<?php   
$var = $_GET["id"];
$sql = <<<SQL
  SELECT id,type
  FROM Products
  WHERE id = "$var"
  
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
        echo "    <p>Could not query medicine items from database for unknown reason.</p>\n";
    }
} catch (PDOException $e){
    echo "    <p>Could not query medicine items from database. PDO Exception: {$e->getMessage()}</p>\n";
}

$image = "img/labs1.webp";
switch($rows[0]['type']){
    case 'Armor': 
        $image = "img/interchange.jpg";
        break;
    case 'Medicine': 
        $image = "img/labs1.webp";
        break;
    case 'Food': 
        $image = "img/goshan.webp";
        break;
}

?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item</title>
    <link rel="stylesheet" href="style.css">
    
    <style>   
        body {
        height: 100%;
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        background-image: url("<?php echo $image; ?>") !important;
        max-width: 1300px !important;
        margin: auto !important;
        }
        .row { background-color: rgba(0, 0, 0, 0.5); }
        /* Three image containers (use 25% for four, and 50% for two, etc) *****/
        .column {
            float: left;
            width: 40%;
            padding:5px;
            text-align: left;
        }
        /* Clear floats after image containers */
        .row::after {
            content: "";
            clear: both;
            display: table;
        }
        img{
            width:100%;
            height:auto;
            max-width: 1000px;
        }
        .button {
        background-color: #4CAF50; /* Green */
        border: none;
        color: white;
        padding: 4px 16px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 25px;
        margin: 0;
        transition-duration: 0.4s;
        cursor: pointer;
        }
        .button1 {
        background-color: grey; 
        color: black; 
        border: 2px solid #4CAF50;
        }
        .button1:hover {
        background-color: #4CAF50;
        color: white;
        }
    </style>
</head>
<body>
<!---  ARRAY DISPLAY FOR DEBUG
        <h2>GET</h2>
            <pre>
        <?php print_r($_GET); ?>
            </pre>

            <h2>POST</h2>
            <pre>
        <?php print_r($_POST); ?>
            </pre>
 ARRAY DISPLAY FOR DEBUG--->
<?php
$var = $_GET["id"];
$sql = <<<SQL
  SELECT *
  FROM Products
  WHERE id = "$var"
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
        echo "    <p>Could not query medicine items from database for unknown reason.</p>\n";
    }
} catch (PDOException $e){
    echo "    <p>Could not query medicine items from database. PDO Exception: {$e->getMessage()}</p>\n";
}
if (!empty($rows)) {
        $row = $rows[0];
        echo <<<HTML
            <h1>{$row['name']}</h1>
            <h2>{$row['tagline']}</h2>
            <div class="row">\n
        HTML;
        
           echo <<<HTML
                   <div class="column">
                        <img src="{$row['image']}" class="item" />  
                        
                      
                   </div>\n
                   <div class="column">
                        
                        <h3>{$row['description']}</h3>\n
                        <h3>$ {$row['price']}<h3>
                        <form action="" method="POST">
                        <label for=""></label>
                        &nbsp;<label for="quantity">QTY:</label>
                        <input type="number" min="0" id="quantity" name="QTY">
                        <input type="submit" value="Add to cart">
                        
                        </form>
                      
                   </div>\n

            HTML; 
        }
        echo "    </div>\n";
    
?>
<?php if(isset($_POST["home"]))  
    {  
        header("location:home.php"); 
    }?>
    <form method="POST">    
    <button class="button button1" name="home">Back to home</button> 
    </form>
<pre>
        <?php print_r($rows[0]); ?>
            </pre>
</body>
</html>