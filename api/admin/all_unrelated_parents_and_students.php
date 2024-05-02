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
   // $query="SELECT * FROM students WHERE admin_id = ? and parent_id IS NOT NULL";
    //$stm_students= mysqli_prepare($con,$query);
    $data=[];
    /*
    if($stm_students)
    {
        mysqli_stmt_bind_param($stm_students,'i',$admin_id);
        mysqli_stmt_execute($stm_students);
        $result = mysqli_stmt_get_result($stm_students);
        //$student = mysqli_fetch_assoc($result);
        while ($student = mysqli_fetch_assoc($result)) {
            $data['with_students'][] = $student;
        }
    }*/
    $query="SELECT students.name , ssn ,parent_phone,teachers.name,Alhalka_Number FROM students INNER JOIN teachers ON students.teacher_id = teachers.id WHERE students.admin_id = ? and parent_id IS NULL";
    $stm_students_null= mysqli_prepare($con,$query);
    if($stm_students_null)
    {
        mysqli_stmt_bind_param($stm_students_null,'i',$admin_id);
        mysqli_stmt_execute($stm_students_null);
        $result = mysqli_stmt_get_result($stm_students_null);
        while ($student = mysqli_fetch_assoc($result)) {
            $data['students_without_parents'][] = $student;
        }
    }
    $query="SELECT parents.id , parents.name AS parent_name, parents.email ,parents.phone FROM parents LEFT JOIN  students ON students.parent_phone = parents.phone WHERE students.parent_id IS NULL;";
    $stm_students_null= mysqli_prepare($con,$query);
    if($stm_students_null)
    {
        mysqli_stmt_execute($stm_students_null);
        $result = mysqli_stmt_get_result($stm_students_null);
        while ($student = mysqli_fetch_assoc($result)) {
            $data['parents_without_students'][] = $student;
        }
    }
    return SuccessResponse("all unrelated useres",$data);  
}
else{
    $errors[]=['security'=>'unsuppored method'];
    ValidationResponse("validation errors",$errors);
}
