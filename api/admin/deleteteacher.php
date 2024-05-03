<?php
include "../includes/connection.php";
include "../includes/apiResponse.php";
session_start();
if($_SERVER['REQUEST_METHOD'] === 'GET')
{
    //user validation 
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
    $query="SELECT id from students WHERE teacher_id=?";
    $stm_students= mysqli_prepare($con,$query);    
    if($stm_students)
    {
        mysqli_stmt_bind_param($stm_students,'i',$id);
        mysqli_stmt_execute($stm_students);
        $result = mysqli_stmt_get_result($stm_students);
        while($student=mysqli_fetch_assoc($result))
        {
            $query="UPDATE students SET teacher_id=null WHERE id = ?";
            $stm_student= mysqli_prepare($con,$query);
            if($stm_student)
            {
                mysqli_stmt_bind_param($stm_student,'i',$student['id']);
                mysqli_stmt_execute($stm_student);
            }
        }
    }
    $query="DELETE  FROM teachers WHERE id = ?";
    $stm_parent= mysqli_prepare($con,$query);
    $data=[];
    if($stm_parent)
    {
        mysqli_stmt_bind_param($stm_parent,'i',$id);
        mysqli_stmt_execute($stm_parent);
        //$result =;
        if(mysqli_stmt_affected_rows($stm_parent) === 0)
        {
            return FailedResponse("User not found");
        }
    }
    return SuccessResponse("Done deleted");      
}
else{
    $errors[]=['security'=>'unsuppored method'];
    ValidationResponse("validation errors",$errors);
}