<?php
if($_COOKIE["loginCookies"] == 1){
echo'<meta http-equiv="refresh" content="2; url=index.php" />';
echo '<p class="style10">أنت مسجل بالفعل  </p>' ;

exit();
}else{


}
 
include "lujain.php";
global $connect ;

mysqli_set_charset($connect, 'utf8');


$WI_post01 = $_POST['get01']; //اسم الانبت الاول
$WI_post02 = $_POST['get02'];


$welcome = "<p class='style08'> أهلا وسهلاَ بك </p>";


if(isset($_POST['get05'])){    //اذا ضغطت على هذا الزر 

        if(empty($WI_post01) || empty($WI_post02) ) {
            $error = "<p class='style08' > يرجى عدم ترك الحقول فارغة </p>" ;
            $welcome ="";
        }

         else{
            //هذا الامر للتحقق من قاعدة البيانات 
            $GetUserInfo = "SELECT * FROM user_info  WHERE user_name='$WI_post01'";
            $RunUserInfo = mysqli_query($connect,$GetUserInfo);
            if(mysqli_num_rows($RunUserInfo) > 0 ){
                $RowUserInfo = mysqli_fetch_array($RunUserInfo);
                
                $nameUser =$RowUserInfo['user_name'];
                
                $passwordUser =$RowUserInfo['user_password'];

                $tokenUser =$RowUserInfo['user_token'];

                $userActivated =$RowUserInfo['user_activated'];
                
                if($userActivated != 1) {
                  
                    $error="<p class='style08'>يرجى تفعيل حسابك في البداية ، لقد أرسلنا رمز التحقق من حسابك الى البريد الألكتروني الخاص بك    </p>";


                }
                elseif($passwordUser != $WI_post02)
                {
                    $error="<p class='style08'>يرجى كتابة الباسورد بصورة صحيحة </p>";
                    $welcome ="";

                }else{
                    
                setcookie('tokenUser', $tokenUser , time() + (86400 * 30 *2), "/");
                setcookie('loginCookies','1' , time() + (86400 * 30 *2), "/");
                setcookie('nameuser',$nameUser , time() + (86400 * 30 *2), "/");

                echo '  <link rel="stylesheet" href="stylish.css" media="screen" />';
                echo '<p class="style10">شكرا لتسجيل الدخول </p>' ;
                echo'<meta http-equiv="refresh" content="5; url=index.php" />';

                    exit();

                }
                
            }else{

                $error="<p class='style08'>عذرا لايوجد حساب بهذا الاسم </p>";
                $welcome ="";
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
    <title>تسجيل الدخول </title>
    <link rel="stylesheet" href="styleaa.css" />
    <link href="fontawsom/css/all.css" rel="stylesheet">
    <link href="fontawsom/css/fontawesome.css" rel="stylesheet">
    <link href="fontawsom/css/brands.css" rel="stylesheet">
    <link href="fontawsom/css/solid.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.8.11/tailwind.min.css"/>
    <link rel="stylesheet" href="stylish.css" media="screen" />
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
<div class="background1" id="background1"></div>
<div class="style01">   
<div class="bg-white rounded p-10 text-center shadow-md">
        <?php echo $welcome; ?>
        <?php echo $error; ?>
        <input  class="border block w-full p-2 mt-2 rounded" require type="text" placeholder="اسم المستخدم " name="get01" />
        <input  class="border block w-full p-2 mt-2 rounded" require type="password" placeholder="كلمة المرور" name="get02" id="myInput" /><br/>
        <input  type="checkbox" onclick="myFunction()">إظهار كلمة المرور<br/>
    
    <div class="style03" >
        <div class="main"> <input class="style04" type="submit" value="تسجيل الدخول" name="get05"/> </div>
        <div class="left"><a class="style05" href="index.php" ><p class="style06">الرجوع</p> </a></div>
        <div class="right"><a class="style05" href="signup.php" ><p class="style06">أنشاء حساب جديد  </p> </a></div>
    </div>
    </div>
    </div>
</form>

<script >

        function myFunction() {
  var x = document.getElementById("myInput");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
 
const password = document.getElementById('myInput')
const background1 = document.getElementById('background1')

password.addEventListener('input', (e) => {
  const input = e.target.value
  const length = input.length
  const blurValue = 20 - length * 2
  background1.style.filter = `blur(${blurValue}px)`
})


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