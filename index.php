<?php
include "lujain.php";
global $connect ;
mysqli_set_charset($connect, 'utf8');

$GetDataWeb = "SELECT * FROM web_info" ;
$RunDataWeb = mysqli_query($connect, $GetDataWeb);
$RowDataWeb = mysqli_fetch_array($RunDataWeb);

if($RowDataWeb['web_open'] == "كلا"){
    echo '<p class="style10">عذرا الموقع تحت الصيانة , يرجى زيارتنا في وقت لاحق </p>' ;

    exit();
}else{}

$TokenUserData = $_COOKIE["tokenUser"];
$GetDataUser = "SELECT * FROM user_info WHERE user_token = '$TokenUserData'";
$RunDataUser = mysqli_query($connect, $GetDataUser);
$RowDataUser = mysqli_fetch_array($RunDataUser);
?>


<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $RowDataWeb['web_name']; ?></title>
    <link rel="stylesheet" href="stylish.css" media="screen"/>
    <link href="fontawsom/css/all.css" rel="stylesheet">
    <link href="fontawsom/css/fontawesome.css" rel="stylesheet">
    <link href="fontawsom/css/brands.css" rel="stylesheet">
    <link href="fontawsom/css/solid.css" rel="stylesheet">
    
</head>
<body>
    <div class="container2">    
    <div class="bg">
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
    
        </div>
        
<footer class="footsy">
    <div class="row">
        <div class="col-6 mobilestack">
            
            <ul>
            <li><h1>للتواصل معنا </h1></li>
                <li>Whatsapp : <?php echo $RowDataWeb['web_whatsup']; ?></li>
                <li>Email  : <?php echo $RowDataWeb['web_email']; ?></li>
            </ul>
        </div>
        
        <div class="col-6 mobilestack">
            
            <ul>
                <li>
                <span class="style39"><i class="fa-brands fa-facebook"></i></span>
                <span class="style39"><i class="fa-brands fa-instagram-square"></i></span>
                <span class="style39"><i class="fa-brands fa-twitter-square"></i></span>
                <span class="style39"><i class="fa-brands fa-youtube-square"></i></span>
                </li>
            </ul>
        </div>
    </div>
</footer>
            
     
<div class="style43"><a class="style33" href="#home"><i class="fa-solid fa-angles-up"></i></a></div>


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
const panels = document.querySelectorAll('.panel')

panels.forEach(panel => {
    panel.addEventListener('click', () => {
        removeActiveClasses()
        panel.classList.add('active')
    })
})

function removeActiveClasses() {
    panels.forEach(panel => {
        panel.classList.remove('active')
    })
}
</script>
  
</body>
</html>