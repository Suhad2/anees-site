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
    <title>عرض المستخدمين</title>
    <link rel="stylesheet" href="stylish.css" media="screen"/>
    <link href="fontawsom/css/all.css" rel="stylesheet">
    <link href="fontawsom/css/fontawesome.css" rel="stylesheet">
    <link href="fontawsom/css/brands.css" rel="stylesheet">
    <link href="fontawsom/css/solid.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
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
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card mt-5 ">
                    <div class="card-header">
                        <h4>السفراء المسجلين في الموقع</h4>
                    </div>
                    <div class="card-body">
                        
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th>نوع السفير  </th>
                                <th>الرقم الأنيسي  </th>
                                <th>اسم السفير</th>
                                    <th>التسلسل</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                   

                                    $query = "SELECT * FROM user_info";
                                    $query_run = mysqli_query($connect, $query);

                                    if(mysqli_num_rows($query_run) > 0)
                                    {
                                        foreach($query_run as $row)
                                        {
                                            ?>
                                            <tr><td><?= $row['user_type']; ?></td>
                                                <td><?= $row['anees_num']; ?></td>
                                                <td><?= $row['user_name']; ?></td>
                                                <td><?= $row['user_id']; ?></td>
                                                
                                               
                                            </tr>
                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        ?>
                                            <tr>
                                                <td colspan="4">لا يوجد سفراء</td>
                                            </tr>
                                        <?php
                                    }
                                ?>

                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="froum-group mb-3">
                                <a type="submit" href="deleteUser.php" class="style06"> لمسح سفير اضغط هنا</a>
                            </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
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