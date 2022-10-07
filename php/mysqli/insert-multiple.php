<?php

$serverName = 'localhost';
$userName = 'root';
$password = '';
$dbName = 'dbTest';

$connection = mysqli_connect($serverName, $userName, $password, $dbName);

if(!$connection){
       die('failed ' . mysqli_connect_error());
  }
/*   
  $sql = "INSERT INTO `users` (id, username, password) VALUES (2, 'sara', '12345');";
  $sql .= "INSERT INTO `users` (id, username, password) VALUES (3, 'ali', '12345');";
  $sql .= "INSERT INTO `users` (id, username, password) VALUES (4, 'karim', '12345')"; */

/*   $sqls = [
     "INSERT INTO `users` (id, username, password) VALUES (2, 'sara', '12345');",
     "INSERT INTO `users` (id, username, password) VALUES (3, 'ali', '12345');",
  ];
 */


/*   if(mysqli_multi_query($connection, $sql)){
     echo 'success';
}
else{
     echo 'failed '. mysqli_error($connection);
} */

/* foreach ($sqls as $sql){
     if(mysqli_query($connection, $sql)){
          echo 'success';
     }
     else{
          echo 'failed '. mysqli_error($connection);
     }
} */
 
