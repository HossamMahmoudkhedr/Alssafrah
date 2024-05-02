<?php
include "../includes/connection.php";
include "../includes/apiResponse.php";
session_start();
if($_SERVER['REQUEST_METHOD'] === 'GET')
{
   $errors=[];
   if(!isset($_GET['id'])||empty('id'))
        $errors[] = ['id' => 'required'];
   if(!isset($_SESSION['type'])||$_SESSION['type']!='admin')
    {
        $errors[]=['security'=>'unauthorized'];
    }
    if(!empty($errors))
    {
        return ValidationResponse("validation errors",$errors);
    }
    $id=$_GET['id'];
    $query="SELECT * FROM admins WHERE id = ?";
    $stm_admin= mysqli_prepare($con,$query);
    $data=[];
    if($stm_admin)
    {
        mysqli_stmt_bind_param($stm_admin,'i',$id);
        mysqli_stmt_execute($stm_admin);
        $result = mysqli_stmt_get_result($stm_admin);
        $admin=mysqli_fetch_assoc($result);
        if(!$admin)
        {
            return FailedResponse("User not found");
        }
        unset($admin['password']);

    }
    return SuccessResponse("teacher",$admin);      
}
else{
    $errors[]=['security'=>'unsuppored method'];
    ValidationResponse("validation errors",$errors);
}