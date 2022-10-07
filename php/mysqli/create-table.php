<?php

$serverName = 'localhost';
$userName = 'root';
$password = '';
$dbName = 'dbTest';

$connection = mysqli_connect($serverName, $userName, $password, $dbName);

if(!$connection){
       die('failed ' . mysqli_connect_error());
  }
  
  $sql = "CREATE TABLE `users` (`id` int NOT NULL, `username` varchar(255), `password` varchar(255))";
  if(mysqli_query($connection, $sql)){
     echo 'success';
}
else{
     echo 'failed '. mysqli_error($connection);
}
