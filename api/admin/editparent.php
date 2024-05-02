<?php
include "../includes/connection.php";
include "../includes/apiResponse.php";
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    if (!isset($_POST['name']) || empty($_POST['name']))
        $errors[] = ['name' => 'required'];
    if (!isset($_POST['id']) || empty($_POST['id']))
        $errors[] = ['id' => 'required'];
    if (!isset($_POST['email']) || empty($_POST['email']))
        $errors[] = ['email' => 'required'];
    else {
        $email = $_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = ['email' => 'Invalid email format'];
        }
    }
    if (!isset($_POST['phone']) || empty($_POST['phone']))
        $errors[] = ['phone' => 'required'];
    $password = null;
    if (isset($_POST['newpassword']) && !empty($_POST['newpassword'])) {
        $password = password_hash($_POST['newpassword'], PASSWORD_BCRYPT);
    }

    if (!isset($_SESSION['type']) || $_SESSION['type'] !== 'admin') {
        $errors[] = ['security' => 'unauthorized'];
    }
    if (!empty($errors)) {
        return ValidationResponse("validation errors", $errors);
    }
    $name = $_POST['name'];

    $id = $_POST['id'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $query = "SELECT * FROM parents WHERE id=?";
    $stm_parent = mysqli_prepare($con, $query);
    if ($stm_parent) {
        mysqli_stmt_bind_param($stm_parent, 'i', $id);
        mysqli_stmt_execute($stm_parent);
        $result = mysqli_stmt_get_result($stm_parent);
        $parent = mysqli_fetch_assoc($result);
        if ($parent) {
            if ($parent['email'] !== $email) {
                $query = "SELECT id, email FROM parents WHERE email = ?";
                $stm_email = mysqli_prepare($con, $query);
                if ($stm_email) {
                    mysqli_stmt_bind_param($stm_email, 's', $email);
                    mysqli_stmt_execute($stm_email);
                    $result = mysqli_stmt_get_result($stm_email);
                    $parent_email = mysqli_fetch_assoc($result);
                    if ($parent_email !== null && $parent_email['id'] !== $id) {
                        return FailedResponse('This user email is already in use');
                    }
                }
            }
            if ($parent['phone'] !== $phone) {
                $query = "SELECT id, phone FROM parents WHERE phone = ?";
                $stm_phone = mysqli_prepare($con, $query);
                if ($stm_phone) {
                    mysqli_stmt_bind_param($stm_phone, 's', $phone);
                    mysqli_stmt_execute($stm_phone);
                    $result = mysqli_stmt_get_result($stm_phone);
                    $parent_phone = mysqli_fetch_assoc($result);
                    if ($parent_phone !== null && $parent_phone['id'] !== $id) {
                        return FailedResponse('This user phone is already in use');
                    }
                }
            }
            if (isset($password)) {
                $query = "UPDATE parents SET name = ?, phone = ?, email = ?, password = ? WHERE id = ? ";
                $stm_update = mysqli_prepare($con, $query);
                if ($stm_update) {
                    mysqli_stmt_bind_param($stm_update, 'ssssi', $name, $phone, $email, $password, $id);
                }
            } else {
                $query = "UPDATE parents SET name = ?, phone = ?, email = ? WHERE id = ? ";
                $stm_update = mysqli_prepare($con, $query);
                if ($stm_update) {
                    mysqli_stmt_bind_param($stm_update, 'sssi', $name, $phone, $email, $id);
                }
            }
            mysqli_stmt_execute($stm_update);
            $result = mysqli_stmt_get_result($stm_update);
            $query = "UPDATE students SET parent_phone = ? WHERE parent_id = ?";
            $stm_student = mysqli_prepare($con, $query);
            if ($stm_student) {
                mysqli_stmt_bind_param($stm_student, 'si', $phone, $id);
            }
            mysqli_stmt_execute($stm_student);
            $result = mysqli_stmt_get_result($stm_student);
        } else {
            return FailedResponse('User not found');
        }
    }
    return SuccessResponse("Done");
}
else{
    $errors[]=['security'=>'unsuppored method'];
    ValidationResponse("validation errors",$errors);
}
