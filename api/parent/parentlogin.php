<?php
include "../includes/connection.php";
include "../includes/apiResponse.php";
include "../includes/setcookie.php";

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
   
   
   //validation rules
   $errors=[];
   if(!isset($_POST['phone'])|| empty($_POST['phone']))
        $errors[]=['phone'=>'الجوال مطلوب'];
    
    if(!isset($_POST['password'])|| empty($_POST['password']))
        $errors[]=['password'=>'كلمه المرور مطلوبه '];
    if(!isset($_POST['type'])|| empty($_POST['type']))
    $errors[]=['type'=>'type must be provided'];
    else if($_POST['type']!='parent'&&$_POST['type']!='Parent')
    {
        $errors[]=['security'=>'unauthorized'];
    }
    if(!empty($errors))
    {
        return ValidationResponse("validation errors",$errors);
    }
    $phone=$_POST['phone'];
    $password=$_POST['password'];
    // get the parent phone
    $query="SELECT * FROM parents WHERE phone = ?";
    $stm= mysqli_prepare($con,$query);
    if($stm)
    {
        mysqli_stmt_bind_param($stm,'s',$phone);
        mysqli_stmt_execute($stm);
        $result = mysqli_stmt_get_result($stm);
        $parent = mysqli_fetch_assoc($result);
        if(!$parent)
        {
            return FailedResponse('لا يوجد ولي امر بهذه البيانات');
        }
        if($password!==$parent['password'])
        {
            return FailedResponse("فشل تسجيل دخول ولي الامر تحقق من كلمه المرور او رقم الجوال واعد المحاوله");
        }
      
        $parent['type']='parent';
        setCookies('parent');
        $expireTime = 3600 * 24; // 24 hour
        session_set_cookie_params($expireTime);
        session_start();
        $_SESSION['id'] =$parent['id'];//log the parent and save the valus of important things
        $_SESSION['type']='parent';
       return SuccessResponse("Done",$parent);
    }
}
else{
    $errors[]=['security'=>'unsuppored method'];
    ValidationResponse("validation errors",$errors);
}