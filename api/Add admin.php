<?php

include "includes/connection.php";
$name="Admin";
$password="Admin";
$email="Admin@Alssafarah.com";
$password=password_hash($password,PASSWORD_BCRYPT);
$query="insert into admins (name,password,email) values (?,?,?)";
$stmt = mysqli_prepare($con, $query);
if($stmt)
{
    mysqli_stmt_bind_param($stmt, "sss", $name, $password, $email);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        $response = array(
            "success" => true,
            "message" => "Admin user inserted successfully."
        );
    } else {
        $response = array(
            "success" => false,
            "message" => "Error inserting admin user: " . mysqli_error($con)
        );
    }

    mysqli_stmt_close($stmt);
} else {
    $response = array(
        "success" => false,
        "message" => "Error preparing statement: " . mysqli_error($con)
    );
}

mysqli_close($con);

// Output JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>