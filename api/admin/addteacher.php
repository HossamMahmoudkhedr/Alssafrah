<?php
include "../includes/connection.php";
include "../includes/apiResponse.php";
session_start();
if($_SERVER['REQUEST_METHOD'] === 'POST')
{
   //$email=$_POST['email'];
   
   //validation rules
   $errors=[];
   if(!isset($_POST['name'])|| empty($_POST['name']))
        $errors[]=['name'=>'required'];
   if(!isset($_POST['email'])|| empty($_POST['email']))
        $errors[]=['email'=>'required'];
    else 
    {
        $email=$_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = ['email' => 'Invalid email format'];
        }
    }
    if(!isset($_POST['phone'])|| empty($_POST['phone']))
        $errors[]=['phone'=>'required'];
    if(!isset($_POST['password'])|| empty($_POST['password']))
        $errors[]=['password'=>'required'];
    if(!isset($_POST['alhalka_number'])|| empty($_POST['alhalka_number']))
    $errors[]=['alhalka_number'=>'required'];
    
    if(!isset($_SESSION['type'])||$_SESSION['type']!='admin')
    {
        $errors[]=['security'=>'unauthorized'];
    }
    if(!empty($errors))
    {
        return ValidationResponse("validation errors",$errors);
    }
    $name=$_POST['name'];
    $email=$_POST['email'];
    $password=password_hash($_POST['password'],PASSWORD_BCRYPT);
    $phone=$_POST['phone'];
    $admin_id=$_SESSION['id'];
    $admin_id = (int)$admin_id;
    $alhalka_number=$_POST['alhalka_number'];
    // get the teacher email
    $query="SELECT email FROM teachers WHERE email = ?";
    $stm_email= mysqli_prepare($con,$query);
    if($stm_email)
    {
        mysqli_stmt_bind_param($stm_email,'s',$email);
        mysqli_stmt_execute($stm_email);
        $result = mysqli_stmt_get_result($stm_email);
        $teacher = mysqli_fetch_assoc($result);
        if($teacher)
        {
            return FailedResponse('this user email is exist');
        }
    }
    $query="SELECT phone FROM teachers WHERE phone = ?";
    $stm_phone= mysqli_prepare($con,$query);
    if($stm_phone)
    {
        mysqli_stmt_bind_param($stm_phone,'s',$phone);
        mysqli_stmt_execute($stm_phone);
        $result = mysqli_stmt_get_result($stm_phone);
        $teacher = mysqli_fetch_assoc($result);
        if($teacher)
        {
            return FailedResponse('this user phone number is exist');
        }
    }
    $query="SELECT Alhalka_Number FROM teachers WHERE Alhalka_Number = ?";
    $stm_nlhalka_number= mysqli_prepare($con,$query);
    if($stm_nlhalka_number)
    {
        mysqli_stmt_bind_param($stm_nlhalka_number,'s',$alhalka_number);
        mysqli_stmt_execute($stm_nlhalka_number);
        $result = mysqli_stmt_get_result($stm_nlhalka_number);
        $teacher = mysqli_fetch_assoc($result);
        if($teacher)
        {
            return FailedResponse('Alhalka Number number is exist');
        }
    }
    $query="INSERT INTO teachers (name,email,password,phone,Alhalka_Number, admin_id ) VALUES(?,?,?,?,?,?)";
    $stm=mysqli_prepare($con,$query);
    if($stm)
    {
        mysqli_stmt_bind_param($stm,'ssssss',$name,$email,$password,$phone,$alhalka_number,$admin_id);
        $result=mysqli_stmt_execute($stm);
       // $result = mysqli_stmt_get_result($stm);
        //$teacher = mysqli_fetch_assoc($result);
        if(!$result)
        {
            return FailedResponse('Failed to add this teacher try agian');
        }
       return SuccessResponse("Done Teacher sucessfuly added");
    }
}