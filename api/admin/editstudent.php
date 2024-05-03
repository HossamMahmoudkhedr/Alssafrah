<?php
include "../includes/connection.php";
include "../includes/apiResponse.php";
session_start();
if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    //user validation 

   $errors=[];
   if(!isset($_POST['name'])|| empty($_POST['name']))
        $errors[]=['name'=>'الاسم مطلوب'];
   if(!isset($_POST['ssn'])|| empty($_POST['ssn']))
    $errors[]=['ssn'=>'رقم الهويه مطلوب'];
    if(!isset($_POST['parent_phone'])|| empty($_POST['parent_phone']))
        $errors[]=['parent_phone'=>'رقم جوال الوالد مطلوب'];
    if(!isset($_POST['alhalka_number'])|| empty($_POST['alhalka_number']))
    $errors[]=['alhalka_number'=>'required'];
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        $errors[] = ['id' => 'required'];
    }
   if(!isset($_SESSION['type'])||$_SESSION['type']!='admin')
    {
        $errors[]=['security'=>'unauthorized'];
    }
    if(isset($_POST['alhalka_number']))
    {
        $query="SELECT id , Alhalka_Number from teachers WHERE Alhalka_Number=?";
        $stm_teacher = mysqli_prepare($con, $query);
        if ($stm_teacher) {
            mysqli_stmt_bind_param($stm_teacher, 's', $_POST['alhalka_number']);
            mysqli_stmt_execute($stm_teacher);
            $result = mysqli_stmt_get_result($stm_teacher);
            $teacher = mysqli_fetch_assoc($result);

            if($teacher) {
                $teacher_id=$teacher['id'];
            }
            else
            {
                $errors[]=['alhalka_number'=>'not exist'];
            }
        } 
    }
    if(!empty($errors))
    {
        return ValidationResponse("validation errors",$errors);
    }
    $name=$_POST['name'];
    $ssn=$_POST['ssn'];
    $parent_phone=$_POST['parent_phone'];
    $admin_id=$_SESSION['id'];
    $admin_id = (int)$admin_id;
    $alhalka_number=$_POST['alhalka_number'];
    $id=$_POST['id'];
    // get the parent email
    $query="SELECT * FROM students WHERE id =?";
    $stm_students=mysqli_prepare($con,$query);
    if($stm_students)
    {
        mysqli_stmt_bind_param($stm_students,'i',$id);
        mysqli_stmt_execute($stm_students);
        $result = mysqli_stmt_get_result($stm_students);
        $student = mysqli_fetch_assoc($result);
        if($student)
        {
            if($student['ssn']!==$ssn)
            {
                $query="SELECT id , ssn from students WHERE ssn=?";
                $stm_ssn = mysqli_prepare($con, $query);
                if ($stm_ssn) {
                    mysqli_stmt_bind_param($stm_ssn, 's', $ssn);
                    mysqli_stmt_execute($stm_ssn);
                    $result = mysqli_stmt_get_result($stm_ssn);
                    $student_ssn = mysqli_fetch_assoc($result);
                    if ($student_ssn && $student_ssn['id'] !== $id) {
                        return FailedResponse('This ssn is already in use');
                    }
                } 
            }
            $query="SELECT id , phone from parents WHERE phone=?";
            $stm_parent = mysqli_prepare($con, $query);
            if ($stm_parent) {
                mysqli_stmt_bind_param($stm_parent, 's', $parent_phone);
                mysqli_stmt_execute($stm_parent);
                $result = mysqli_stmt_get_result($stm_parent);
                $parent = mysqli_fetch_assoc($result);
                $parent_id=null;
                if($parent) {
                    $parent_id=$parent['id'];
                }
            }
            $query="UPDATE students set name=?, ssn=?, parent_phone=?, teacher_id=?,parent_id=? WHERE id=?";
            $stm_student = mysqli_prepare($con, $query);
            if ($stm_student) {
                mysqli_stmt_bind_param($stm_student, 'sssiii', $name,$ssn,$parent_phone,$teacher_id,$parent_id,$id);
                mysqli_stmt_execute($stm_student);
                $result = mysqli_stmt_get_result($stm_student);
            }
        }
        else
        {
            return FailedResponse('User not found');
        }
        return SuccessResponse("student successfully updated");
    }
}
else{
    $errors[]=['security'=>'unsuppored method'];
    ValidationResponse("validation errors",$errors);
}