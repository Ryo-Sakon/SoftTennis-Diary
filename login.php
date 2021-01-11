<?php
require_once('settings.php');
require_once('db_connect.php');
session_start();

if(isset($_POST["pairs_id"]) && $_POST["pairs_id"]!=""){

        
    $pdo=db_connect();
    $stmt=$pdo->prepare("SELECT * FROM pairs WHERE pairs_login_id = :id ");
    $stmt->bindParam(':id', $_POST["pairs_id"]);   
    $stmt->execute();
    
    $array=$stmt->fetch(PDO::FETCH_ASSOC);
    
    

if($array["pairs_login_id"]==$_POST["pairs_id"] && $array["password"]==$_POST["password"]){

    $_SESSION["pairs_id"]=$array["pairs_id"];
    $_SESSION["player_A"]=$array["player_A"];
    $_SESSION["player_B"]=$array["player_B"];
    

    header('Location:main.php');
    exit();

}
}

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
  <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<body>
    <h1><?=$title?></h1>
    <h1>ログイン画面</h1>
    <a href="signUp.php">新規登録はこちら</a><br>
    <form action="" method="post">
<span>ペアID</span><input type="text" name="pairs_id">
<span>パスワード</span><input type="password" name="password">
<input type="submit" value="ログイン">
</form>


</body>
</html>
