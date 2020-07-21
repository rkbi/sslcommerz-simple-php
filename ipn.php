<?php
include_once 'config.php';

error_reporting(0);
ini_set('display_errors', 0);
header('X-Developed-By: SSLWireless');
header('Content-Type: application/json');

$status = $_POST['status'];

if ($status == 'VALID') {
    $validationUrl = API_URL . "/validator/api/validationserverAPI.php";
    $data          = [
        'val_id'       => $_POST['val_id'],
        'store_id'     => STORE_ID,
        'store_passwd' => STORE_PASSWD,
        'format'       => json,
    ];
    $queryString = http_build_query($data);

    $return    = file_get_contents($validationUrl . "?" . $queryString);
    $content   = json_decode($return);
    $valStatus = $content->status;

    if (in_array($valStatus, ['VALID', 'VALIDATED'])) {

        echo json_encode(["error" => "0000", "msg" => "Validation successful from IPN"]);

    } else {

        echo json_encode(["error" => "1001", "msg" => "Validation failed from IPN"]);

    }
} else {

    echo json_encode(["error" => "1002", "msg" => "Transaction is " . $status]);

}
