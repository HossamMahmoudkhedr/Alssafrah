<?php
include "includes/connection.php";
include "includes/apiResponse.php";
$type="";
if(isset($_COOKIE['logincookie']))
    $type=$_COOKIE['logincookie'];
setcookie('logincookie','',time()- 3600,'/');
$con->close();
session_start();
session_destroy();
return SuccessResponse("Done",$type);
