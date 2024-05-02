<?php
include "../includes/connection.php";
include "../includes/apiResponse.php";
session_start();
if($_SERVER['REQUEST_METHOD'] === 'GET')
{
   //$email=$_POST['email'];
   
   //validation rules
   //alhalka_number
   $errors=[];
   if(!isset($_SESSION['type'])||$_SESSION['type']!='admin')
    {
        $errors[]=['security'=>'unauthorized'];
    }
    if(!empty($errors))
    {
        return ValidationResponse("validation errors",$errors);
    }
    $admin_id=$_SESSION['id'];
    $admin_id = (int)$admin_id;
    $query="SELECT * FROM teachers WHERE admin_id = ?";
    $stm_teachers= mysqli_prepare($con,$query);
    $data=[];
    if($stm_teachers)
    {
        mysqli_stmt_bind_param($stm_teachers,'i',$admin_id);
        mysqli_stmt_execute($stm_teachers);
        $result = mysqli_stmt_get_result($stm_teachers);
        while ($student = mysqli_fetch_assoc($result)) {
            $data['teachers'][] = $student;
        }
    }
    return SuccessResponse("all teachers",$data);      
}
else{
    $errors[]=['security'=>'unsuppored method'];
    ValidationResponse("validation errors",$errors);
}
