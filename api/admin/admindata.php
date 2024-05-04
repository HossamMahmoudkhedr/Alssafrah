<?php
// Including necessary files
include "../includes/connection.php"; // Include database connection file
include "../includes/apiResponse.php"; // Include API response file

// Starting session
session_start();

// Checking if the request method is GET
if($_SERVER['REQUEST_METHOD'] === 'GET') {
    // User validation 
    $errors=[];

    // Check if id is set and not empty
    if(!isset($_GET['id']) || empty($_GET['id']))
        $errors[] = ['id' => 'required'];

    // Check if session type is set and equals 'admin'
    if(!isset($_SESSION['type']) || $_SESSION['type']!='admin') {
        $errors[]=['security'=>'غير مسموح بل دخول هنا'];
    }

    // If there are validation errors, return validation response
    if(!empty($errors)) {
        return ValidationResponse("validation errors",$errors);
    }

    // Assigning variable from GET data
    $id=$_SESSION['id'];;

    // Get admin data from database based on provided id
    $query="SELECT * FROM admins WHERE id = ?";
    $stm_admin= mysqli_prepare($con,$query);
    $data=[];
    if($stm_admin) {
        mysqli_stmt_bind_param($stm_admin,'i',$id);
        mysqli_stmt_execute($stm_admin);
        $result = mysqli_stmt_get_result($stm_admin);
        $admin=mysqli_fetch_assoc($result);

        // If admin not found, return failed response
        if(!$admin) {
            return FailedResponse("المستخدم غير موجود");
        }

        // Remove password field from admin data
        unset($admin['password']);
    }

    // Return success response with admin details
    return SuccessResponse("الادمن",$admin);      
} else {
    // If request method is not GET, return security error
    $errors[]=['security'=>'طريقه غير صحيحه'];
    ValidationResponse("validation errors",$errors);
}
