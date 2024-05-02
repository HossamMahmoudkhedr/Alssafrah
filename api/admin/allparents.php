<?php
include "../includes/connection.php";
include "../includes/apiResponse.php";
session_start();
if($_SERVER['REQUEST_METHOD'] === 'GET')
{
   $errors=[];
   if(!isset($_SESSION['type'])||$_SESSION['type']!='admin')
    {
        $errors[]=['security'=>'unauthorized'];
    }
    if(!empty($errors))
    {
        return ValidationResponse("validation errors",$errors);
    }
    $admin_id=$_SESSION['id'];
    $admin_id = (int)$admin_id;
    $query="SELECT * FROM parents where admin_id=?";
    
    $stm_parents= mysqli_prepare($con,$query);
    $data=[];
    if($stm_parents)
    {
        mysqli_stmt_bind_param($stm_parents,'i',$admin_id);
        mysqli_stmt_execute($stm_parents);
        $result = mysqli_stmt_get_result($stm_parents);
        //$parents = mysqli_fetch_assoc($result);
        
        while ($parent = mysqli_fetch_assoc($result)) {
            unset($parent['password']);
            $data[] = $parent;
        }
    }
    return SuccessResponse("all parents",$data);     
}
else{
    $errors[]=['security'=>'unsuppored method'];
    ValidationResponse("validation errors",$errors);
}