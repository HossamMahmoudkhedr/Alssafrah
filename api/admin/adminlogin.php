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
        $errors[]=['email'=>"البريد الالكتروني مطلوب"];
    else 
    {
        $email=$_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = ['email' => 'البريد الاكتروني غير صحيح'];
        }
    }
    if(!isset($_POST['password'])|| empty($_POST['password']))
        $errors[]=['password'=>'كلمه المرور مطلوبه'];
    if(!isset($_POST['type'])|| empty($_POST['type']))
        $errors[]=['type'=>'type must be provided'];
    else if($_POST['type']!='admin'&&$_POST['type']!='Admin')
    {
        $errors[]=['security'=>'غير مسموح بل دخول هنا'];
    }
    if(!empty($errors))
    {
        return ValidationResponse("validation errors",$errors);
    }
    $password=$_POST['password'];
    // get the admin email
    $query="SELECT * FROM admins WHERE email = ?";
    $stm= mysqli_prepare($con,$query);
    if($stm)
    {
        mysqli_stmt_bind_param($stm,'s',$email);
        mysqli_stmt_execute($stm);
        $result = mysqli_stmt_get_result($stm);
        $admin = mysqli_fetch_assoc($result);
        if(!$admin)
        {
            return FailedResponse('فشل تسجيل الدخول برجاء التأكد من البريد الالكتروني وكلمه السر ');
        }
        if(!password_verify($password,$admin['password']))
        {
            return FailedResponse('فشل تسجيل الدخول برجاء التأكد من البريد الالكتروني وكلمه السر ');
        }
        unset($admin['password']);//remove the password from the api response  
        $admin['type']='admin';
        setCookies('admin');
        $expireTime = 3600 * 24; // 24 hour
        session_set_cookie_params($expireTime);
        session_start();
        $_SESSION['id'] =$admin['id'];//log the admin and save the valus of important things
        $_SESSION['type']='admin';
       return SuccessResponse("تم",$admin);
    }
}
else{
    $errors[]=['security'=>'طريقه غير صحيحه'];
    ValidationResponse("validation errors",$errors);
}
