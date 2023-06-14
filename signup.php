<?php
if($_COOKIE["loginCookies"] == 1){
echo'<meta http-equiv="refresh" content="2; url=login.php" />';
echo '<p class="style10">أنت مسجل بالفعل  </p>' ;

exit();
}else{}


//session_start();  
include "lujain.php";
global $connect ;
mysqli_set_charset($connect, 'utf8');

$WI_post01 = $_POST['get01']; //اسم الانبت الاول
$WI_post02 = $_POST['get02'];
$WI_post03 = $_POST['get03'];
$WI_post04 = $_POST['get04'];

$welcome = "<p class='style08'>أهلا وسهلاَ بك </p>";

$token = @date("ymdhis");
$randomNumber = rand(100,200);
$NewToken = $token . $randomNumber;

$aneesNum = @date("ymd");
$randNumber = rand(100,2000);
$aneesNumber = $aneesNum . $randNumber;



if(isset($_POST['get05'])){    //اذا ضغطت على هذا الزر 

        if(empty($WI_post01) || empty($WI_post02) || empty($WI_post03)) {
            $error = "<p class='style08' > يرجى عدم ترك الحقول فارغة </p>" ;
            $welcome ="";
        }elseif (!filter_var($WI_post03, FILTER_VALIDATE_EMAIL)) {
        
        
            $error = "<p class='style08' >  يرجى إدخال إيميل صحيح    </p>" ;
                
        }elseif (!empty($WI_post02) && $WI_post02 != "") {
    
                if (strlen($WI_post02) < '8') {
                    
                    $error = "<p class='style08' >   يجب أن يتكون الباسورد من 8 قيم على الأقل  </p>" ;

                }
                elseif(!preg_match("#[0-9]+#",$WI_post02)) {
                
                    $error = "<p class='style08' >  يجب أن يحتوي الباسورد على رقم واحد على الأقل  </p>" ;
                }
                elseif(!preg_match("#[A-Z]+#",$WI_post02)) {
                    
                    $error = "<p class='style08' >  يجب أن يحتوي الباسورد على حرف واحد كبير على الأقل  </p>" ;
                }
                elseif(!preg_match("#[a-z]+#",$WI_post02)) {
                    $error = "Your Password Must Contain At Least 1 Lowercase Letter !";
                    $error = "<p class='style08' >  يجب أن يحتوي الباسورد على حرف واحد صغير على الأقل  </p>" ;

                }
                elseif(!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/',$WI_post02)) {
                    $error = "Your Password Must Contain At Least 1 Special Character !";
                    $error = "<p class='style08' >  يجب أن يحتوي الباسورد على رمز واحد  على الأقل  </p>" ;

                }
          

        else{
            //هذا الامر للتحقق من قاعدة البيانات 
            $GetUserInfo = "SELECT * FROM user_info  WHERE user_email='$WI_post03'";
            $RunUserInfo = mysqli_query($connect,$GetUserInfo);
            $RowUserInfo = mysqli_fetch_array($RunUserInfo);
            $emailUser =$RowUserInfo['user_email'];


            $GetUserInfo2 = "SELECT * FROM user_info  WHERE user_name ='$WI_post01'";
            $RunUserInfo2 = mysqli_query($connect,$GetUserInfo2);
            $RowUserInfo2 = mysqli_fetch_array($RunUserInfo2);
            $nameUser =$RowUserInfo2['user_name'];

            $GetUserInfo3 = "SELECT * FROM user_info  WHERE user_birthday ='$WI_post04'";
            $RunUserInfo3 = mysqli_query($connect,$GetUserInfo3);
            $RowUserInfo3 = mysqli_fetch_array($RunUserInfo3);
            $userBirh =$RowUserInfo2['user_birthday'];

            
            if($WI_post03 == $emailUser ){
                $error = "<p class='style09'> هذا الايميل مستخدم بالفعل</p>";
            }elseif ($WI_post01 == $nameUser ){
                $error = "<p class='style09'> هذا الاسم مستخدم بالفعل</p>";
            }
            else
            {

            $insertdata = "INSERT INTO user_info 
            (
                user_token ,
                anees_num ,
                user_name ,
                user_password ,
                user_email ,
                user_birthday 
                ) VALUES
                (
            '$NewToken',
            '$aneesNumber',
            '$WI_post01',
            '$WI_post02',
            '$WI_post03',
            '$WI_post04'
            ) ";

            if(mysqli_query($connect,$insertdata)){
                echo ' <link rel="stylesheet" href="stylish.css" />';
                echo '<p class="style10">تم إنشاء حساب جديد </p>' ;

                //setcookie('tokenUser', $NewToken , time() + (86400 * 30 *2), "/");
               // setcookie('loginCookies','1' , time() + (86400 * 30 *2), "/");
                //setcookie('nameuser','$WI_post01' , time() + (86400 * 30 *2), "/");

                require_once "mail.php";
                $mail->addAddress($WI_post03);
                $mail->Subject = "رمز التحقق من البريد الألكتروني";
                $mail->Body = '<h1> شكرا لتسجيلك في موقعنا</h1>'
                . "<div> رابط التحقق من الحساب" . "<div>" . 
                "<a href='http://localhost/webiraq/active.php?code=".$NewToken  . "'>
                 " . "http://localhost/webiraq/active.php?code=" .$NewToken . "</a>";
              
                $mail->setFrom('suhadkanan@yahoo.com', 'Suhad Kanaan');
                $mail->send();

                echo'<meta http-equiv="refresh" content="5; url=login.php"/>';
                
                exit();
            }else {
                echo'لم يتم التسجيل';
                echo'<meta http-equiv="refresh" content="5; url=signup.php"/>';
                exit();
            }
}
}
}}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="stylish.css" media="screen"/>
    <link rel="stylesheet" href="styleaa.css" />
    <link href="fontawsom/css/all.css" rel="stylesheet">
    <link href="fontawsom/css/fontawesome.css" rel="stylesheet">
    <link href="fontawsom/css/brands.css" rel="stylesheet">
    <link href="fontawsom/css/solid.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.8.11/tailwind.min.css"/>
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
				<li class="topnav-right"><a href="shoping.php"><i class="fa-solid fa-cart-shopping"></i></a> </li>
                ';}else{
                echo'
				<li class="topnav-right" id="home"><a href="index.php">الرئيسية</a> </li>
				<li class="topnav-right"><a href="shoping.php"><i title="سلة المشتريات" class="fa-solid fa-cart-shopping"></i></a> </li>
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
        <br/><br/>
        <input  class="border block w-full p-2 mt-2 rounded" require type="text" placeholder="اسم المستخدم " name="get01" />
        <input  class="border block w-full p-2 mt-2 rounded" require type="password" placeholder="كلمة المرور" name="get02" id="myInput" /><br/>
        <input  type="checkbox" onclick="myFunction()">  إظهار كلمة المرور<br/>
        
        <input  class="border block w-full p-2 mt-2 rounded style021" require type="email" placeholder="اكتب الايميل" name="get03" />
        <input  class="border block w-full p-2 mt-2 rounded" type="date" placeholder="اكتب المواليد" name="get04" />
   
    <div class="style03" >
        <div class="main"> <input class="style04" type="submit" value="انشاء حساب جديد" name="get05"/> </div>
        <div class="left"><a class="style05" href="index.php" ><p class="style06">الرجوع </p> </a></div>
        <div class="right"><a class="style05" href="login.php" ><p class="style06">تسجيل الدخول  </p> </a></div>
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
