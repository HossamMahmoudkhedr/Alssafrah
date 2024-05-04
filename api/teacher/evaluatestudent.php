<?php
include "../includes/connection.php";
include "../includes/apiResponse.php";
session_start();
if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $errors=[];
    if(!isset($_POST['id'])||empty($_POST['id']))
        $errors[]=['id'=>'required'];
    if(!isset($_SESSION['type'])||$_SESSION['type']!='teacher')
    {
        $errors[]=['security'=>'unauthorized'];
    }
    if(!empty($errors))
    {
        return ValidationResponse("validation errors",$errors);
    }
   
    $id=$_POST['id'];
    // get the parent email

    // , , , , , , , , behavior
   
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
            $new_sura_start_name=(isset($_POST['new_sura_start_name']))?$_POST['new_sura_start_name']:$student['new_sura_start_name'];
            $new_sura_start_number=(isset($_POST['new_sura_start_number']))?$_POST['new_sura_start_number']:$student['new_sura_start_number'];
            $new_sura_end_name=(isset($_POST['new_sura_end_name']))?$_POST['new_sura_end_name']:$student['new_sura_end_name'];
            $new_sura_end_number=(isset($_POST['new_sura_end_number']))?$_POST['new_sura_end_number']:$student['new_sura_end_number'];
            $revision_sura_start_name=(isset($_POST['revision_sura_start_name']))?$_POST['revision_sura_start_name']:$student['revision_sura_start_name'];
            $revision_sura_start_number=(isset($_POST['revision_sura_start_number']))?$_POST['revision_sura_start_number']:$student['revision_sura_start_number'];
            $revision_sura_end_name=(isset($_POST['revision_sura_end_name']))?$_POST['revision_sura_end_name']:$student['revision_sura_end_name'];
            $revision_sura_end_number=(isset($_POST['revision_sura_end_number']))?$_POST['revision_sura_end_number']:$student['revision_sura_end_number'];
            $behavior=(isset($_POST['behavior']))?$_POST['behavior']:$student['behavior'];
            //$string = implode(', ', $behavior);
            if($new_sura_start_name!=null && $new_sura_end_name===$new_sura_start_name)
            {
                if($new_sura_start_number>$new_sura_end_number)
                {
                    $errors[]=['logic error'=>'sura start number must be less than sura end number'];
                }
            }
            if($revision_sura_start_name!=null && $revision_sura_end_name===$revision_sura_start_name)
            {
                if($revision_sura_start_number>$revision_sura_end_number)
                {
                    $errors[]=['logic error'=>'sura start number must be less than sura end number'];
                }
            }
            if(!empty($errors))
            {
                return ValidationResponse("validation errors",$errors);
            }
            $query="UPDATE students set new_sura_start_name=?, new_sura_start_number=?, new_sura_end_name=?, new_sura_end_number=?
            ,revision_sura_start_name=?,revision_sura_start_number=?,revision_sura_end_name=?,revision_sura_end_number=?,behavior=? WHERE id=?";
            $stm_student = mysqli_prepare($con, $query);
            if ($stm_student) {
                mysqli_stmt_bind_param($stm_student, 'sssssssssi', $new_sura_start_name,$new_sura_start_number,$new_sura_end_name,$new_sura_end_number,$revision_sura_start_name,$revision_sura_start_number,$revision_sura_end_name,$revision_sura_end_number,$behavior,$id);
                mysqli_stmt_execute($stm_student);
                //$result = mysqli_stmt_get_result($stm_student);
            }
        }
        else
        {
            return FailedResponse('User not found');
        }
        return SuccessResponse("student successfully evaluated");
    }
}
else{
    $errors[]=['security'=>'unsuppored method'];
    ValidationResponse("validation errors",$errors);
}