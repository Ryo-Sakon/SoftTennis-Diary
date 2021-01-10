<?php
require_once('db_connect.php');
session_start();
$pdo=db_connect();


echo "ユーザーID　{$_SESSION["pairs_id"]}　さん　こんにちは";


//初期設定
if (empty($_POST)){
    $i = 0;
    $ourPointCount = 0;
    $theirPointCount = 0;
    $ourGameCount = 0;
    $theirGameCount = 0;

} else {
    //試合開始後の設定
    $i = $_POST['counter'];
    $ourPointCount = $_POST['ourPointCount'];
    $theirPointCount = $_POST['theirPointCount'];
    $ourGameCount = $_POST['ourGameCount'];
    $theirGameCount = $_POST['theirGameCount'];
}

//ポイント・ゲームの加算
if (isset($_POST['counterPlus'])) {
    $i++;
}

if (isset($_POST['ourPointPlus'])) {
    $ourPointCount++;
    $i = 0;
  $stmt=$PDO->prepare("INSERT INTO posts(pairs_id) VALUES()");
  $stmt->execute(array());

  }
if (isset($_POST['theirPointPlus'])) {
    $theirPointCount++;
    $i = 0;}
if (isset($_POST['ourGamePlus'])) {
    $ourGameCount++;
    $ourPointCount = 0;
    $theirPointCount = 0;
    $i = 0;}
if (isset($_POST['theirGamePlus'])) {
    $theirGameCount++;
    $ourPointCount = 0;
    $theirPointCount = 0;
    $i = 0;}

$server = $_GET['server'];
switch ($server) {
    case "自分":
        $receiver = "相手";
        break;
    case "相手":
        $receiver = "自分";
        break;
}
$gameNumber = $ourGameCount + $theirGameCount + 1;
$finalGamePointNumber = $ourPointCount + $theirPointCount;
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
    <h1>ソフトテニスダイアリー</h1>
    


    <form action="" method="get">
      <span>自分のペア</span>
      <input type="text" size="30" name="players" id="" placeholder="例：田中・鈴木（○○高校）"><br>
      <?php
      $stmt=$pdo->prepare("SELECT * FROM ");
      ?>
      <span>相手のペア</span>
      <input type="text" size="30" name="opponents" id="" placeholder="例：田中・鈴木（○○高校）"><br>

      
      <span>サービス権をとったのはどっち？</span>
      <input type="radio" name="server" value="自分">自分
      <input type="radio" name="server" value="相手">相手
      <input type="submit" value="記録開始">
    </form>

    <?php

switch($gameNumber){
  case $gameNumber == 1 || $gameNumber == 4 || $gameNumber == 5:{
        echo "第{$gameNumber}ゲーム目　Server：{$server}　Receiver：{$receiver}";
        break;
}
case $gameNumber == 2 || $gameNumber == 3 || $gameNumber == 6:
        echo "第{$gameNumber}ゲーム目　Server：{$receiver}　Receiver：{$server}";
        break;
    case 7:
        if($finalGamePointNumber%4==0 || $finalGamePointNumber%4==1){
        echo "ファイナルゲーム　Server：{$server}　Receiver：{$receiver}";
        }else{
        echo "ファイナルゲーム　Server：{$receiver}　Receiver：{$server}";
        }        
        break;
      }
    



?>
      <p>ゲームカウント　自分：<?=$ourGameCount?>ー相手：<?=$theirGameCount?></p>
      <p>ポイントカウント　自分：<?=$ourPointCount?>ー相手：<?=$theirPointCount?></p>

<!-- ラリー数をカウント -->
<form action="" method="post">
<input type="hidden" name="ourPointCount" value="<?=$ourPointCount?>">
<input type="hidden" name="theirPointCount" value="<?=$theirPointCount?>">
<input type="hidden" name="ourGameCount" value="<?=$ourGameCount?>">
<input type="hidden" name="theirGameCount" value="<?=$theirGameCount?>">
<input type="hidden" name="counter" value="<?=$i?>">
<input type="submit" name="counterPlus" value="クリック">
</form>

<!-- クリック回数-->
<p><?=$i?>回</p>

<!-- ボールの持ち手 -->
<?php if ($i % 2 == 0) {
    echo "{$server}のボール";
} else {
    echo "{$receiver}のボール";
}
?>

<!-- ポイントの加算 -->
<p>ポイントが決まったら押す</p>
<!-- 自分が得点 -->
<form action="" method="post">
<input type="hidden" name="ourPointCount" value="<?=$ourPointCount?>">
<input type="hidden" name="theirPointCount" value="<?=$theirPointCount?>">
<input type="hidden" name="ourGameCount" value="<?=$ourGameCount?>">
<input type="hidden" name="theirGameCount" value="<?=$theirGameCount?>">
<input type="hidden" name="counter" value="<?=$i?>">
<input type="submit" name="ourPointPlus" value="自分が得点しました">
</form>
<!-- 相手が得点 -->
<form action="" method="post">
<input type="hidden" name="ourPointCount" value="<?=$ourPointCount?>">
<input type="hidden" name="theirPointCount" value="<?=$theirPointCount?>">
<input type="hidden" name="ourGameCount" value="<?=$ourGameCount?>">
<input type="hidden" name="theirGameCount" value="<?=$theirGameCount?>">
<input type="hidden" name="counter" value="<?=$i?>">
<input type="submit" name="theirPointPlus" value="相手が得点しました">
</form>

<!-- ゲーム取得条件の追加（４点以上（７点）とっており、２ポイント以上差がある） -->
<?php
if ($ourGameCount<4 && $theirGameCount<4) {

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
<input type="hidden" name="ourGameCount" value="<?=$ourGameCount?>">
<input type="hidden" name="theirGameCount" value="<?=$theirGameCount?>">
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
<input type="hidden" name="ourGameCount" value="<?=$ourGameCount?>">
<input type="hidden" name="theirGameCount" value="<?=$theirGameCount?>">
<input type="submit" name="<?=$gamePlus?>" value="進みます">
</form>

<?php
}
}
}
else{
  if ($ourGameCount > $theirGameCount) {
        echo "あなたの勝ちです。おめでとうございます！";
    } else {
        echo "あいての勝ちです。次は頑張りましょう！";

    }
}

?>



</body>
</html>