<?php
include "../includes/connection.php";
include "../includes/apiResponse.php";
session_start();
if($_SERVER['REQUEST_METHOD'] === 'GET')
{
   $errors=[];
   if(!isset($_GET['id'])||empty('id'))
        $errors[] = ['id' => 'required'];
   if(!isset($_SESSION['type'])||$_SESSION['type']!='admin')
    {
        $errors[]=['security'=>'unauthorized'];
    }
    if(!empty($errors))
    {
        return ValidationResponse("validation errors",$errors);
    }
    $id=$_GET['id'];
    $query="SELECT * FROM parents WHERE id = ?";
    $stm_parent= mysqli_prepare($con,$query);
    $data=[];
    if($stm_parent)
    {
        mysqli_stmt_bind_param($stm_parent,'i',$id);
        mysqli_stmt_execute($stm_parent);
        $result = mysqli_stmt_get_result($stm_parent);
        $parent=mysqli_fetch_assoc($result);
        if(!$parent)
        {
            return FailedResponse("User not found");
        }
        unset($parent['password']);
       
    }
    return SuccessResponse("parent",$parent);      
}
