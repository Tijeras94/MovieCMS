<?php
$servername = "localhost";
$username = "root";
$password = "toor";

try {
    $conn = new PDO("mysql:host=$servername", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    

    $conn->exec("create database MovieCMS;");

    $sql = "GRANT ALL PRIVILEGES ON *.* TO 'root'@'%';";
    // use exec() because no results are returned
    $conn->exec($sql);

     $sql = "SET PASSWORD FOR 'root'@'%' = PASSWORD('toor');";
    // use exec() because no results are returned
    $conn->exec($sql);
    echo "Database updated successfully<br>";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;
?>