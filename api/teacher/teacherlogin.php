<?php
include "../includes/connection.php";
include "../includes/apiResponse.php";
session_start();
$expireTime = 3600 * 24; // 24 hour
session_set_cookie_params($expireTime);
if($_SERVER['REQUEST_METHOD'] === 'POST')
{
   //$email=$_POST['email'];
   
   //validation rules
   $errors=[];
   if(!isset($_POST['email'])|| empty($_POST['email']))
        $errors[]=['email'=>'required'];
    else 
    {
        $email=$_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = ['email' => 'Invalid email format'];
        }
    }
    if(!isset($_POST['password'])|| empty($_POST['password']))
        $errors[]=['password'=>'required'];
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
            return FailedResponse('Failed to login admin in correct password or email ');
        }
        if(!password_verify($password,$admin['password']))
        {
            return FailedResponse('Failed to login admin in correct password or email');
        }
        $_SESSION['admin_email'] =$admin['email'];//log the admin and save the valus of important things
        $_SESSION['type']='admin';
        unset($admin['password']);//remove the password from the api response  
        $admin['type']='admin';
       return SuccessResponse("Done",$admin);
    }
}
