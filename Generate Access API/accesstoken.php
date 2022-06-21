<?php
// For timezone purposes
date_default_timezone_set('Africa/Nairobi');
// input your unique consumer key and secret provide on your APP
$consumer_key=' ';
$consumer_secret=' ';

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

echo $access_token;
?>