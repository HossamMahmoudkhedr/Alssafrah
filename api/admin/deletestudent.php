<?php
include "../includes/connection.php";
include "../includes/apiResponse.php";
session_start();
if($_SERVER['REQUEST_METHOD'] === 'GET')
{
   $errors=[];
   if(!isset($_GET['id'])||empty($_GET['id']))
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
    $query="DELETE  FROM students WHERE id = ?";
    $stm_student= mysqli_prepare($con,$query);
    $data=[];
    if($stm_student)
    {
        mysqli_stmt_bind_param($stm_student,'i',$id);
        mysqli_stmt_execute($stm_student);
        //$result =;
        if(mysqli_stmt_affected_rows($stm_student) === 0)
        {
            return FailedResponse("User not found");
        }
    }
    return SuccessResponse("Done deleted");      
}
