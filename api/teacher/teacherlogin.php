<?php
include "../includes/connection.php";
include "../includes/apiResponse.php";
include "../includes/setcookie.php";

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
   //$email=$_POST['email'];
   
   //validation rules
   $errors=[];
   if(!isset($_POST['email'])|| empty($_POST['email']))
        $errors[]=['email'=>'البريد الالكتروني مطلوب'];
    else 
    {
        $email=$_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = ['email' => 'بريد الكتروني غير صحيح'];
        }
    }
    if(!isset($_POST['password'])|| empty($_POST['password']))
        $errors[]=['password'=>'كلمه المرور مطلوبه'];
    if(!isset($_POST['type'])|| empty($_POST['type']))
    $errors[]=['type'=>'type must be provided'];
    else if($_POST['type']!='teacher'&&$_POST['type']!='Teacher')
    {
        $errors[]=['security'=>'unauthorized'];
    }
    if(!empty($errors))
    {
        return ValidationResponse("validation errors",$errors);
    }
    $password=$_POST['password'];
    // get the teacher email
    $query="SELECT * FROM teachers WHERE email = ?";
    $stm= mysqli_prepare($con,$query);
    if($stm)
    {
        mysqli_stmt_bind_param($stm,'s',$email);
        mysqli_stmt_execute($stm);
        $result = mysqli_stmt_get_result($stm);
        $teacher = mysqli_fetch_assoc($result);
        if(!$teacher)
        {
            return FailedResponse('فشل التسجيل لا يوجد معلم بذه البيانات ');
        }
        if($password!==$teacher['password'])
        {
            return FailedResponse('فشل تسجيل المعلم تأكد من البريد الالكتروني و كلمه المرور ثم اعد المحاوله');
        }
        
        unset($teacher['password']);//remove the password from the api response  
        $teacher['type']='teacher';
        $teacher['type']='teacher';
        setCookies('teacher');
        $expireTime = 3600 * 24; // 24 hour
        session_set_cookie_params($expireTime);
        session_start();
        $_SESSION['id'] =$teacher['id'];//log the teacher and save the valus of important things
        $_SESSION['type']='teacher';
       return SuccessResponse("Done",$teacher);
    }

}
else{
    $errors[]=['security'=>'unsuppored method'];
    ValidationResponse("validation errors",$errors);
}