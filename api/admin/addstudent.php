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
        $errors[]=['parent_phone'=>'رقم ولي المر مطلوب'];
    if(!isset($_POST['alhalka_number'])|| empty($_POST['alhalka_number']))
    $errors[]=['alhalka_number'=>'رقم الحلقه مطلوب'];
   if(!isset($_SESSION['type'])||$_SESSION['type']!='admin')
    {
        $errors[]=['security'=>'غير مسموح بل دخول هنا'];
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
    // get the parent email
    $query="SELECT ssn FROM students WHERE ssn = ?";
    $stm_ssn= mysqli_prepare($con,$query);
    if($stm_ssn)
    {
        mysqli_stmt_bind_param($stm_ssn,'s',$ssn);
        mysqli_stmt_execute($stm_ssn);
        $result = mysqli_stmt_get_result($stm_ssn);
        $student = mysqli_fetch_assoc($result);
        if($student)
        {
            return FailedResponse('رقم الهويه موجود بلفعل');
        }
    }
    $query="SELECT id , Alhalka_Number FROM teachers WHERE Alhalka_Number = ?";
    $stm_teacher= mysqli_prepare($con,$query);
    if($stm_teacher)
    {
        mysqli_stmt_bind_param($stm_teacher,'i',$alhalka_number);
        mysqli_stmt_execute($stm_teacher);
        $result = mysqli_stmt_get_result($stm_teacher);
        $teacher = mysqli_fetch_assoc($result);
        if(!$teacher)
        {
            return FailedResponse('لا يوجد حلقه بهذا الرقم');
        }
        $teacher_id=$teacher['id'];
    }
    $query = "INSERT INTO students (name,ssn,parent_phone,admin_id,teacher_id ) VALUES(?,?,?,?,?)";
    $stm = mysqli_prepare($con, $query);
    if ($stm) {
        mysqli_stmt_bind_param($stm, 'sssii', $name, $ssn, $parent_phone, $admin_id,$teacher_id);
        $result = mysqli_stmt_execute($stm);
        if (!$result) {
            return FailedResponse('فشل اضافه الطالب ');
        }
        $query_parent = "SELECT id , phone FROM parents WHERE phone = ?";
        $stm_parent = mysqli_prepare($con, $query_parent);
        if ($stm_parent) {
            mysqli_stmt_bind_param($stm_parent, 's', $parent_phone);
            mysqli_stmt_execute($stm_parent);
            $result_parent = mysqli_stmt_get_result($stm_parent);
            $parent=mysqli_fetch_assoc($result_parent);
            if($parent)
            {
            // If there are parent phone with the same parent_phone
            $parent_id=$parent['id'];
            if($result_parent->num_rows==1)
            {
                $query_insert_student = "UPDATE students SET parent_id = ? WHERE parent_phone = ?";
                $stm_insert_student = mysqli_prepare($con, $query_insert_student);
                if ($stm_insert_student) {
                    mysqli_stmt_bind_param($stm_insert_student, 'is',$parent_id , $parent_phone);//is i=>integer s =>string
                    mysqli_stmt_execute($stm_insert_student);
                }
            }
            }
        }
        return SuccessResponse("تمتت اضافه الطالب بنجاح");
    }
}
else{
    $errors[]=['security'=>'طريقه غير صحيحه'];
    ValidationResponse("validation errors",$errors);
}