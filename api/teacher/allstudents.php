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
    $teacher_id=$_SESSION['id'];
   // $admin_id = (int)$admin_id;
    $query="SELECT students.id,attend,students.name AS name ,teachers.name AS teacher_name,  teachers.Alhalka_Number FROM students JOIN teachers ON students.teacher_id = teachers.id WHERE teacher_id=?; ";
    $stm_students= mysqli_prepare($con,$query);
    $data=[];
    if($stm_students)
    {
        mysqli_stmt_bind_param($stm_students,'i',$teacher_id);
        mysqli_stmt_execute($stm_students);
        $result = mysqli_stmt_get_result($stm_students);
        //$student = mysqli_fetch_assoc($result);
        while ($student = mysqli_fetch_assoc($result)) {
            $data[]= $student;
        }
    }
    return SuccessResponse("all students",$data);
}
else{
    $errors[]=['security'=>'unsuppored method'];
    ValidationResponse("validation errors",$errors);
}