<?php
session_start();

if($_SESSION['loginstate']!=1){
   header('Location: login.php');
   exit(); 
}

$_SESSION=array();

?>
<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="design.css">
  <title>ログアウト画面</title>
 </head>
 <body>
 <div class="main">
  <form action="" method="post" autocomplete="off">
  <span>ログアウトしました</span><br><br>
  <input class="button"  type="submit" value="ログインページへ"　name="loginP" formaction="login.php">
 </form>
 </div>
 </body>
 <footer>
 </footer>
</html>