<?php
include "../includes/connection.php";
include "../includes/apiResponse.php";
session_start();
if($_SERVER['REQUEST_METHOD'] === 'GET')
{
  //user validation 
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
    $query = "SELECT students.id as id, 
    students.name AS name,
    students.parent_phone,
    students.ssn,
    IFNULL(teachers.name, '') AS teacher_name,
    IFNULL(teachers.Alhalka_Number, 'لايوجد') AS Alhalka_Number
    FROM students 
    LEFT JOIN teachers ON students.teacher_id = teachers.id;";    
    $stm_students= mysqli_prepare($con,$query);
    $data=[];
    if($stm_students)
    {
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
