<?php
function SuccessResponse( $message="Success Opration", $data = null) {
    $response = array(
        "success" => true,
        "message" => $message,
        "data" => $data
    );
    header('Content-Type: application/json');
    echo json_encode($response);
}  
function FailedResponse( $message="Failed", $data = null) {
    $response = array(
        "success" => false,
        "message" => $message,
        "data" => $data
    );
    header('Content-Type: application/json');
    echo json_encode($response);
}  
function ValidationResponse( $message="Validation errors ", $data = null) {
    $response = array(
        "success" => false,
        "message" => $message,
        "data" => $data
    );
    header('Content-Type: application/json');
    echo json_encode($response);
}  
?>