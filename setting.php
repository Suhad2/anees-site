<?php

if($_COOKIE["loginCookies"] == 1){
   
    }else{
        echo'<meta http-equiv="refresh" content="2; url=login.php" />';
        echo '<p class="style10">أنت مسجل بالفعل  </p>' ;
        
        exit();

    }

//ملف الاتصال بقاعدة البيانات
include "lujain.php";
global $connect ;
mysqli_set_charset($connect, 'utf8');


$TokenUserData = $_COOKIE["tokenUser"];
$GetDataUser = "SELECT * FROM user_info WHERE user_token = '$TokenUserData'";
$RunDataUser = mysqli_query($connect, $GetDataUser);
$RowDataUser = mysqli_fetch_array($RunDataUser);

if( $RowDataUser['user_type'] == 'admin' ){  
}else{
    echo'عذرا ليست لديك صلاحية الدخول لهذه الصفحة   ';
    echo'<meta http-equiv="refresh" content="5; url=index.php"/>';

    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بيانات الموقع</title>
    <link rel="stylesheet" href="stylish.css" media="screen"/> <!-- ربط ملف الستايل -->
    <link href="fontawsom/css/all.css" rel="stylesheet">
    <link href="fontawsom/css/fontawesome.css" rel="stylesheet">
    <link href="fontawsom/css/brands.css" rel="stylesheet">
    <link href="fontawsom/css/solid.css" rel="stylesheet">
</head>
<body>
   
<nav>
        <ul class="topnav" id="dropdownClick">  
        <?php
            if($RowDataUser['user_type'] == 'admin'){
                echo'
				<li class="topnav-right" id="home"><a href="index.php">الرئيسية</a> </li>
				<li class="topnav-right"><span><a href="setting.php">الإعدادات </a></span> </li>
                ';}else{
                echo'
				<li class="topnav-right" id="home"><a href="index.php">الرئيسية</a> </li>
                ';}
        
            if($_COOKIE["loginCookies"] == 1 ){
                echo'
                <li ><a href="profile.php">الملف الشخصي </a> </li>
				<li ><a href="logout.php"> تسجيل خروج</a> </li>
               
				<li class="dropdownIcon"> 
                <a href="javascript:void(0);" onclick="dropdownMenu()" > &#9776; </a>
                </li>
            
                ';
            }else{
                echo'
                <li ><a href="signup.php">إنشاء حساب  </a> </li>
				<li ><a href="login.php">تسجيل الدخول </a> </li>
				<li class="dropdownIcon"> <a href="javascript:void(0);" onclick="dropdownMenu()" > &#9776; </a></li>
                ';
            
            }
        ?>
        </ul>	
</nav>

<div class="col-12"> 
    <a  href="showUsers.php" ><p class="style061" >عرض السفراء</p> </a></div>           
</div>
<div class="col-12"> 
    <a  href="deleteUser.php" ><p class="style061" >مسح سفير</p> </a></div>           
</div>
<div class="col-12"> 
    <a  href="edit_siteInfo.php" ><p class="style061" >تعديل بيانات الموقع</p> </a></div>           
</div>
<div class="col-12">
    <a  href="addtask.php" ><p class="style061" >إضافة مهمة</p> </a></div>           
</div>
<div class="col-12">
    <a  href="giveaccess.php" ><p class="style061" >تحديد صلاحية السفير</p> </a></div>           
</div>


    <script type="text/javascript">
            function dropdownMenu() {
    var y = document.getElementById("dropdownClick");
    if (y.className === "topnav"){
        y.className += " responsive";

    }
    else {
        x.className = "topnav";
    }

}
</script>
</body>
</html>