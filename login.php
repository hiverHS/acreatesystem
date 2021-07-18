<?php
session_start();

$_SESSION['keep']=$_POST;

if(isset($_POST['login'])){
//ユーザーID
 if(empty($_POST['Luserid'])){
    $ELuserid="ユーザーIDが入力されていません。";
 }   
//パスワード
 if(empty($_POST['Lpassword'])){
    $ELpassword="パスワードが入力されていません。";
 }
}
 
if(isset($_POST['login'])&&empty($ELuserid)&&empty($ELpassword)){
   $Luserid=$_SESSION['keep']['Luserid'];
   $Lpassword=$_SESSION['keep']['Lpassword'];

   //xampp用
   try{
      $s=new PDO("mysql:host=localhost;dbname=user","sqll","1234");
      $udate=$s->prepare('SELECT*FROM userinfo WHERE id=?');
      $udate->execute(array($Luserid));
   
     if($row=$udate->fetch(PDO::FETCH_ASSOC)){
      if(password_verify($Lpassword,$row['password'])){
         $_SESSION['loginstate']=1;
         header("location:mypage.php");
         exit();
      }else{
         $error="ユーザーIDかパスワードが間違っています。";
       }
     }else{
       $error="ユーザーIDかパスワードが間違っています。";
      }
    }catch(PDOException $e){
       $error="データベースに接続されませんでした。";
     }
   
 try{
   $s=new PDO("mysql:host=us-cdbr-east-04.cleardb.com;dbname=heroku_7aaeba682ec6742","b7d27927187c40","ae89efcc");
   $udate=$s->prepare('SELECT*FROM userdate WHERE userid=?');
   $udate->execute(array($Luserid));

  if($row=$udate->fetch(PDO::FETCH_ASSOC)){
   if(password_verify($Lpassword,$row['password'])){
      $_SESSION['loginstate']=1;
      header("location:mypage.php");
      exit();
   }else{
      $error="ユーザーIDかパスワードが間違っています。";
    }
  }else{
    $error="ユーザーIDかパスワードが間違っています。";
   }
 }catch(PDOException $e){
    $error="データベースに接続されませんでした。";
  }
}?>
<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="design.css">
  <title>ログインページ</title>
 </head>

 <body>
 <div class="main">
 <form action="" method="post" autocomplete="off">
 <span>ログイン</span><br>
 <span class="error"><?php
 if(isset($error)){
    echo $error;
 }?></span><br>
 <span>ユーザーID</span>
 <span class="error"><?php
 if(isset($ELuserid)){
    echo $ELuserid;
 }?></span><br>
 <?php
 $Luserid=null; 
 if(isset($_SESSION['keep']['Luserid'])){
    $Luserid=$_SESSION['keep']['Luserid'];
 }
    echo '<input class="text" type="text" name="Luserid" value="'.$Luserid.'">';
 ?><br>

 <span>パスワード</span>
 <span class="error"><?php
 if(isset($ELpassword)){
    echo $ELpassword;
 }?></span><br>
 <?php
 $Lpassword=null; 
 if(isset($_SESSION['keep']['Lpassword'])){
    $Lpassword=$_SESSION['keep']['Lpassword'];
 }
    //ポートフォリオ用にパスワードは表示
    echo '<input class="text" type="text" name="Lpassword" value="'.$Lpassword.'">';
    //echo '<input class="text" type="password" name="Lpassword" value="'.$Lpassword.'">';

 ?><br>

<input class="button"  type="submit" value="ログイン" name="login"><br><br>
<span>アカウント作成がまだの場合はアカウントを作成してください。</span><br>

<input class="button"  type="submit" value="アカウントの作成"　name="singup" formaction="entry.php">

 </form>
 </div>
 </body>
</html>