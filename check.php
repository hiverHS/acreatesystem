<?php
session_start();

$_SESSION['keep']=$_POST;

if($_SESSION['state']!=1){
   header('Location: login.php');
   exit(); 
}

if(isset($_POST['signup'])){
   $userid=$_SESSION['keep']['userid'];
   $name=$_SESSION['keep']['name'];
   $year=$_SESSION['keep']['year'];
   $month=$_SESSION['keep']['month'];
   $day=$_SESSION['keep']['day'];
   $mail=$_SESSION['keep']['mail'];
   $password=password_hash($_SESSION['keep']['password'],PASSWORD_DEFAULT);
}

 try{
   $s=new PDO("mysql:host=us-cdbr-east-04.cleardb.com;dbname=heroku_7aaeba682ec6742","b7d27927187c40","ae89efcc");
   $udate=$s->prepare('SELECT*FROM userdate WHERE userid=?');
   $udate->execute(array($userid));

   $row=$udate->fetch(PDO::FETCH_ASSOC);
   if($userid==$row['userid']){
      $Emessage="このユーザーIDは既に使用されています、違うユーザーIDを設定してください。";
   }else{
     $s->query("INSERT INTO userdate VALUES('$userid','$name','$year','$month','$day','$mail','$password')");
     $_SESSION['loginstate']=1;
     header('Location: mypage.php');
     exit();        
   }
 }catch(PDOException $e){
     $Emessage="データベースに接続されませんでした。";
  }
?>
<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="design.css">
  </head>
  
  <body>
  <div class="main">
  <form action="" method="post">
  <span>アカウント情報の確認</span><br>
  <span class="error">
  <?php
  if(isset($Emessage)){
     echo $Emessage;
  }?></span><br>
<!--アカウント情報の表示-->
  <span>ユーザーID：</span>
  <span><?php echo $userid=$_SESSION['keep']['userid'] ?></span><br>
  <input type="hidden" name="userid2" value="<?php echo $userid ?>">

  <span>名前：</span>
  <span><?php echo $name=$_SESSION['keep']['name'] ?></span><br>
  <input type="hidden" name="name2" value="<?php echo $name ?>">

  <span>生年月日：</span>
  <span><?php echo $year=$_SESSION['keep']['year'] ?></span><span>年</span>
  <input type="hidden" name="year2" value="<?php echo $year ?>">

  <span><?php echo $month=$_SESSION['keep']['month'] ?></span><span>月</span>
  <input type="hidden" name="month2" value="<?php echo $month ?>">
  
  <span><?php echo $day=$_SESSION['keep']['day'] ?></span><span>日</span><br>
  <input type="hidden" name="day2" value="<?php echo $day ?>">

  <span>メールアドレス：</span>
  <span><?php echo $mail=$_SESSION['keep']['mail'] ?></span><br>
  <input type="hidden" name="mail2" value="<?php echo $mail ?>">

  <span>パスワード：</span>
  <!--ポートフォリオ用にパスワードは表示-->
  <span><?php echo $password=$_SESSION['keep']['password'] ?></span><br>
  <?php/*
  $password=$_SESSION['keep']['password'];
  for($i=1;$i<=mb_strlen($password);$i++){
      echo "*";
  }*/?><br>
  <input type="hidden" name="password2" value="<?php echo $password ?>">
  <input type="hidden" name="Cpassword2" value="<?php echo $Repassword=$_SESSION['keep']['Cpassword'] ?>">

  <input class="button"  type="submit" value="登録してログイン" name="signup">
  <input class="button"  type="submit" value="入力情報の修正"　name="back" formaction="entry.php">
  <input class="button"  type="submit" value="ログインページへ"　name="loginP" formaction="login.php">
  </form>
  </div>
 </body>
  <footer>
  </footer>
</html>