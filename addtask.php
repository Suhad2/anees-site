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
$WI_post03 = $_POST['get03'];



$token = @date("ymdhis");
$randomNumber = rand(100,200);
$bookToken = $token . $randomNumber;


  // الاوامر الخاصه برفع الصور

  //يقرا الصورة
$u_img2 = @$_FILES['show_img2']['name'];
  //يحفظ الصور ب ال تيمب
$u_img_tmp2 = @$_FILES['show_img2']['tmp_name'];
    //يحفظ الصور بهذا الملف 
$target_dir = "book_images/";
  //يربط اسم الصورة ويا اسم الملف المحفوظ بيه الصور
$target_file2 = $target_dir . basename($_FILES["show_img2"]["name"]);
  //to compress images
$imageFileType2 = strtolower(pathinfo($target_file2,PATHINFO_EXTENSION));

$uploadOk = 1;

  //change image name
$newimgproblem2 = uniqid('mp-', true) 
. '.' . strtolower(pathinfo($_FILES['show_img2']['name'], PATHINFO_EXTENSION));


if(isset($_POST['get05'])){
    // التحقق من الحقول اذا كانت فارغة
    if(empty($WI_post01) || empty($WI_post02)){
        // رسالة الخطأ
        $error = "<p class='style09'>يرجى عدم ترك الحقول فارغة</p>";
    }else{ 
        // الاوامر الخاصه برفع الصورة والتأكد من البيانات
        # اذا كانت الصورة فارغه
        if(empty($u_img_tmp2)){
            // رسالة الخطأ
            $error = "<p class='style09'>يرجى عدم ترك حقل الصورة فارغ</p>";
            # Set upload check to 0.
            $uploadOk = 0;
        }else{
            if($imageFileType2 != "jpg" && $imageFileType2 != "png" && $imageFileType2 != "jpeg" && $imageFileType2 != "gif" && $imageFileType2 != "pdf") {
                $error = "<p class='style09'>يرجى اختيار الامتداد المسموح به</p>";
                # Set upload check to 0.
                $uploadOk = 0;
            }
            if ($uploadOk == 0) {
                // رسالة الخطأ
                $error = "<p class='style09'>عذراً لم يتم التغيير</p>";
            }
            if ($uploadOk == 1) {
                # هذا الامر الخاص بنقل الصورة الى المجلد
                move_uploaded_file($u_img_tmp2,"book_images/$newimgproblem2");
                # Check size image, number in bit.
                if ($_FILES["$u_img2"]["size"] > 500000) {
                    # IF Image png type.
                    if($imageFileType2 == "png"){
                        # Read images to Resize it.
                        function aborahaf($filename,$percent){
                            list($width, $height) = getimagesize($filename);
                            $newwidth = $width * $percent;
                            $newheight = $height * $percent;
                            $thumb = imagecreatetruecolor($newwidth, $newheight);
                            $source = imagecreatefrompng($filename);
                            // preserve transparency START
                            imagecolortransparent($thumb, imagecolorallocatealpha($thumb, 0, 0, 0, 127));
                            imagealphablending($thumb, false);
                            imagesavealpha($thumb, true);
                            // preserve transparency end
                            imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                            imagepng($thumb, $filename);
                        }
                        # location images, Resize images to half 0.5.
                        aborahaf("book_images/$newimgproblem2", 0.5);
                    }
                    # IF Image gif type.
                    if($imageFileType2 == "gif"){
                        # Read images to Resize it.
                        function aborahaf($filename,$percent){
                            list($width, $height) = getimagesize($filename);
                            $newwidth = $width * $percent;
                            $newheight = $height * $percent;
                            $thumb = imagecreatetruecolor($newwidth, $newheight);
                            $source = imagecreatefromgif($filename);
                            // preserve transparency START
                            imagecolortransparent($thumb, imagecolorallocatealpha($thumb, 0, 0, 0, 127));
                            imagealphablending($thumb, false);
                            imagesavealpha($thumb, true);
                            // preserve transparency end
                            imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                            imagegif($thumb, $filename);
                        }
                        # location images, Resize images to half 0.5.
                        aborahaf("book_images/$newimgproblem2", 0.5);
                    }
                    # IF Image jpg type or jpeg type.
                    if($imageFileType2 == "jpg" || $imageFileType2 == "jpeg"){
                        # Read images to Resize it.
                        function aborahaf($filename,$percent){
                            list($width, $height) = getimagesize($filename);
                            $newwidth = $width * $percent;
                            $newheight = $height * $percent;
                            $thumb = imagecreatetruecolor($newwidth, $newheight);
                            $source = imagecreatefromjpeg($filename);
                            imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                            imagejpeg($thumb, $filename);
                        }
                        # location images, Resize images to half 0.5.
                        aborahaf("book_images/$newimgproblem2", 0.5);
                    }
                }
            }

        }

            //هذا الأمر خاص بإدخال البيانات في قاعدة البيانات

            $insertdata = "INSERT INTO book_info 
            (
                book_token ,
                book_name ,
                record_type ,
                book_pic ,
                pages_num 
                ) VALUES
                (
            '$bookToken',
            '$WI_post01',
            '$WI_post02',
            '$newimgproblem2',
            '$WI_post03'
            ) ";

            if(mysqli_query($connect,$insertdata)){
                echo ' <link rel="stylesheet" href="stylish.css" />';
                echo '<p class="style10">تمت إضافة الكتاب </p>' ;

                echo'<meta http-equiv="refresh" content="5; url=addtask.php"/>';
                
                exit();
            }else {
                echo'لم تتم الإضافة';
                echo'<meta http-equiv="refresh" content="5; url=addtask.php"/>';
                
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
    <title>Add Book</title>
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
        <input class="style02" require type="text" placeholder="اكتب اسم الكتاب" name="get01" />
        <input class="style02" require type="text" placeholder="اكتب نوع المهمة" name="get02" />
        <input class="style02" require type="text" placeholder="عدد صفحات الكتاب" name="get03" />

        <input type="file" name="show_img2" />
        <div class="style03" >
        <div class="main"> <input class="style04" type="submit" value="إضافة الكتاب " name="get05" /> </div>
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