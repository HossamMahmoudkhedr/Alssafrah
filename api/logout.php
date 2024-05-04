<?php
include "includes/connection.php";
include "includes/apiResponse.php";
$type="";
if(isset($_COOKIE['logincookie']))
    $type=$_COOKIE['logincookie'];
$con->close();
session_start();
session_destroy();
return SuccessResponse("Done",$type);
