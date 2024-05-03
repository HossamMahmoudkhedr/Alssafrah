<?php
include "../includes/connection.php";
include "../includes/apiResponse.php";
$expireTime = 3600 * 24; // 24 hour
session_set_cookie_params($expireTime);
session_start();
if($_SERVER['REQUEST_METHOD'] === 'POST')
{
   
   
   //validation rules
   $errors=[];
   if(!isset($_POST['ssn'])|| empty($_POST['ssn']))
        $errors[]=['ssn'=>'رقم الهويه مطلوب'];
    
    if(!isset($_POST['type'])|| empty($_POST['type']))
    $errors[]=['type'=>'type must be provided'];
    else if($_POST['type']!='student'&&$_POST['type']!='student')
    {
        $errors[]=['security'=>'unauthorized'];
    }
    if(!empty($errors))
    {
        return ValidationResponse("validation errors",$errors);
    }
    $ssn=$_POST['ssn'];
    // get the student ssn
    $query="SELECT * FROM students WHERE ssn = ?";
    $stm= mysqli_prepare($con,$query);
    if($stm)
    {
        mysqli_stmt_bind_param($stm,'s',$ssn);
        mysqli_stmt_execute($stm);
        $result = mysqli_stmt_get_result($stm);
        $student = mysqli_fetch_assoc($result);
        if(!$student)
        {
            return FailedResponse('فشل تسجيل دخول المستخدم اعد المحاوله بأستخدام رقم هويه صحيح');
        }
        $_SESSION['id'] =$student['id'];//log the student and save the valus of important things
        $_SESSION['type']='student';
        $parent['type']='student';
       return SuccessResponse("Done",$student);
    }
}
else{
    $errors[]=['security'=>'unsuppored method'];
    ValidationResponse("validation errors",$errors);
}