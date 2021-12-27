<?php
include_once 'b2c_config.php';

  $json = file_get_contents('php://input');
  $logFile = "B2CResultResponse.json";
  $log = fopen($logFile, "a");
  fwrite($log, $json);
  fclose($log);
  $json = json_decode($json);
 
    $ResultCode = $json->Result->ResultCode;
     $ConversationID = $json->Result->ConversationID;
  echo  $ResultDesc = $json->Result->ResultDesc;
     $trx_id = $json->Result->TransactionID;
  $amount = isset($json->Result->ResultParameters->ResultParameter[0]->Value) ? explode(' - ', $json->Result->ResultParameters->ResultParameter[0]->Value)[0] : null;
  $phone = isset($json->Result->ResultParameters->ResultParameter[2]->Value) ? explode(' - ', $json->Result->ResultParameters->ResultParameter[2]->Value)[0] : null;
 $name = isset($json->Result->ResultParameters->ResultParameter[2]->Value) ? explode(' - ', $json->Result->ResultParameters->ResultParameter[2]->Value)[1] : null;
 
 if($ResultDesc == 'The service request is processed successfully.'){
 $updateInvestments = "UPDATE `b2c` SET  `trx_id` = '$trx_id'   ,  `description` = '$ResultDesc' ,  `phone` = '$phone' ,  `amount` = '$amount'  ,  `receiver_name` = '$name' ,  `status` = 1  WHERE `conversation_id` = '$ConversationID'";
mysqli_query($conn,$updateInvestments);   
 }
 else{
 $updateInvestments = "UPDATE `b2c` SET  `trx_id` = '$trx_id'   ,  `description` = '$ResultDesc' ,  `receiver_name` = '$name' ,  `status` = 0  WHERE `conversation_id` = '$ConversationID'";
mysqli_query($conn,$updateInvestments);   
 }
 
 ?>



