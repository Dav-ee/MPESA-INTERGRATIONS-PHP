 <?php
require __DIR__ . '/vendor/autoload.php';
use Carbon\Carbon;

stkPush($userAmt,$phone);

function lipaNaMpesaPassword()
{
    //timestamp
    $timestamp = Carbon::rawParse('now')->format('YmdHms');
    //passkey
    $passKey ="##";
    $businessShortCOde = ##;
    //generate password
    $mpesaPassword = base64_encode($businessShortCOde.$passKey.$timestamp);
    return $mpesaPassword;
}
function getAccessToken(){
  $consumerKey = '##';
  $consumerSecret = '##';
  $url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
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
       $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
       $curl_post_data = [
            'BusinessShortCode' => ##,
            'Password' => lipaNaMpesaPassword(),
            'Timestamp' => Carbon::rawParse('now')->format('YmdHms'),
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $userAmt,
            'PartyA' => $phone,
            'PartyB' => ##,
            'PhoneNumber' => $phone,
            'CallBackURL' => 'https://validdomainpath/depositCallback.php',
            'AccountReference' => "DEPOSIT",
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
      
   // echo '  <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show" role="alert">
   //                                          <i class="mdi mdi-check-all label-icon"></i><strong>Success!</strong> STK initiated successfully.
   //                                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   //                                      </div>'; 
   }

?>
