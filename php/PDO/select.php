<?php

$serverName = 'localhost';
$userName = 'root';
$password = '';
$dbName = 'w3schools';

try{

    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ);
    $connection = new PDO("mysql:host=$serverName;dbname=$dbName", $userName, $password, $options);
    // $connection = new PDO("mysql:host=$serverName;dbname=$dbName", $userName, $password);
    // $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM `categories`";
    $statement = $connection->query($sql);
    $categories = $statement->fetchAll();
    echo '<pre>';
    // var_dump($categories[0]['CategoryName']);
    // var_dump($categories[0]->CategoryID);
    // foreach($categories as $category){
        // echo $category['CategoryID'] . ' ' . $category['CategoryName'] . '<br>';
        // $category->CategoryID
    // }
    foreach($categories as $category){
        echo $category->CategoryID . ' ' . $category->CategoryName . '<br>';
    }
}
catch(PDOException $e){
    echo 'error ' . $e->getMessage();
}