<?php
if ($_POST['counter'] & $_POST['ourPoint'] & $_POST['theirPoint'] & $_POST['ourGame'] & $_POST['theirPoint'] ==null){ 
$i=0;
$ourPointCount=0;
$theirPointCount=0;
$ourGameCount=0;
$theirGameCount=0;
$gameNumber=$ourGameCount+$theirGameCount+1;
}else{
$i=$_POST['counter'];
$ourPointCount=$_POST['ourPointCount'];
$theirPointCount=$_POST['theirPointCount'];
$ourGameCount=$_POST['ourGameCount'];
$theirGameCount=$_POST['theirGameCount'];
}

if (isset($_POST['counter'])) {
  $i++;
}
if (isset($_POST['ourPoint'])) {
  $ourPointCount++;
$i=0;}
if (isset($_POST['theirPoint'])) {  $theirPointCount++;
  $i=0;}
if (isset($_POST['ourGame'])) {  $ourGameCount++;
$ourPointCount=0;
$theirPointCount=0;
$i=0;}
if (isset($_POST['theirGame'])) {  $theirGameCount++;
  $ourPointCount=0;
$theirPointCount=0;
$i=0;}

$server = $_GET['which'];

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
      <input type="text" name="player" id="" placeholder="例：田中・鈴木">

      <span>相手のペア</span>
      <input type="text" name="player" id="" placeholder="例：田中・鈴木">

      <br>
      <span>サーブ権をとったのはどっち？</span>
      <input type="radio" name="which" value="ourselves">自分
      <input type="radio" name="which" value="themselves">相手

      <input type="submit" value="記録開始">
    </form>


      <p>第<?=$gameNumber?>ゲーム目</p>
      <p>ゲームカウント　自分：<?=$ourGameCount?>ー相手：<?=$theirGameCount?></p>
      <p>ポイントカウント　自分：<?=$ourPointCount?>ー相手：<?=$theirPointCount?></p>

      <form action="" method="post">
      <input type="hidden" name="ourPointCount" value="<?=$ourPointCount?>">
<input type="hidden" name="theirPointCount" value="<?=$theirPointCount?>">
        <input type="hidden" name="counter" value="<?=$i?>">
        <input type="submit" value="クリック">
      </form>
      <p><?=$i?>回</p>
      <?php if ($i % 2 == 0) {
    echo "自分のボール";

} else {
    echo "相手のボール";
}
?>
<p>ポイントが決まったら押す</p>
<form action=""  name="game" method="post">
<input type="hidden" name="ourPointCount" value="<?=$ourPointCount?>">
<input type="hidden" name="theirPointCount" value="<?=$theirPointCount?>">

        <input type="submit" name="ourPoint" value="自分が得点しました">

      </form>

      <form action="" name="game" method="post">
<input type="hidden" name="theirPointCount" value="<?=$theirPointCount?>">
<input type="hidden" name="ourPointCount" value="<?=$ourPointCount?>">

        <input type="submit" name="theirPoint" value="相手が得点しました">

      </form>
<?php
if($ourPointCount>=4 || $theirPointCount>=4 && abs($ourPointCount-$theirPointCount)>=2){
  if($ourPointCount>$theirPointCount){
    
  }
  ?>
<p>次のゲームに進みますか？</p>

<form action="" name="game" method="post">
  
<input type="hidden" name="winner" value="<?=$winner?>">

        <input type="submit" name="ourPoint" value="YES">

      </form>

      <form action="" method="post">
<input type="hidden" name="theirPointCount" value="<?=$theirPointCount?>">
<input type="hidden" name="ourPointCount" value="<?=$ourPointCount?>">

        <input type="submit" name="theirPoint" value="相手が得点しました">

      </form>
<?php
    }
      ?>





</body>
</html>