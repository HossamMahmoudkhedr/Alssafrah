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
   if(!isset($_SESSION['type'])||$_SESSION['type']!='parent')
    {
        $errors[]=['security'=>'unauthorized'];
    }
    if(!empty($errors))
    {
        return ValidationResponse("validation errors",$errors);
    }
    $parent_id=$_SESSION['id'];
    $id=$_GET['id'];
   // $admin_id = (int)$admin_id;
    $query="SELECT * FROM students WHERE parent_id=? and id = ? ; ";
    
    $stm_students= mysqli_prepare($con,$query);
    $data=[];
    if($stm_students)
    {
        mysqli_stmt_bind_param($stm_students,'ii',$parent_id,$id);
        mysqli_stmt_execute($stm_students);
        $result = mysqli_stmt_get_result($stm_students);
        //$student = mysqli_fetch_assoc($result);
        while ($student = mysqli_fetch_assoc($result)) {
            $data[]= $student;
        }
    }
    return SuccessResponse("all student data",$data);
}
else{
    $errors[]=['security'=>'unsuppored method'];
    ValidationResponse("validation errors",$errors);
}
