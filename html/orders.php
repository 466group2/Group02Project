<?php
declare(strict_types = 1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
?>

<?php
include '../lib/db.php';
include '../lib/functions.php';
// Go home if home button is clicked
if(isset($_POST["home"]))
{
    header("location:home.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
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
        .tack{
            position: relative;
            font-size: 25px;
            margin: 20px 10px;
        }
    </style>
</head>
<body>
    <form method="POST">
        <button class="button home" name="home">
            Home <i class="fa fa-home"></i>
        </button>
    </form>
    <h1>Order History</h1>    
    <h2>Check your order info and its current status</h2>
    <form method="POST">
        Order Number: <input type="text" id="ORDER_ID"/>
        <br>
        <button class="button track" name="track">
            Track <i class="fa fa-truck"></i>
        </button>
    </form>
<?php
//Connect to mariadb
try {
    $dsn = "mysql:host=courses;dbname=$dbname";
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch(PDOexception $error){  
    die('    <p> Connection to database failed: ' . $error->getMessage() . "</p>\n </body></html>"); 
} ?>
</body>
</html>