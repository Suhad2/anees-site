<?php


if(isset($_GET['code'])){

    $username = "root";
    $password = "rootroot";
    $database = new PDO("mysql:host=localhost; dbname=webnew;",$username,$password);

    $checkCode = $database->prepare("SELECT user_token FROM user_info WHERE user_token = :user_token");
    $checkCode->bindParam("user_token",$_GET['code']);
    $checkCode->execute();
    if($checkCode->rowCount()>0){

    $update = $database->prepare("UPDATE user_info SET user_token = :newuser_token , user_activated=true WHERE user_token = :user_token");
    $securityCode = md5(date("h:i:s"));
    $update->bindParam("newuser_token",$securityCode);
    $update->bindParam("user_token",$_GET['code']);

    if($update->execute()){
        echo '<div class="alert alert-success" role="alert">
      تم تحقق من حسابك بنجاح
      </div>';
      echo '<a class="btn btn-warning" href="login.php">تسجيل دخول</a>';
    }
    }else{
        echo '<div class="alert alert-danger" role="alert">
        هذا الكود لم يعد صالحا للأستخدام
      </div>';
    }
    

}


?>