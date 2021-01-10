<?php
require_once('settings.php');
require_once('db_connect.php');


if(isset($_POST)){
$pdo=db_connect();
$stmt=$pdo->prepare("INSERT INTO pairs(pairs_id,password,player_A,player_B,Team) VALUES(:id,:password,:A,:B,:team)");
$stmt->execute(array(':id'=>$_POST['id'],':password'=>$_POST['password'],':A'=>$_POST['player_A'],':B'=>$_POST['player_B'],':team'=>$_POST['team']));
echo '登録しました。<br>';
echo "<a href='login.php'>ログイン画面</a>";

}
//バインド
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
    <h1>登録画面</h1>
    <form action="" method="post">
<span>ペアID</span><input type="text" name="id"><br>
<span>player A</span><input type="text" name="player_A" placeholder="例：庭球太郎"><br>
<span>player B</span><input type="text" name="player_B" placeholder="例：庭球次郎"><br>
<span>所属名</span><input type="text" name="team" placeholder="例：○○高校"><br>
<span>パスワード</span><input type="password" name="password"><br>
<span>パスワード（確認）</span><input type="password">
<input type="submit" value="新規登録">
</form>


</body>
</html>
