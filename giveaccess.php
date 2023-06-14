<?php
if($_COOKIE["loginCookies"] == 1){
}else{
        echo'<meta http-equiv="refresh" content="2; url=login.php" />';
        
        
        exit();
}

//الإتصال بقاعدة البيانات
include "lujain.php";
global $connect ;
mysqli_set_charset($connect, 'utf8');


//يسمح فقط للادمن باضافة المنتجات
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

$WI_post01 = $_POST['get01']; //اسم الانبت الاول
$WI_post02 = $_POST['get02'];







if(isset($_POST['get05'])){
    // التحقق من الحقول اذا كانت فارغة
    if(empty($WI_post01) || empty($WI_post02)){
        // رسالة الخطأ
        $error = "<p class='style09'>يرجى عدم ترك الحقول فارغة</p>";
    }else{ 
       
        $sql = "UPDATE user_info SET user_type='$WI_post02' WHERE anees_num='$WI_post01'";


            if(mysqli_query($connect,$sql)){
                echo ' <link rel="stylesheet" href="stylish.css" />';
                echo '<p class="style10">تم اعطاء الصلاحية   </p>' ;

                echo'<meta http-equiv="refresh" content="5; url=giveaccess.php"/>';
                
                exit();
            }else {
                echo'لم تتم الإضافة';
                echo'<meta http-equiv="refresh" content="5; url=giveaccess.php"/>';
                
                exit();
            }
        

        }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Give Access</title>
    <link rel="stylesheet" href="stylish.css" media="screen"/>
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
                <li class="topnav-right" id="home"><a href="joinus.php">انضم لنا</a> </li>
                <li class="topnav-right" id="home"><a href="aboutus.php"> ماهوانيس </a> </li>
                <li class="topnav-right" id="home"><a href="statistics.php">احصائيات انيس  </a> </li>
				<li class="topnav-right"><span><a href="setting.php">الإعدادات </a></span> </li>
                ';}else{
                echo'
				<li class="topnav-right" id="home"><a href="index.php">الرئيسية</a> </li>
                <li class="topnav-right" id="home"><a href="joinus.php">انضم لنا</a> </li>
                <li class="topnav-right" id="home"><a href="aboutus.php"> ماهوانيس </a> </li>
                <li class="topnav-right" id="home"><a href="statistics.php">احصائيات انيس  </a> </li>


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


<form action="" method="post" enctype="multipart/form-data">     
<div class="style01">

        <?php echo $error; ?>
        <input class="style02" require type="text" placeholder="ادخل الرقم الانيسي للسفير " name="get01" />
        <p for="cars"> :اختر نوع الصلاحية</p>

<select name="get02" id="access">
  <option value="safeer">سفير</option>
  <option value="admin">رابط</option>
  <option value="supervisor">مشرف</option>
  <option value="distributer">موزع</option>
</select>

        <div class="style03" >
        <div class="main"> <input class="style04" type="submit" value="إضافة  " name="get05" /> </div>
        </div>
     

    </div>

</form>
<script type="text/javascript">
            function dropdownMenu() {
    var y = document.getElementById("dropdownClick");
    if (y.className === "topnav"){
        y.className += " responsive";

    }
    else {
        y.className = "topnav";
    }

}
</script>
</body>
</html>