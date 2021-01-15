<?php
require_once('settings.php');
require_once('db_connect.php');
session_start();
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
echo "ペアID".$_SESSION["pairs_id"]."　さん　こんにちは";
echo '<br>';
?>

<a href="match_start.php">試合を記録する</a>
<br>
<a href="results.php">過去の記録をみる</a>
<br>
<a href="logout.php">ログアウト</a>

</body>
</html>