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

$WI_post01 = $_POST['get01']; //اسم الانبت الاول
$WI_post02 = $_POST['get02'];
$WI_post03 = $_POST['get03'];
$WI_post04 = $_POST['get04'];


  // الاوامر الخاصه برفع الصور
  //يقرا الصورة
  $u_img2 = @$_FILES['show_img2']['name'];
  //يحفظ الصور ب ال تيمب
$u_img_tmp2 = @$_FILES['show_img2']['tmp_name'];
    //يحفظ الصور بهذا الملف 
$target_dir = "images/";
  //يربط اسم الصورة ويا اسم الملف المحفوظ بيه الصور
$target_file2 = $target_dir . basename($_FILES["show_img2"]["name"]);
  //to compress images
$imageFileType2 = strtolower(pathinfo($target_file2,PATHINFO_EXTENSION));

$uploadOk = 1;

  //change image name
$newimgproblem2 = uniqid('mg-', true) 
. '.' . strtolower(pathinfo($_FILES['show_img2']['name'], PATHINFO_EXTENSION));

// Prepare a SELECT query to retrieve the email associated with the user ID
$sql = "SELECT user_email FROM user_info WHERE user_token = $TokenUserData";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);
$db_email = $row["user_email"];
$activated =$row["user_activated"];

$GetUserInfo = "SELECT user_email FROM user_info WHERE user_token != $TokenUserData";
$RunUserInfo = mysqli_query($connect,$GetUserInfo);
$RowUserInfo = mysqli_fetch_array($RunUserInfo);
$emailUser =$RowUserInfo['user_email'];

if(isset($_POST['get05'])){
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

            }else {
                if($WI_post03 == $emailUser){
                   $error = "<p class='style09'> هذا الايميل مستخدم بالفعل</p>";
                    }
                    elseif ($WI_post03 != $db_email) {
                        
                        $sql = "UPDATE user_info SET user_activated=false WHERE user_token = $TokenUserData";
                        $result = mysqli_query($connect, $sql);
                            //هذا الامر خاص بتحديث البيانات 
                      $updateDataInfo = "UPDATE user_info SET
                      user_name = '$WI_post01',
                      user_password = '$WI_post02' ,
                      user_email = '$WI_post03' ,
                      user_birthday = '$WI_post04' ,
                      user_img = '$newimgproblem2'
                  WHERE user_token = '$TokenUserData'
                  ";
  
              //اذا جانت البيانات متحدثة يسوي رفرش بنفس اللحظة ويبقى بنفس الصفحة
              if(mysqli_query($connect,$updateDataInfo)){
                echo'تم تغيير الايميل يرجى تأكيد الحساب مرة اخرى';
                echo'<meta http-equiv="refresh" content="5; url=logout.php"/>';
                require_once "mail.php";
                $mail->addAddress($WI_post03);
                $mail->Subject = "رمز التحقق من البريد الألكتروني";
                $mail->Body = '<h1> شكرا لتسجيلك في موقعنا</h1>'
                . "<div> رابط التحقق من الحساب" . "<div>" . 
                "<a href='http://localhost/webiraq/active.php?code=".$TokenUserData  . "'>
                 " . "http://localhost/webiraq/active.php?code=" .$TokenUserData . "</a>";
              
                $mail->setFrom('suhadkanan@yahoo.com', 'Suhad Kanaan');
                $mail->send();
                  exit();
                  }
                  else {
                  echo'لم يتم التحديث';
                  echo'<meta http-equiv="refresh" content="5; url=signup.php"/>';
                  
                  exit();
                  }
                        

                    } 
                    else{
        
                // الاوامر الخاصه برفع الصورة والتأكد من البيانات
              # اذا كانت الصورة فارغه
              if(empty($u_img2)){
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
                      move_uploaded_file($u_img_tmp2,"images/$newimgproblem2");
                      # Check size image, number in bit.
                        //الاوامر خاصة بتقليل حجم الصورة
                      if ($_FILES["u_img"]["size"] > 500000) {
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
                              aborahaf("images/$newimgproblem2", 0.5);
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
                              aborahaf("images/$newimgproblem2", 0.5);
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
                              aborahaf("products_imgs/$newimgproblem2", 0.5);
                          }
                      }
                  }}
      
                  if($imageFileType2 == ''){$newimgproblem2 = $RowDataUser['user_img'];}
      
                      //هذا الامر خاص بتحديث البيانات 
                      $updateDataInfo = "UPDATE user_info SET
                          user_name = '$WI_post01',
                          user_password = '$WI_post02' ,
                          user_email = '$WI_post03' ,
                          user_birthday = '$WI_post04' ,
                          user_img = '$newimgproblem2'
                      WHERE user_token = '$TokenUserData'
                      ";
      
                  //اذا جانت البيانات متحدثة يسوي رفرش بنفس اللحظة ويبقى بنفس الصفحة
                  if(mysqli_query($connect,$updateDataInfo)){
                      echo'<meta http-equiv="refresh" content="0; url=profile.php"/>';
                      exit();
                      }
                      else {
                      echo'لم يتم التحديث';
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
    <title>بيانات المستخدم</title>
    <link rel="stylesheet" href="stylish.css" media="screen"/>
    <link href="fontawsom/css/all.css" rel="stylesheet">
    <link href="fontawsom/css/fontawesome.css" rel="stylesheet">
    <link href="fontawsom/css/brands.css" rel="stylesheet">
    <link href="fontawsom/css/solid.css" rel="stylesheet">
</head>
<body>
    

<form action="" method="post" enctype="multipart/form-data"> 

    <div class="style01">


<?php echo $error; ?>
<img class="style13" src="images/<?php echo $RowDataUser['user_img']; ?>" /></br/>
<input class="style02" value="<?php echo $RowDataUser['user_name']; ?>" require type="text" placeholder="اكتب اسم المستخدم" name="get01" />
<input class="style02" value="<?php echo $RowDataUser['user_password']; ?> "require type="password" placeholder="اكتب كلمة المرور" name="get02" />
<input class="style02" value="<?php echo $RowDataUser['user_email']; ?> " require type="email" placeholder="اكتب الايميل" name="get03" />
<input class="style02" value="<?php echo $RowDataUser['user_birthday']; ?>" type="date" placeholder="اكتب المواليد" name="get04" />
<input type="file" name="show_img2" />
<div class="style03" >
<div class="main"> <input class="style04" type="submit" value="تعديل البيانات" name="get05"/> </div>
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