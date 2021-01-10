<?php
require_once ('settings.php');
session_start();
if(isset($_GET["opponents"]) && $_GET["opponents"]!=""){

    $_SESSION['match_title']=$_GET['match_title'];
    $_SESSION['opponents']=$_GET['opponents'];
    $_SESSION['server']=$_GET['server'];

    header('Location:score_recording.php');
    exit();

}


?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><<?=$title?>/title>
<link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<body>

<h1><?=$title?></h1>
<form action="" method="get">
<span>試合タイトル</span><input type="text" size="30" name="match_title" id="" placeholder="例：練習試合（○○高校）第○試合"><br>
<span>相手のペア</span><input type="text" size="30" name="opponents" id="" placeholder="例：田中・鈴木（○○高校）"><br>


    <span>サービス権をとったのはどっち？</span>
    <input type="radio" name="server" value="自分">自分
    <input type="radio" name="server" value="相手">相手
    <input type="submit" value="記録開始">
</form>
</body>
</html>