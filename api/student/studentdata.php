<?php
include "../includes/connection.php";
include "../includes/apiResponse.php";
session_start();
if($_SERVER['REQUEST_METHOD'] === 'GET')
{
   $errors=[];
   
   if(!isset($_SESSION['type'])||$_SESSION['type']!='student')
    {
        $errors[]=['security'=>'unauthorized'];
    }
    if(!empty($errors))
    {
        return ValidationResponse("validation errors",$errors);
    }
    $student_id=$_SESSION['id'];
   
   // $admin_id = (int)$admin_id;
    $query="SELECT * FROM students WHERE id = ? ; ";
    
    $stm_student= mysqli_prepare($con,$query);
    $data=[];
    if($stm_student)
    {
        mysqli_stmt_bind_param($stm_student,'i',$student_id);
        mysqli_stmt_execute($stm_student);
        $result = mysqli_stmt_get_result($stm_student);
        $student = mysqli_fetch_assoc($result);
    }
    return SuccessResponse("all student data",$student);

        
      
}
