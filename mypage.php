<?php
session_start();

if($_SESSION['loginstate']!=1){
   header('Location: login.php');
   exit(); 
}

$_SESSION['state']=0;

if(isset($_SESSION['keep']['userid'])){
   $userid=$_SESSION['keep']['userid'];
}else{
   $userid=$_SESSION['keep']['Luserid'];
 }

//xampp用
try{
   $s=new PDO("mysql:host=us-cdbr-east-04.cleardb.com;dbname=heroku_7aaeba682ec6742","b7d27927187c40","ae89efcc");
   $udate=$s->prepare('SELECT*FROM userdate WHERE userid=?');
   $udate->execute(array($userid));

 if($row=$udate->fetch(PDO::FETCH_ASSOC)){
    $Muserid=$row['userid'];
    $Mname=$row['name'];
    $Myear=$row['year'];
    $Mmonth=$row['month'];
    $Mday=$row['day'];
    $Mmail=$row['mail'];
 }
}catch(PDOException $e){
    $error="データベースに接続されませんでした。";
 }

if(isset($_POST['logout'])){
   header('Location: logout.php');
   exit();  
}?>
<DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="design.css">
 </head>
 <header>
 </header>
 <body>
  <div class="main">
  <form action="" method="post" autocomplete="off">
  <span>アカウント情報</span><br><br>

  <span>ユーザーID:</span>
  <span><?php echo $Muserid?></span><br>
  <span>名前:</span>
  <span><?php echo $Mname?></span><br>
  <span>生年月日:</span>
  <span><?php echo $Myear?>年</span>
  <span><?php echo $Mmonth?>月</span>
  <span><?php echo $Mday?>日</span><br>
  <span>登録しているメールアドレス:</span>
  <span><?php echo $Mmail?></span><br><br>

  <input class="button"  type="submit" value="ログアウト" name="logout">
  </form>
  </div>
 </body>
 <footer>
 </footer>
</html>