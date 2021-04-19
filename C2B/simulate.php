<?php
date_default_timezone_set('Africa/Nairobi');
// access token here
$consumer_key='';
$consumer_secret='';
$headers=['Content-Type:application/json; charset-utf8'];
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


    $url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/simulate';    
  //  $access_token = 'dA55DzG6ICV924y6Of4y35DEmeAT'; // check file mpesa_accesstoken.php.    
    $ShortCode  = '603021'; // Shortcode. Same as the one on register_url.php
    $amount     = '7909'; // amount the client/we are paying to the paybill
    $msisdn     = '254708374149'; // phone number paying 
    $billRef    = 'TEST673'; // This is anything that helps identify the specific transaction. Can be a clients ID, Account Number,

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$access_token));


    $curl_post_data = array(
           'ShortCode' => $ShortCode,
           'CommandID' => 'CustomerPayBillOnline',
           'Amount' => $amount,
           'Msisdn' => $msisdn,
           'BillRefNumber' => $billRef
    );

    $data_string = json_encode($curl_post_data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
    $curl_response = curl_exec($curl);
    print_r($curl_response);

    echo $curl_response;
?>