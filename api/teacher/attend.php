<?php
include "../includes/connection.php";
include "../includes/apiResponse.php";
session_start();
if($_SERVER['REQUEST_METHOD'] === 'GET')
{
    $errors=[];
    if(!isset($_GET['id'])||empty($_GET['id']))
        $errors[]=['id'=>'required'];
    if(!isset($_SESSION['type'])||$_SESSION['type']!='teacher')
    {
        $errors[]=['security'=>'unauthorized'];
    }
    if(!empty($errors))
    {
        return ValidationResponse("validation errors",$errors);
    }
   
    $id=$_GET['id'];
    $attend=0;
    $query="SELECT id , attend FROM students WHERE id =?";
    $stm_students=mysqli_prepare($con,$query);
    if($stm_students)
    {
        mysqli_stmt_bind_param($stm_students,'i',$id);
        mysqli_stmt_execute($stm_students);
        $result = mysqli_stmt_get_result($stm_students);
        $student = mysqli_fetch_assoc($result);
        if($student)
        {
            if($student['attend']===0)
                $attend=1;
            $query="UPDATE students set attend=? WHERE id=?";
            $stm_student = mysqli_prepare($con, $query);
            if ($stm_student) {
                mysqli_stmt_bind_param($stm_student, 'ii',$attend,$id);
                mysqli_stmt_execute($stm_student);
            }
        }
        else
        {
            return FailedResponse('User not found');
        }
        return SuccessResponse("Done");
    }
}