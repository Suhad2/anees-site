<?php
session_start();
include "lujain.php";
global $connect ;

if(isset($_POST['stud_delete_btn']))
{
    $id = $_POST['delete_stud_id'];

    $query = "DELETE FROM user_info WHERE user_id='$id' ";
    $query_run = mysqli_query($connect, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Data Deleted Successfully";
        header("Location: logout.php");
    }
    else
    {
        $_SESSION['status'] = "Data Not Deleted";
        header("Location: deleteUser.php");
    }
}

?>