<?php

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

      <span>サーブ権をとったのはどっち？</span>
      <input type="radio" name="which" value="ourselves">自分
      <input type="radio" name="which" value="another">相手
      
      <input type="submit" value="記録開始">
    </form>

    
      <p>第<?php ?>ゲーム目</p>
      <p>ゲームカウント<?php ?>ー<?php ?></p>
      <p>ポイントカウント<?php ?>ー<?php ?></p>

      <form action="count.php" method="get">

      <a href="#" onClick=""></a>
    
      </form>



    
</body>
</html>