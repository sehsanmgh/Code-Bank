<?php

$serverName = 'localhost';
$userName = 'root';
$password = '';
$dbName = 'dbTest';

$connection = mysqli_connect($serverName, $userName, $password, $dbName);

if(!$connection){
       die('failed ' . mysqli_connect_error());
  }
  
  $sql = "INSERT INTO `users` (id, username, password) VALUES (1, 'hassan', '12345')";
  if(mysqli_query($connection, $sql)){
     echo 'success';
}
else{
     echo 'failed '. mysqli_error($connection);
}
