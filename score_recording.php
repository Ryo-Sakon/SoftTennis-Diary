<?php


require_once ('settings.php');
require_once ('db_connect.php');
session_start();

var_dump($_SESSION);
exit();


$pdo = db_connect();

$i = $_SESSION['counter'];
$ourPointCount = $_SESSION['ourPointCount'];
$theirPointCount = $_SESSION['theirPointCount'];
$ourGameCount = $_SESSION['ourGameCount'];
$theirGameCount = $_SESSION['theirGameCount'];
$gameCount="{$ourGameCount}ー{$theirGameCount}";
$pointCount="{$ourPointCount}ー{$theirPointCount}";

$gameNumber = $ourGameCount + $theirGameCount + 1;
$finalGamePointNumber = $ourPointCount + $theirPointCount;

//サーバー・レシーバーの場合分け
switch ($gameNumber) {
    case $gameNumber == 1 || $gameNumber == 4 || $gameNumber == 5:{
            $server=$_SESSION['started_as_server'];
            $receiver=$_SESSION['started_as_receiver'];
            break;
        }
    case $gameNumber == 2 || $gameNumber == 3 || $gameNumber == 6:
        $server=$_SESSION['started_as_receiver'];
        $receiver=$_SESSION['started_as_server'];
        break;
    case 7:
        if ($finalGamePointNumber % 4 == 0 || $finalGamePointNumber % 4 == 1) {
            $server=$_SESSION['started_as_server'];
            $receiver=$_SESSION['started_as_receiver'];
            echo "ファイナルゲーム　Server：{$server}　Receiver：{$receiver}";
        } else {
            $server=$_SESSION['started_as_receiver'];
            $receiver=$_SESSION['started_as_server'];
            echo "ファイナルゲーム　Server：{$receiver}　Receiver：{$server}";
        }
        break;
}


//ポイント・ゲームの加算
if (isset($_POST['counterPlus'])) {
    $_SESSION['counter']++;
    header('Location:score_recording.php');
    exit();
}

if (isset($_POST['ourPointPlus'])) {

    $stmt = $pdo->prepare("INSERT INTO posts(match_id,match_title,pairs_id,players,opponents,Result,times_of_rallies,Server,Receiver,last_situation,game_count,point_count,Point) 
    VALUES(:match_id,:match_title,:id,:players,:opponents,:result,:times_of_rallies,:server,:receiver,:last_situation,:game_count,:point_count,:point)");
    $stmt->bindParam(':match_id',$_SESSION['match_id']);
    $stmt->bindParam(':match_title',$_SESSION['match_title']);
    $stmt->bindParam(':id',$_SESSION['pairs_id']);
    $stmt->bindParam(':players',$_SESSION['players']);
    $stmt->bindParam(':opponents',$_SESSION['opponents']);
    $stmt->bindValue(':result','WON');
    $stmt->bindParam(':times_of_rallies',$_SESSION['counter']);
    $stmt->bindParam(':server',$server);
    $stmt->bindParam(':receiver',$receiver);
    $stmt->bindValue(':last_situation','ストローク');
    $stmt->bindParam(':game_count',$gameCount);
    $stmt->bindParam(':point_count',$pointCount);
    $stmt->bindValue(':point','自分');
    $stmt->execute();
    
    // $stmt = $pdo->prepare("INSERT INTO posts(match_id,match_title,pairs_id,players,opponents,Result,times_of_rallies,Server,Receiver,last_situation,game_count,point_count,Point)
    // VALUES($_SESSION['match_id']),$_SESSION['match_title'],$_SESSION['pairs_id'],$_SESSION['players'],$_SESSION['opponents'],'WON',$_SESSION['counter'],$server,$receiver,'ストローク',$gameCount,$pointCount,'自分')");
    // $stmt->execute();

    $_SESSION['ourPointCount']++;
    $_SESSION['counter']=0;
    header('Location:score_recording.php');
    exit();

}
if (isset($_POST['theirPointPlus'])) {

    $stmt = $pdo->prepare("INSERT INTO posts(match_id,match_title,pairs_id,players,opponents,Result,times_of_rallies,Server,Receiver,last_situation,game_count,point_count,Point) 
    VALUES(:match_id,:match_title,:id,:players,:opponents,:result,:times_of_rallies,:server,:receiver,:last_situation,:game_count,:point_count,:point)");
    $stmt->bindParam(':match_id',$_SESSION['match_id']);
    $stmt->bindParam(':match_title',$_SESSION['match_title']);
    $stmt->bindParam(':id',$_SESSION['pairs_id']);
    $stmt->bindParam(':players',$_SESSION['players']);
    $stmt->bindParam(':opponents',$_SESSION['opponents']);
    $stmt->bindValue(':result','WON');
    $stmt->bindParam(':times_of_rallies',$_SESSION['counter']);
    $stmt->bindParam(':server',$server);
    $stmt->bindParam(':receiver',$receiver);
    $stmt->bindValue(':last_situation','スマッシュ');
    $stmt->bindParam(':game_count',$gameCount);
    $stmt->bindParam(':point_count',$pointCount);
    $stmt->bindValue(':point','相手');
    $stmt->execute();

    $_SESSION['theirPointCount']++;
    $_SESSION['counter']=0;
    header('Location:score_recording.php');
    exit();
}
if (isset($_POST['ourGamePlus'])) {
    $_SESSION['ourGameCount']++;
    $_SESSION['ourPointCount']=0;
    $_SESSION['theirPointCount']=0;
    $_SESSION['counter']=0;
    header('Location:score_recording.php');
    exit();
}
if (isset($_POST['theirGamePlus'])) {
    $_SESSION['theirGameCount']++;
    $_SESSION['ourPointCount']=0;
    $_SESSION['theirPointCount']=0;
    $_SESSION['counter']=0;
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
  <title><?=$title?></title>
  <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>

<body>
    <h1><?=$title?></h1>
<?php
echo "ペアID　".$_SESSION["pairs_id"]."　さん　頑張ってください！<br>";
echo $_SESSION[""];
?>
<a href="main.php">記録を中断してメニュー画面へ戻る</a><br><br>

<!-- 試合の基本情報 -->
<?php
echo '<span>試合タイトル：　</span>'.$_SESSION['match_title']. '<br>';
echo '<span>自分のペア：　</span>'.'後衛：' . $_SESSION['player_A'] . ' 前衛：' . $_SESSION['player_B'] . '<br>';
echo '<span>相手のペア：　</span>'.$_SESSION['opponents']. '<br>';
echo "第{$gameNumber}ゲーム目　Server：{$server}　Receiver：{$receiver}";
?>
    <p>ゲームカウント　自分：<?=$ourGameCount?>ー相手：<?=$theirGameCount?></p>
    <p>ポイントカウント　自分：<?=$ourPointCount?>ー相手：<?=$theirPointCount?></p>

<!-- ラリー数をカウント -->
<form action="" method="post">
<input type="submit" name="counterPlus" value="クリック">
</form>

<!-- クリック回数-->
<p>ラリーの持続回数：　<?=$i?>回</p>

<!-- ボールの持ち手 -->
<?php if ($i % 2 == 0) {
    echo "{$server}のボール";
} else {
    echo "{$receiver}のボール";
}
?>

<!-- ポイントの加算 -->
<p>ポイントが決まったら押してください↓</p>
<!-- 自分が得点 -->
<form action="" method="post">
<input type="submit" name="ourPointPlus" value="自分が得点しました">
</form>
<!-- 相手が得点 -->
<form action="" method="post">
<input type="submit" name="theirPointPlus" value="相手が得点しました">
</form>

<!-- ゲーム取得条件の追加（４点以上（７点）とっており、２ポイント以上差がある） -->
<?php
if ($ourGameCount < 4 && $theirGameCount < 4) {

    if ($gameNumber <= 6) { //ファイナルゲームでない場合
        if (($ourPointCount >= 4 || $theirPointCount >= 4) && abs($ourPointCount - $theirPointCount) >= 2) {
            if ($ourPointCount > $theirPointCount) {
                $gamePlus = "ourGamePlus";
            } else {
                $gamePlus = "theirGamePlus";
            }

            ?>

<p>次のゲームに進みますか？</p>
<!-- ゲームカウントの追加 -->
<form action="" method="post">
<input type="submit" name="<?=$gamePlus?>" value="進みます">
</form>

<?php
}
    }
    if ($gameNumber == 7) { //ファイナルゲームの場合
        if (($ourPointCount >= 7 || $theirPointCount >= 7) && abs($ourPointCount - $theirPointCount) >= 2) {
            if ($ourPointCount > $theirPointCount) {
                $gamePlus = "ourGamePlus";
            } else {
                $gamePlus = "theirGamePlus";
            }

            ?>
<form action="" method="post">
<input type="submit" name="<?=$gamePlus?>" value="進みます">
</form>

<?php
}
    }
} else {
    if ($ourGameCount > $theirGameCount) {
        echo "あなたの勝ちです。おめでとうございます！";
    } else {
        echo "あいての勝ちです。次は頑張りましょう！";

    }
    echo '<br>';
    echo '<a href="main.php">メニュー画面へ戻る</a>';
}

?>



</body>
</html>