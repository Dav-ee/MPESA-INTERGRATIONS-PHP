<?php
// set timezone to Nairobi or check your server config
date_default_timezone_set('Africa/Nairobi');
// generating access token input values below
$consumer_key=' ';
$consumer_secret=' ';
  # header for access token
$headers = ['Content-Type:application/json; charset=utf8'];
$url_access_token = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

 $curl = curl_init( $url_access_token);
 curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
 curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($curl, CURLOPT_HEADER, false);
 curl_setopt($curl, CURLOPT_USERPWD, $consumer_key.':'.$consumer_secret);
 $result=curl_exec($curl);
 $status=curl_getinfo($curl, CURLINFO_HTTP_CODE);
 $result=json_decode($result);
 $access_token= $result->access_token;
 curl_close($curl);

  # M-PESA endpoint urls
 $initiate_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';  

// _POST data from our form.
$name=$_POST['uname'];
$mobile=$_POST['mobile'];
$amount=$_POST['amount'];
$BusinessShortCode=174379;
$Timestamp= date('YmdHis');
$AccountReference='MONI LTD';
$TransactionDesc='Bitcoins Payment';
// passkey indicated on your app
$passkey=' ';
$Password=base64_encode($BusinessShortCode.$passkey.$Timestamp);
 # callback url
 $CallBackURL='https://davee.ml/AA/callback_url.php';

  # header for stk push
  $stkheader = ['Content-Type:application/json','Authorization:Bearer '.$access_token];

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $initiate_url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $stkheader); //setting custom header  

    $curl_post_data = array(
    //Fill in the request parameters with valid values
    'BusinessShortCode' => $BusinessShortCode,
    'Password' => $Password,
    'Timestamp' => $Timestamp,
    'TransactionType' => 'CustomerPayBillOnline',
    'Amount' => $amount,
    'PartyA' => $mobile,
    'PartyB' => $BusinessShortCode,
    'PhoneNumber' => $mobile,
    'CallBackURL' => $CallBackURL,
    'AccountReference' => $AccountReference,
    'TransactionDesc' => $TransactionDesc
    );

    $data_string = json_encode($curl_post_data);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

    $curl_response = curl_exec($curl);
    print_r($curl_response);


    echo $curl_response;
   ?>
  