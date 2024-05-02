<?php
function SuccessResponse($message = "Success Operation", $data = null)
{
    $response = array(
        "success" => true,
        "message" => $message,
        "data" => $data,
    );
    header('Content-Type: application/json');
    http_response_code(200);
    echo json_encode($response);
}

function FailedResponse($message = "Failed", $data = null)
{
    $response = array(
        "success" => false,
        "message" => $message,
        "data" => $data,
    );
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode($response);
}

function ValidationResponse($message = "Validation errors", $data = null)
{
    $response = array(
        "success" => false,
        "message" => $message,
        "data" => $data,
    );
    header('Content-Type: application/json');
    http_response_code(400);
    echo json_encode($response);
}
?>
