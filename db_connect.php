<?php
    function db_connect(){
$username = 'root';
$password = 'root';
$pdo = new PDO("mysql:dbname=SoftTennis-Diary;host=localhost",$username,$password);
return $pdo;    
}
?>