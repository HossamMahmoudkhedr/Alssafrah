<?php
include "../includes/connection.php";
include "../includes/apiResponse.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];

    // Validate name
    if (!isset($_POST['name']) || empty($_POST['name'])) {
        $errors[] = ['name' => 'required'];
    }

    // Validate id
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        $errors[] = ['id' => 'required'];
    }

    // Validate email
    if (!isset($_POST['email']) || empty($_POST['email'])) {
        $errors[] = ['email' => 'required'];
    } else {
        $email = $_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = ['email' => 'Invalid email format'];
        }
    }

    // Validate phone
    if (!isset($_POST['phone']) || empty($_POST['phone'])) {
        $errors[] = ['phone' => 'required'];
    }

    // Validate alhalka_number
    if (!isset($_POST['alhalka_number']) || empty($_POST['alhalka_number'])) {
        $errors[] = ['alhalka_number' => 'required'];
    }

    // Check admin authorization
    if (!isset($_SESSION['type']) || $_SESSION['type'] !== 'admin') {
        $errors[] = ['security' => 'unauthorized'];
    }

    // Check if there are validation errors
    if (!empty($errors)) {
        return ValidationResponse("Validation errors", $errors);
    }

    // Extract data from POST
    $id = (int)$_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $alhalka_number = $_POST['alhalka_number'];
    $password = isset($_POST['newpassword']) ? $_POST['newpassword'] : null;

    $query = "SELECT * FROM teachers WHERE id=?";
    $stm_teachers = mysqli_prepare($con, $query);
    if($stm_teachers)
    {
        mysqli_stmt_bind_param($stm_teachers, 'i', $id);
        mysqli_stmt_execute($stm_teachers);
        $result = mysqli_stmt_get_result($stm_teachers);
        $teacher = mysqli_fetch_assoc($result);
        if($teacher)
        {
            // Check if the email is already in use by another user
            if ($teacher['email'] !== $email) {
                $query = "SELECT id FROM teachers WHERE email = ?";
                $stm_email = mysqli_prepare($con, $query);
                if ($stm_email) {
                    mysqli_stmt_bind_param($stm_email, 's', $email);
                    mysqli_stmt_execute($stm_email);
                    $result = mysqli_stmt_get_result($stm_email);
                    $teacher_email = mysqli_fetch_assoc($result);
                    if ($teacher_email && $teacher_email['id'] !== $id) {
                        return FailedResponse('This email is already in use');
                    }
                } 
            }
            $query = "SELECT id FROM teachers WHERE phone = ?";
            $stm_phone = mysqli_prepare($con, $query);
            if ($stm_phone) {
                mysqli_stmt_bind_param($stm_phone, 's', $phone);
                mysqli_stmt_execute($stm_phone);
                $result = mysqli_stmt_get_result($stm_phone);
                $teacher_phone = mysqli_fetch_assoc($result);
                if ($teacher_phone && $teacher_phone['id'] !== $id) {
                    return FailedResponse('This phone number is already in use');
                }
            }
            // Check if the Alhalka number is already in use by another user
            $query = "SELECT id FROM teachers WHERE Alhalka_Number = ?";
            $stm_alhalka = mysqli_prepare($con, $query);
            if ($stm_alhalka) {
                mysqli_stmt_bind_param($stm_alhalka, 's', $alhalka_number);
                mysqli_stmt_execute($stm_alhalka);
                $result = mysqli_stmt_get_result($stm_alhalka);
                $teacher_alhalka = mysqli_fetch_assoc($result);
                if ($teacher_alhalka && $teacher_alhalka['id'] !== $id) {
                    return FailedResponse('This Alhalka number is already in use');
                }
            } 
            if ($password) {
                $query = "UPDATE teachers SET name=?, phone=?, email=?, password=?, Alhalka_Number=? WHERE id=?";
            } else {
                $query = "UPDATE teachers SET name=?, Phone=?, email=?, Alhalka_Number=? WHERE id=?";
            }
        
            $stm_update = mysqli_prepare($con, $query);
            if ($stm_update) {
                if ($password) {
                    mysqli_stmt_bind_param($stm_update, 'sssssi', $name, $phone, $email, $password, $alhalka_number, $id);
                } else {
                    mysqli_stmt_bind_param($stm_update, 'ssssi', $name, $phone, $email, $alhalka_number, $id);
                }
                mysqli_stmt_execute($stm_update);
                $result = mysqli_stmt_get_result($stm_update);
            } 
        }
    }
    return SuccessResponse("Done");
}
else{
    $errors[]=['security'=>'unsuppored method'];
    ValidationResponse("validation errors",$errors);
}
