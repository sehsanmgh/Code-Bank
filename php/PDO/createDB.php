<?php

$serverName = 'localhost';
$userName = 'root';
$password = '';

try{

    // $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    // $connection = new PDO("mysql:host=$serverName", $userName, $password, $options);
    $connection = new PDO("mysql:host=$serverName", $userName, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE testPDO";
    $connection->exec($sql);
    echo 'ok';
}
catch(PDOException $e){
    echo 'error ' . $e->getMessage();
}