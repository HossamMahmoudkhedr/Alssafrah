<?php
// Including necessary files
include "../includes/connection.php"; // Include database connection file
include "../includes/apiResponse.php"; // Include API response file
// Check if the request method is POST
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    // User validation
    $errors=[];

    // Check if email is set and not empty
    if(!isset($_POST['email']) || empty($_POST['email']))
        $errors[]=['email'=>"البريد الالكتروني مطلوب"];
    else {
        $email=$_POST['email'];
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = ['email' => 'البريد الاكتروني غير صحيح'];
        }
    }

    // Check if password is set and not empty
    if(!isset($_POST['password']) || empty($_POST['password']))
        $errors[]=['password'=>'كلمه المرور مطلوبه'];

    // Check if type is set and not empty
    if(!isset($_POST['type']) || empty($_POST['type']))
        $errors[]=['type'=>'type must be provided'];
    else if($_POST['type']!='admin' && $_POST['type']!='Admin') {
        $errors[]=['security'=>'غير مسموح بل دخول هنا'];
    }

    // If there are validation errors, return validation response
    if(!empty($errors)) {
        return ValidationResponse("validation errors", $errors);
    }

    // Get password from the form
    $password=$_POST['password'];

    // Get the admin email from the database
    $query="SELECT * FROM admins WHERE email = ?";
    $stm= mysqli_prepare($con,$query);

    // If statement is prepared successfully
    if($stm) {
        mysqli_stmt_bind_param($stm,'s',$email);
        mysqli_stmt_execute($stm);
        $result = mysqli_stmt_get_result($stm);
        $admin = mysqli_fetch_assoc($result);

        // If admin not found, return failed response
        if(!$admin) {
            return FailedResponse('فشل تسجيل الدخول برجاء التأكد من البريد الالكتروني وكلمه السر ');
        }

        // If password does not match, return failed response
        if(!password_verify($password,$admin['password'])) {
            return FailedResponse('فشل تسجيل الدخول برجاء التأكد من البريد الالكتروني وكلمه السر ');
        }

        // Remove the password from the API response
        unset($admin['password']);

        // Add admin type
        $admin['type']='admin';

        // Set session expiration time
        $expireTime = 3600 * 24; // 24 hours

        // Start session
        session_set_cookie_params($expireTime);
        session_start();

        // Log the admin and save important values in session
        $_SESSION['id'] = $admin['id'];
        $_SESSION['type']='admin';

        // Return success response with admin details
        return SuccessResponse("تم",$admin);
    }
} else {
    // If request method is not POST, return security error
    $errors[]=['security'=>'طريقه غير صحيحه'];
    ValidationResponse("validation errors",$errors);
}
