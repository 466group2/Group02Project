<?php
declare(strict_types = 1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>CSCI 466 Group Project</h1>    
    <h2>Welcome to The Norvinsk Region</h2>

   

    





<?php
include 'secrets.php';
include 'library.php';

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