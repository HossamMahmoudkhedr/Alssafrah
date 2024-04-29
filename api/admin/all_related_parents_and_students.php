<?php
include "../includes/connection.php";
include "../includes/apiResponse.php";
session_start();
if($_SERVER['REQUEST_METHOD'] === 'GET')
{
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
    $query="SELECT parents.id , parents.name AS parent_name, parents.email ,parents.phone,students.name AS child_name ,teachers.name AS teacher_name,  teachers.Alhalka_Number FROM parents INNER JOIN students ON students.parent_id = parents.id INNER JOIN teachers ON students.teacher_id = teachers.id; ";
    
    $stm_students= mysqli_prepare($con,$query);
    $data=[];
    if($stm_students)
    {
        mysqli_stmt_execute($stm_students);
        $result = mysqli_stmt_get_result($stm_students);
        //$student = mysqli_fetch_assoc($result);
        while ($student = mysqli_fetch_assoc($result)) {
            $data['parants_with_students'][] = $student;
        }
    }
    /*
    $query="SELECT parents.id , parents.name AS parent_name, parents.email ,parents.phone FROM parents LEFT JOIN  students ON students.parent_phone = parents.phone WHERE students.parent_id IS NULL;";
    $stm_students_null= mysqli_prepare($con,$query);
    if($stm_students_null)
    {
        mysqli_stmt_execute($stm_students_null);
        $result = mysqli_stmt_get_result($stm_students_null);
        while ($student = mysqli_fetch_assoc($result)) {
            $data['without_parents'][] = $student;
        }
    }*/
    return SuccessResponse("all students",$data);

        
      
}
