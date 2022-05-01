<?php
include '../config/secrets.php';

//Connect to mariadb
function connectdb() {
    global $dbname;
    global $dbpassword;
    global $dbusername;
    try {
        $dsn = "mysql:host=courses;dbname=$dbname";
        $pdo = new PDO($dsn, $dbusername, $dbpassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    } 
    catch(PDOException $error){  
        die('    <p> Connection to database failed: ' . $error->getMessage() . "</p>\n </body></html>"); 
    }

    return $pdo;
}
?>