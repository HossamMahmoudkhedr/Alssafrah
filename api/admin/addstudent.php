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

    // Check if ssn is set and not empty
    if(!isset($_POST['ssn']) || empty($_POST['ssn']))
        $errors[]=['ssn'=>'رقم الهويه مطلوب'];

    // Check if parent_phone is set and not empty
    if(!isset($_POST['parent_phone']) || empty($_POST['parent_phone']))
        $errors[]=['parent_phone'=>'رقم ولي المر مطلوب'];

    // Check if alhalka_number is set and not empty
    if(!isset($_POST['alhalka_number']) || empty($_POST['alhalka_number']))
        $errors[]=['alhalka_number'=>'رقم الحلقه مطلوب'];

    // Check if session type is set and equals 'admin'
    if(!isset($_SESSION['type']) || $_SESSION['type']!='admin') {
        $errors[]=['security'=>'غير مسموح بل دخول هنا'];
    }

    // If there are validation errors, return validation response
    if(!empty($errors)) {
        return ValidationResponse("validation errors", $errors);
    }

    // Assigning variables from POST data
    $name=$_POST['name'];
    $ssn=$_POST['ssn'];
    $parent_phone=$_POST['parent_phone'];
    $admin_id=$_SESSION['id'];
    $admin_id = (int)$admin_id;
    $alhalka_number=$_POST['alhalka_number'];

    // Get the parent email from the database
    $query="SELECT ssn FROM students WHERE ssn = ?";
    $stm_ssn= mysqli_prepare($con,$query);

    // If statement is prepared successfully
    if($stm_ssn) {
        mysqli_stmt_bind_param($stm_ssn,'s',$ssn);
        mysqli_stmt_execute($stm_ssn);
        $result = mysqli_stmt_get_result($stm_ssn);
        $student = mysqli_fetch_assoc($result);

        // If student with the same ssn already exists, return failed response
        if($student) {
            return FailedResponse('رقم الهويه موجود بلفعل');
        }
    }

    // Get the teacher ID from the database based on alhalka_number
    $query="SELECT id , Alhalka_Number FROM teachers WHERE Alhalka_Number = ?";
    $stm_teacher= mysqli_prepare($con,$query);

    // If statement is prepared successfully
    if($stm_teacher) {
        mysqli_stmt_bind_param($stm_teacher,'i',$alhalka_number);
        mysqli_stmt_execute($stm_teacher);
        $result = mysqli_stmt_get_result($stm_teacher);
        $teacher = mysqli_fetch_assoc($result);

        // If teacher with provided alhalka_number doesn't exist, return failed response
        if(!$teacher) {
            return FailedResponse('لا يوجد حلقه بهذا الرقم');
        }

        // Assign teacher ID
        $teacher_id=$teacher['id'];
    }

    // Inserting student data into database
    $query = "INSERT INTO students (name,ssn,parent_phone,admin_id,teacher_id ) VALUES(?,?,?,?,?)";
    $stm = mysqli_prepare($con, $query);

    // If statement is prepared successfully
    if ($stm) {
        mysqli_stmt_bind_param($stm, 'sssii', $name, $ssn, $parent_phone, $admin_id,$teacher_id);
        $result = mysqli_stmt_execute($stm);

        // If insertion fails, return failed response
        if (!$result) {
            return FailedResponse('فشل اضافه الطالب ');
        }

        // Check if there's a parent with the same phone number
        $query_parent = "SELECT id , phone FROM parents WHERE phone = ?";
        $stm_parent = mysqli_prepare($con, $query_parent);

        // If statement is prepared successfully
        if ($stm_parent) {
            mysqli_stmt_bind_param($stm_parent, 's', $parent_phone);
            mysqli_stmt_execute($stm_parent);
            $result_parent = mysqli_stmt_get_result($stm_parent);
            $parent=mysqli_fetch_assoc($result_parent);

            // If parent exists, update student's parent_id
            if($parent) {
                $parent_id=$parent['id'];
                if($result_parent->num_rows==1) {
                    $query_insert_student = "UPDATE students SET parent_id = ? WHERE parent_phone = ?";
                    $stm_insert_student = mysqli_prepare($con, $query_insert_student);
                    if ($stm_insert_student) {
                        mysqli_stmt_bind_param($stm_insert_student, 'is',$parent_id , $parent_phone);//is i=>integer s =>string
                        mysqli_stmt_execute($stm_insert_student);
                    }
                }
            }
        }

        // Return success response
        return SuccessResponse("تمتت اضافه الطالب بنجاح");
    }
} else {
    // If request method is not POST, return security error
    $errors[]=['security'=>'طريقه غير صحيحه'];
    ValidationResponse("validation errors",$errors);
}
