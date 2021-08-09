<?php
session_start();

$_SESSION['keep']=$_POST;

//各情報が入力されていなかった場合の処理
if(isset($_POST['check'])){
 //ユーザーID
 if(!preg_match("/^[0-9]{4}$/",$_POST['userid'])){
      $Euserid="指定の数字、桁数でユーザーIDを入力してください。";
 }
 if(empty($_POST['userid'])){
      $Euserid="ユーザーIDが入力されていません。";
 }
//名前
 if(empty($_POST['name'])){
    $Ename="名前が入力されていません。";
 }
//年・月・日
 if(empty($_POST['year'])&&empty($_POST['month'])&&empty($_POST['day'])){
    $Eyear="年・月・日が入力されていません。";
 }
//年・月
  elseif(empty($_POST['year'])&&empty($_POST['month'])){
         $Eyear="年・月が入力されていません。";
  }
//年・日
  elseif(empty($_POST['year'])&&empty($_POST['day'])){
         $Emouth="年・日が入力されていません。";
  }
//月・日
 elseif(empty($_POST['month'])&&empty($_POST['day'])){
        $Eday="月・日が入力されていません。";
 }
//年
 elseif(empty($_POST['year'])){
        $Eyear="年が入力されていません。";
 }
//月
 elseif(empty($_POST['month'])){
        $Eyear="月が入力されていません。";
 }
//日
 elseif(empty($_POST['day'])){
        $Eyear="日が入力されていません。";
 }
//メールアドレス
 if(empty($_POST['mail'])){
    $Email="メールアドレスが入力されていません。";
 }elseif(!filter_var($_POST["mail"],FILTER_VALIDATE_EMAIL)){
    $Email="メールアドレスが正しくありません。";
 }  
//パスワード
 if(!preg_match('/\A(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,100}+\z/',$_POST["password"])){
    $Epassword="指定の文字、文字数でパスワードを入力してください。";
 }
 if(empty($_POST["password"])){
    $Epassword="パスワードが入力されていません。";
 }

 if(!preg_match('/\A(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,100}+\z/',$_POST["Cpassword"])){
    $ECpassword="指定の文字、文字数でパスワードを入力してください。";
 }
 if(empty($_POST["Cpassword"])){
    $ECpassword="パスワードが入力されていません。";
 }

 if(!empty($_POST["password"])&&!empty($_POST["Cpassword"])){
  if($_POST["password"]!=$_POST["Cpassword"]){
     $ECpassword="パスワードが間違っています。"; 
  }
 }
}

if(isset($_POST['sample'])){
   $_SESSION['keep']['name']="日本太郎";
   $_SESSION['keep']['year']="2021";
   $_SESSION['keep']['month']="4";
   $_SESSION['keep']['day']="1";
   $_SESSION['keep']['mail']="12345@gmail.com";
   $_SESSION['keep']["password"]="Password1";
   $_SESSION['keep']["Cpassword"]="Password1";
}

if(isset($_POST['check'])&&empty($Euserid)&&!empty($_POST["name"])&&!empty($_POST["year"])&&!empty($_POST["month"])&&!empty($_POST["day"])&&!empty($_POST["mail"])&&empty($Epassword)&&empty($ECpassword)){
   $_SESSION['state']=1;
   header('Location: check.php');
   exit();
}
?>
<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="design.css">
  <title>アカウント作成</title>
 </head>

 <body>
  <div class="main">
   <form action="" method="post" autocomplete="off">
   <span>アカウントの作成</span><br>
   <span>アカウントを作成します、以下の情報を全て入力してください。</span><br><br>

   <!--ユーザーIDの登録-->
   <span>ユーザーIDを入力してください。</span>   
   <span class="error"><?php
   if(isset($Euserid)){
      echo $Euserid;
   }?></span><br>
   <span class="sentence">4桁の半角数字で設定してください。(例:0001,0100,1234)</span><br>
   <?php
     $userid1=null; 
     if(isset($_SESSION['keep']['userid'])){
        $userid1=$_SESSION['keep']['userid'];
     }elseif(isset($_SESSION['keep']["userid2"])){
        $userid1=$_SESSION['keep']["userid2"];
      }
        echo '<input class="text" type="text" name="userid" value="'.$userid1.'">';
   ?><br>

   <!--名前の登録-->
   <span>名前を入力してください。</span>   
   <span class="error"><?php
   if(isset($Ename)){
      echo $Ename;
   }?></span><br>
   <?php
     $name1=null; 
     if(isset($_SESSION['keep']['name'])){
        $name1=$_SESSION['keep']['name'];
     }elseif(isset($_SESSION['keep']["name2"])){
        $name1=$_SESSION['keep']["name2"];
      }
        echo '<input class="text" type="text" name="name" value="'.$name1.'">';
   ?><br>


   <!--生年月日の登録-->
   <span>生年月日を選んでんください。</span>
   <span class="error"><?php
   if(isset($Eyear)){
      echo $Eyear;
   }
   if(isset($Emouth)){
      echo $Emouth;
   }
   if(isset($Eday)){
      echo $Eday;
   }?></span><br>
   <!--年-->
   <?php
   $ydata=array();
   for($year=1921;$year<=2021;$year++){
       $ydata[]=$year;
   }?>
   <select class="selectbox" name="year" value="">
   <option value=""></option>
   <?php
   if(empty($_SESSION['keep']["year2"])){
    foreach($ydata as $year1){
     if(!empty($_SESSION['keep']['year'])){
      if($year1==$_SESSION['keep']['year']){
         echo '<option value="'.$year1.'"selected>'.$year1.'</option>';
      }else{
         echo '<option value="'.$year1.'">'.$year1.'</option>';
       }
     }else{
         echo '<option value="'.$year1.'">'.$year1.'</option>';
      }
    }
   }else{
     foreach($ydata as $year1){
      if($year1==$_SESSION['keep']['year2']){
         echo '<option value="'.$year1.'"selected>'.$year1.'</option>';
      }else{
         echo '<option value="'.$year1.'">'.$year1.'</option>';
      }
     }
    }?>
   </select>
   <span>年</span>
   <!--月-->
   <?php
   $mdata=array();
   for($month=1;$month<=12;$month++){
       $mdata[]=$month;
   }?>
   <select class="selectbox" name="month" value="">
   <option value=""></option>
   <?php
   if(empty($_SESSION['keep']['month2'])){
    foreach($mdata as $month1){
     if(!empty($_SESSION['keep']['month'])){
      if($month1==$_SESSION['keep']['month']){
         echo '<option value="'.$month1.'"selected>'.$month1.'</option>';
      }else{
         echo '<option value="'.$month1.'">'.$month1.'</option>';
       }
     }else{
         echo '<option value="'.$month1.'">'.$month1.'</option>';
      }
    }
   }else{
     foreach($mdata as $month1){
      if($month1==$_SESSION['keep']['month2']){
         echo '<option value="'.$month1.'"selected>'.$month1.'</option>';
      }else{
         echo '<option value="'.$month1.'">'.$month1.'</option>';
       }
     }
    }?>
   </select>
   <span>月</span>
   <!--日-->
   <?php
   $ddata=array();
   for($day=1;$day<=31;$day++){
       $ddata[]=$day;
   }?>
   <select class="selectbox" name="day" value="">
   <option value=""></option>
   <?php
   if(empty($_SESSION['keep']['day2'])){
    foreach($ddata as $day1){
     if(!empty($_SESSION['keep']['day'])){
      if($day1==$_SESSION['keep']['day']){
         echo '<option value="'.$day1.'"selected>'.$day1.'</option>';
      }else{
         echo '<option value="'.$day1.'">'.$day1.'</option>';
       }
     }else{
         echo '<option value="'.$day1.'">'.$day1.'</option>';
      }
    }
   }else{
     foreach($ddata as $day1){
      if($day1==$_SESSION['keep']['day2']){
         echo '<option value="'.$day1.'"selected>'.$day1.'</option>';
      }else{
         echo '<option value="'.$day1.'">'.$day1.'</option>';
       }
     }
    }?>
   </select>
   <span>日</span><br>

   <!--メールアドレスの登録-->
   <span>メールアドレスを入力してください。</span>
   <span class="error"><?php
   if(isset($Email)){
      echo $Email;
   }?></span><br>
   <?php
   $mail1=null; 
   if(isset($_SESSION['keep']['mail'])){
      $mail1=$_SESSION['keep']['mail'];
   }elseif(isset($_SESSION['keep']['mail2'])){
      $mail1=$_SESSION['keep']['mail2'];
    }
      echo '<input class="text" type="text" name="mail" value="'.$mail1.'">';
   ?><br>

   <!--パスワードの設定-->
   <span>パスワードを入力してください。</span>   
   <span class="error"><?php
   if(isset($Epassword)){
      echo $Epassword;
   }?></span><br>
   <span class="sentence">半角英小文、半角英大文字、数字をそれぞれ1種類以上含む8文字以上でパスワードを設定してください。</span><br>
   <?php
   $password1=null; 
   if(isset($_SESSION['keep']["password"])){
      $password1=$_SESSION['keep']["password"];
   }elseif(isset($_SESSION['keep']["password2"])){
      $password1=$_SESSION['keep']["password2"];
    }
      //ポートフォリオ用にパスワードは表示。
      echo '<input class="text" type="text" name="password" value="'.$password1.'">';
      //echo '<input type="password" name="password" value="'.$password1.'">';

   ?><br>

   <span>確認用パスワード。</span>   
   <span class="error"><?php
   if(isset($ECpassword)){
      echo $ECpassword;
   }?></span><br>
   <span class="sentence">もう一度パスワードを入力してください。</span><br>
   <?php
   $Cpassword=null; 
   if(isset($_SESSION['keep']["Cpassword"])){
      $Cpassword=$_SESSION['keep']["Cpassword"];
   }elseif(isset($_SESSION['keep']["Cpassword2"])){
      $Cpassword=$_SESSION['keep']["Cpassword2"];
    }
      //ポートフォリオ用にパスワードは表示
      echo '<input class="text" type="text" name="Cpassword" value="'.$Cpassword.'">';
      //echo '<input type="password" name="Cpassword" value="'.$Cpassword.'">';      
   ?>

   
   <input class="button" type="submit" value="登録情報の確認" name="check">
   <input class="button" type="submit" value="ログインページへ"　name="loginP" formaction="login.php">

   </form>
  </div> 
  </body> 
  <footer>
   <div class="footer">
   <form action="" method="post">
   <span>※"仮入力"ボタンを押すとユーザーID以外の情報が入力されます、重複防止のためお手数ですがユーザーIDは手動でご入力ください。</span><br>
   <input class="button" type="submit" value="仮入力" name="sample" >
   </form>
   </div>
  </footer>
</html>