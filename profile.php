<?php
if($_COOKIE["loginCookies"] == 1){

}else{
    echo'<meta http-equiv="refresh" content="2; url=login.php" />';
    exit();


}


//session_start();  
include "lujain.php";
global $connect ;
mysqli_set_charset($connect, 'utf8');

$TokenUserData = $_COOKIE["tokenUser"];
$GetDataUser = "SELECT * FROM user_info WHERE user_token = '$TokenUserData'";
$RunDataUser = mysqli_query($connect, $GetDataUser);
$RowDataUser = mysqli_fetch_array($RunDataUser);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بيانات السفير</title>
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
       
        <!-- <img class="style13" src="images/<?php echo $RowDataUser['user_img']; ?>" /></br/> -->
        <h4><?php echo $RowDataUser['user_name']; ?>:الأسم</h4> 
        <h4><?php echo $RowDataUser['user_password']; ?>:الباسورد </h4>
        <h4><?php echo $RowDataUser['anees_num']; ?>:الرقم الانيسي</h4>
        <h4><?php echo $RowDataUser['user_email']; ?>:الإيميل </h4>
       <!-- <h3><?php echo $RowDataUser['user_birthday']; ?>   :   المواليد </h3>-->

     <!--   <div class="col-12 "> 
                <a  href="edit_profile.php" ><p class="style061">  تعديل البيانات   </p> </a></div>-->
                    
                </div> 

                <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card mt-5 ">
                    <div class="card-header">
                        <h4>المهام الموجهة اليك  </h4>
                    </div>
                    <div class="card-body">
                        
                        <table class="table table-bordered">
                            <thead>
                                <tr><th>تم التسليم أم لا</th>
                                <th>نوع المهمة</th>
                                <th>اسم المهمة</th>
                                <th>رقم المهمة   </th>

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
                                            <tr><td><?= $row['']; ?></td>
                                                <td><?= $row['']; ?></td>
                                                <td><?= $row['']; ?></td>
                                                <td><?= $row['']; ?></td>
                                                
                                               
                                            </tr>
                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        ?>
                                            <tr>
                                                <td colspan="4">لا يوجد مهام</td>
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


    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

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