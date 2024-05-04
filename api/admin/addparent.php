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
    if(!isset($_POST['phone'])|| empty($_POST['phone']))
        $errors[]=['phone'=>'رقم الجوال مطلوب'];
    if(!isset($_POST['password'])|| empty($_POST['password']))
        $errors[]=['password'=>'كلمه المرور مطلوبه'];
   if(!isset($_SESSION['type'])||$_SESSION['type']!='admin')
    {
        $errors[]=['security'=>'غير مسموح بل دخول هنا'];
    }
    if(!empty($errors))
    {
        return ValidationResponse("خطأ في ادخال البيانات",$errors);
    }
    $name=$_POST['name'];
    $password=$_POST['password'];
    $phone=$_POST['phone'];
    $admin_id=$_SESSION['id'];
    $admin_id = (int)$admin_id;
    //check if there is exist phone in the table 
    $query="SELECT phone FROM parents WHERE phone = ?";
    $stm_phone= mysqli_prepare($con,$query);
    if($stm_phone)
    {
        mysqli_stmt_bind_param($stm_phone,'s',$phone);
        mysqli_stmt_execute($stm_phone);
        $result = mysqli_stmt_get_result($stm_phone);
        $parent = mysqli_fetch_assoc($result);
        if($parent)
        {
            return FailedResponse('هذا الجوال مستخدم بلفعل');
        }
    }
    //insert data into the table 
    $query = "INSERT INTO parents (name,password,phone, admin_id ) VALUES(?,?,?,?)";
    $stm = mysqli_prepare($con, $query);
    if ($stm) {
        mysqli_stmt_bind_param($stm, 'ssss', $name, $password, $phone, $admin_id);
        $result = mysqli_stmt_execute($stm);
        if (!$result) {
            return FailedResponse('هنالك خطاء حاول من جديد');
        }
        // Retrieve the inserted parent_id
        $parent_id = mysqli_insert_id($con);
    
        // Check if any student with the same parent_phone exists
        $query_student = "SELECT parent_id FROM students WHERE parent_phone = ?";
        $stm_student = mysqli_prepare($con, $query_student);
        if ($stm_student) {
            mysqli_stmt_bind_param($stm_student, 's', $phone);
            mysqli_stmt_execute($stm_student);
            $result_student = mysqli_stmt_get_result($stm_student);
            
            // If there are students with the same parent_phone
            if ($result_student->num_rows > 0) {
                // Loop through each row
                while ($student = mysqli_fetch_assoc($result_student)) {
                    // If the parent_id is null for any student, insert the parent_id
                    if ($student['parent_id'] === null) {
                        $query_insert_student = "UPDATE students SET parent_id = ? WHERE parent_phone = ?";
                        $stm_insert_student = mysqli_prepare($con, $query_insert_student);
                        if ($stm_insert_student) {
                            mysqli_stmt_bind_param($stm_insert_student, 'is', $parent_id, $phone);//is i=>integer s =>string
                            mysqli_stmt_execute($stm_insert_student);
                        }
                    }
                }
            } 
        }
        return SuccessResponse("تمت اضافه ولي الامر بنجاح");
    }
}
else{
    $errors[]=['security'=>'طريقه غير صحيحه'];
    ValidationResponse("validation errors",$errors);
}