<?php
header("Content-type: application/json");
$response = '{
"ResultCode": 0,
"ResultDesc": "Confirmation Received Successfully"
}';

// DATA
$mpesaResponse = file_get_contents('php://input');
$logfile="validationResponse.txt";
$jsonMpesaResponse= json_decode($mpesaResponse);
$log =fopen($logfile, "a");
fwrite($log, $mpesaResponse);
fclose($log);

echo $response;
?>

