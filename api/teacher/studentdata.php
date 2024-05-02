<?php
include "../includes/connection.php";
include "../includes/apiResponse.php";
session_start();
if($_SERVER['REQUEST_METHOD'] === 'GET')
{
   $errors=[];
   if(!isset($_GET['id'])||empty($_GET['id']))
    {
        $errors[]=['id'=>'required'];
    }
   if(!isset($_SESSION['type'])||$_SESSION['type']!='teacher')
    {
        $errors[]=['security'=>'unauthorized'];
    }
    if(!empty($errors))
    {
        return ValidationResponse("validation errors",$errors);
    }
    $teacher_id=$_SESSION['id'];
    $id=$_GET['id'];
   // $admin_id = (int)$admin_id;
    $query="SELECT * FROM students WHERE teacher_id=? and id = ? ; ";
    
    $stm_students= mysqli_prepare($con,$query);
    $data=[];
    if($stm_students)
    {
        mysqli_stmt_bind_param($stm_students,'ii',$teacher_id,$id);
        mysqli_stmt_execute($stm_students);
        $result = mysqli_stmt_get_result($stm_students);
        $student = mysqli_fetch_assoc($result);
    }
    return SuccessResponse("all student data",$student);
  
}
else{
    $errors[]=['security'=>'unsuppored method'];
    ValidationResponse("validation errors",$errors);
}