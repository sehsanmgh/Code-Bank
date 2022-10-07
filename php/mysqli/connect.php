<?php

$serverName = 'localhost';
$userName = 'root';
$password = '';

$connetion = mysqli_connect($serverName, $userName, $password);

if(!$connetion){
   /*   echo 'failed';
     exit; */
     die('failed ' . mysqli_connect_error());
}

$sql = "CREATE DATABASE `dbTest`";
if(mysqli_query($connetion, $sql)){
     echo 'success';
}
else{
     echo 'failed '. mysqli_error($connetion);
}