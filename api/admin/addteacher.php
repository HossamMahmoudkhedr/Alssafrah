<?php
// Including necessary files
include "../includes/connection.php"; // Include database connection file
include "../includes/apiResponse.php"; // Include API response file

// Starting session
session_start();

// Checking if the request method is POST
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    // User validation 
    $errors=[];

    // Check if name is set and not empty
    if(!isset($_POST['name']) || empty($_POST['name']))
        $errors[]=['name'=>'الاسم مطلوب'];

    // Check if email is set and not empty, and validate its format
    if(!isset($_POST['email']) || empty($_POST['email']))
        $errors[]=['email'=>'البريد الالكتروني مطلوب'];
    else {
        $email=$_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = ['email' => 'البريد الاكتروني غير صحيح'];
        }
    }

    // Check if phone is set and not empty
    if(!isset($_POST['phone']) || empty($_POST['phone']))
        $errors[]=['phone'=>'رقم الجوال مطلوب'];

    // Check if password is set and not empty
    if(!isset($_POST['password']) || empty($_POST['password']))
        $errors[]=['password'=>'كلمه المرور مطلوبه'];

    // Check if alhalka_number is set and not empty
    if(!isset($_POST['alhalka_number']) || empty($_POST['alhalka_number']))
        $errors[]=['alhalka_number'=>'رقم الحلقه مطلوب'];
    
    // Check if session type is set and equals 'admin'
    if(!isset($_SESSION['type']) || $_SESSION['type']!='admin') {
        $errors[]=['security'=>'غير مسموح بل دخول هنا'];
    }

    // If there are validation errors, return validation response
    if(!empty($errors)) {
        return ValidationResponse("خطأ في ادخال البيانات",$errors);
    }

    // Assigning variables from POST data
    $name=$_POST['name'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $phone=$_POST['phone'];
    $admin_id=$_SESSION['id'];
    $admin_id = (int)$admin_id;
    $alhalka_number=$_POST['alhalka_number'];

    // Check if the email already exists in the database
    $query="SELECT email FROM teachers WHERE email = ?";
    $stm_email= mysqli_prepare($con,$query);

    // If statement is prepared successfully
    if($stm_email) {
        mysqli_stmt_bind_param($stm_email,'s',$email);
        mysqli_stmt_execute($stm_email);
        $result = mysqli_stmt_get_result($stm_email);
        $teacher = mysqli_fetch_assoc($result);

        // If email already exists, return failed response
        if($teacher) {
            return FailedResponse('البريد الالكتروني موجود');
        }
    }

    // Check if the phone already exists in the database
    $query="SELECT phone FROM teachers WHERE phone = ?";
    $stm_phone= mysqli_prepare($con,$query);

    // If statement is prepared successfully
    if($stm_phone) {
        mysqli_stmt_bind_param($stm_phone,'s',$phone);
        mysqli_stmt_execute($stm_phone);
        $result = mysqli_stmt_get_result($stm_phone);
        $teacher = mysqli_fetch_assoc($result);

        // If phone already exists, return failed response
        if($teacher) {
            return FailedResponse('رقم الجوال موجود');
        }
    }

    // Check if the alhalka_number already exists in the database
    $query="SELECT Alhalka_Number FROM teachers WHERE Alhalka_Number = ?";
    $stm_nlhalka_number= mysqli_prepare($con,$query);

    // If statement is prepared successfully
    if($stm_nlhalka_number) {
        mysqli_stmt_bind_param($stm_nlhalka_number,'s',$alhalka_number);
        mysqli_stmt_execute($stm_nlhalka_number);
        $result = mysqli_stmt_get_result($stm_nlhalka_number);
        $teacher = mysqli_fetch_assoc($result);

        // If alhalka_number already exists, return failed response
        if($teacher) {
            return FailedResponse('رقم الحلقه موجود');
        }
    }

    // Insert teacher data into database
    $query="INSERT INTO teachers (name,email,password,phone,Alhalka_Number, admin_id ) VALUES(?,?,?,?,?,?)";
    $stm=mysqli_prepare($con,$query);

    // If statement is prepared successfully
    if($stm) {
        mysqli_stmt_bind_param($stm,'ssssss',$name,$email,$password,$phone,$alhalka_number,$admin_id);
        $result=mysqli_stmt_execute($stm);

        // If insertion fails, return failed response
        if(!$result) {
            return FailedResponse('فشل اضافه المعلم');
        }
        // Return success response
        return SuccessResponse("تمت اضافه المعلم");
    }
} else {
    // If request method is not POST, return security error
    $errors[]=['security'=>'طريقه غير صحيحه'];
    ValidationResponse("validation errors",$errors);
}
