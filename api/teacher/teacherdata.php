<?php
include "../includes/connection.php";
include "../includes/apiResponse.php";
session_start();
if($_SERVER['REQUEST_METHOD'] === 'GET')
{
   $errors=[];
   if(!isset($_SESSION['type'])||$_SESSION['type']!='teacher')
    {
        $errors[]=['security'=>'unauthorized'];
    }
    if(!empty($errors))
    {
        return ValidationResponse("validation errors",$errors);
    }
    $id=$_SESSION['id'];
    $query="SELECT * FROM teachers WHERE id = ?";
    $stm_teacher= mysqli_prepare($con,$query);
    $data=[];
    if($stm_teacher)
    {
        mysqli_stmt_bind_param($stm_teacher,'i',$id);
        mysqli_stmt_execute($stm_teacher);
        $result = mysqli_stmt_get_result($stm_teacher);
        $teacher=mysqli_fetch_assoc($result);
        if(!$teacher)
        {
            return FailedResponse("لا يوجد معلم بهذه البيانات");
        }
    }

    return SuccessResponse("teacher",$teacher);      
}
else{
    $errors[]=['security'=>'unsuppored method'];
    ValidationResponse("validation errors",$errors);
}