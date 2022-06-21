<?php
require __DIR__ . '/vendor/autoload.php';
use Carbon\Carbon;

$userAmt = 5;
// follow format
$phone = "254...";

// call stk function
stkPush($userAmt,$phone);

function lipaNaMpesaPassword()
{
    //timestamp
    $timestamp = Carbon::rawParse('now')->format('YmdHms');
    //input your passkey
    $passKey =" ";
    $businessShortCOde = ;
    //generate password
    $mpesaPassword = base64_encode($businessShortCOde.$passKey.$timestamp);
    return $mpesaPassword;
}
function getAccessToken(){
    // enter your secret keys here
  $consumerKey = '';
  $consumerSecret = '';
  $url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';  // for production 
  $curl = curl_init();
  $credentials = base64_encode($consumerKey.":".$consumerSecret);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic '.$credentials));
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_HEADER,false);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  $response = curl_exec($curl);
  $accessToken = json_decode($response)->access_token;
  return $accessToken;
}
 function stkPush($userAmt,$phone)
   {
       $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest'; // for production
       $curl_post_data = [
            'BusinessShortCode' => , // head office / store number
            'Password' => lipaNaMpesaPassword(),
            'Timestamp' => Carbon::rawParse('now')->format('YmdHms'),
            'TransactionType' => 'CustomerBuyGoodsOnline', // note this don't alter
            'Amount' => $userAmt,
            'PartyA' => $phone,
            'PartyB' => , // till number
            'PhoneNumber' => $phone,
            'CallBackURL' => './callback_url.php?phone='.$phone , // link to callback url
            'AccountReference' => "DEPOSIT", // use 1 word preferably
            'TransactionDesc' => "stk"
        ];
       $data_string = json_encode($curl_post_data);
       $curl = curl_init();
       curl_setopt($curl, CURLOPT_URL, $url);
       curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.getAccessToken()));
       curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($curl, CURLOPT_POST, true);
       curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
       $curl_response = curl_exec($curl);
      echo $curl_response;
   }

?>