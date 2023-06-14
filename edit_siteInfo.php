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


$WI_post01 = $_POST['get01']; //اسم الانبت الاول
$WI_post02 = $_POST['get02'];
$WI_post03 = $_POST['get03'];
$WI_post04 = $_POST['get04'];
$WI_post05 = $_POST['get05'];

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


//نجيب البيانات من الداتا بيس

$GetDataWeb = "SELECT * FROM web_info" ;
$RunDataWeb = mysqli_query($connect, $GetDataWeb);
$RowDataWeb = mysqli_fetch_array($RunDataWeb);

if(isset($_POST['get06'])){   
 //هذا الامر خاص بتحديث البيانات 
 $updateWebInfo = "UPDATE web_info SET
 web_name = '$WI_post01',
 web_open = '$WI_post02' ,
 web_whatsup = '$WI_post03' ,
 web_viber = '$WI_post04' ,
 web_email = '$WI_post05' 
";

//اذا جانت البيانات متحدثة يسوي رفرش بنفس اللحظة ويبقى بنفس الصفحة
        if(mysqli_query($connect,$updateWebInfo)){
        echo'<meta http-equiv="refresh" content="0; url=setting.php"/>';
        exit();
        }
        else {
        echo'لم يتم التحديث';
        echo'<meta http-equiv="refresh" content="5; url=setting.php"/>';

        exit();

        }
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
    <form action="" method="post">
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

        <div class="style01">
            <h5>اسم الموقع </h5>
                <input class="style02" value="<?php echo $RowDataWeb['web_name']; ?>" require type="text" placeholder="اسم الموقع" name="get01"/>
                <h5> مفتوح أو مغلق </h5>
                <input class="style02" value="<?php echo $RowDataWeb['web_open']; ?>" require type="text" placeholder="مغلق او مفتوح" name="get02"/>
                <h5> التواصل عبر الواتساب  </h5>
                <input class="style02" value="<?php echo $RowDataWeb['web_whatsup']; ?>" require type="text" placeholder="واتس اب" name="get03"/>
                <h5> التواصل عبر الايميل  </h5>
                <input class="style02" value="<?php echo $RowDataWeb['web_email']; ?>" type="text" placeholder="الايميل" name="get05"/>
            <div class="style03">
                <div class="main"><input name="get06" class="style04" type="submit" value="حفظ البيانات" /></div>
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
        x.className = "topnav";
    }

}
</script>
</body>
</html>