 <?php
  /* Urls */
  $access_token_url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
  $b2c_url = 'https://api.safaricom.co.ke/mpesa/b2c/v1/paymentrequest';
  /* Required Variables */
  $consumerKey = '##';        # Fill with your app Consumer Key
  $consumerSecret = '##';     # Fill with your app Secret
  $headers = ['Content-Type:application/json; charset=utf8']; 

  /* from the test credentials provided on you developers account */
  $InitiatorName = '##';      # Initiator
  $SecurityCredential = '##';
  # choose between SalaryPayment, BusinessPayment, PromotionPayment 
  $CommandID = 'PromotionPayment';
  $Amount = $amount;
  $PartyA = '##';             # shortcode 1
  $PartyB = $phone;             # Phone number you're sending money to
  $Remarks = 'Tryna test';      # Remarks ** can not be empty
  $QueueTimeOutURL = 'https://validdomainpath/b2c_timeout_url.php';    # your QueueTimeOutURL
  $ResultURL = 'https://validdomainpath/b2c_callback_url.php';          # your ResultURL
  $Occasion = 'Christmas Yeap';           # Occasion

  /* Obtain Access Token */
  $curl = curl_init($access_token_url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($curl, CURLOPT_HEADER, FALSE);
  curl_setopt($curl, CURLOPT_USERPWD, $consumerKey.':'.$consumerSecret);
  $response = curl_exec($curl);
  $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
  $response = json_decode($response);
  $access_token = $response->access_token;
  curl_close($curl);

  /* Main B2C Request to the API */
  $b2cHeader = ['Content-Type:application/json','Authorization:Bearer '.$access_token];
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $b2c_url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, $b2cHeader); //setting custom header

  $curl_post_data = array(
    //Fill in the request parameters with valid values
    'InitiatorName' => $InitiatorName,
    'SecurityCredential' => $SecurityCredential,
    'CommandID' => $CommandID,
    'Amount' => $Amount,
    'PartyA' => $PartyA,
    'PartyB' => $PartyB,
    'Remarks' => $Remarks,
    'QueueTimeOutURL' => $QueueTimeOutURL,
    'ResultURL' => $ResultURL,
    'Occasion' => $Occasion
  );

  $data_string = json_encode($curl_post_data);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
  $curl_response = curl_exec($curl);
  echo $curl_response;
  
// $json = json_decode($curl_response);
// echo $ConversationID = $json->ConversationID;
// echo $OriginatorConversationID = $json->OriginatorConversationID;
// echo $ResponseCode = $json->ResponseCode;
// echo $ResponseDescription = $json->ResponseDescription;

$json = json_decode($curl_response, true);
if( $json['ResponseCode'] == "0"){
 $ConversationID =  $json['ConversationID'];
 $OriginatorConversationID =  $json['OriginatorConversationID'];
 $ResponseCode =  $json['ResponseCode'];
 $ResponseDescription =  $json['ResponseDescription'];

$date =  date('d-m-Y H:i:s') ;
$trx_amount;
$phone;
$amount;
$invoice;
$receiver_name;
$query = "INSERT INTO `b2c`(`username`, `conversation_id`,`request_code`,`trx_amount`, `phone`, `amount`, `invoice` , `receiver_name` , `date`, `type`) 
VALUES ('$username','$ConversationID','$OriginatorConversationID','$trx_amount','$phone','$amount','$invoice','$receiver_name','$date','INVESTMENT')";
mysqli_query($conn,$query);
}
else{
echo " Withdrawal not available at the moment ";
}
?>