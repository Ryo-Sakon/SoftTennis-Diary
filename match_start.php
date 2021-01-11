<?php
require_once ('settings.php');
require_once ('db_connect.php');

session_start();
if(isset($_POST["opponents"]) && $_POST["opponents"]!=""){

    

    $pdo= db_connect();
    $stmt=$pdo->prepare('SELECT posts.match_id,posts.pairs_id,pairs.* FROM posts,pairs WHERE posts.pairs_id=pairs.id AND pairs.pairs_login_id=:login_id ORDER BY posts.match_id DESC');
    $stmt->bindParam(':login_id',$_SESSION["pairs_id"]);
    $stmt->execute();
    $array=$stmt->fetch(PDO::FETCH_ASSOC);

    $_SESSION['match_id']=$array['match_id']+1;
    $_SESSION['match_title']=$_POST['match_title'];
    $_SESSION['pairs_id']=$array['id'];
    $_SESSION['players']=$array['player_A'].'・'.$array['player_B'];
    $_SESSION['opponents']=$_POST['opponents'];
    
    $_SESSION['started_as_server']=$_POST['server'];
    switch($_SESSION['started_as_server']){
        case '自分':$_SESSION['started_as_receiver']='相手';
        break;
        case '相手':$_SESSION['started_as_receiver']='自分';
        break;
    }
    $_SESSION['counter']=0;
    $_SESSION['ourPointCount']=0;
    $_SESSION['theirPointCount']=0;
    $_SESSION['ourGameCount']=0;
    $_SESSION['theirGameCount']=0;




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
<form action="" method="post">
<span>試合タイトル</span><input type="text" size="30" name="match_title" id="" placeholder="例：練習試合（○○高校）第○試合"><br>
<span>相手のペア</span><input type="text" size="30" name="opponents" id="" placeholder="例：田中・鈴木（○○高校）"><br>


    <span>サービス権をとったのはどっち？</span>
    <input type="radio" name="server" value="自分">自分
    <input type="radio" name="server" value="相手">相手
    <input type="submit" value="記録開始">
</form>
</body>
</html>