<?php
date_default_timezone_set('Africa/Nairobi');
$php_date=  date('d/m/Y/H:i:s');

    $username = $result['username'];
    $responce = file_get_contents('php://input');
    $decodedResponce = json_decode($responce);
    
    $amount;
    $mpesaCode ;
    $balance;
    $transactionDate;
    $phone;
                    
//     $var = '
//     {
//   "Body": {
//     "stkCallback": {
//       "MerchantRequestID": "9234-58037451-1",
//       "CheckoutRequestID": "ws_CO_110820211501493318",
//       "ResultCode": 0,
//       "ResultDesc": "The service request is processed successfully.",
//       "CallbackMetadata": {
//         "Item": [
//           {
//             "Name": "Amount",
//             "Value": 1.00
//           },
//           {
//             "Name": "MpesaReceiptNumber",
//             "Value": "PHB5HAX915"
//           },
//           {
//             "Name": "Balance"
//           },
//           {
//             "Name": "TransactionDate",
//             "Value": 20210811150205
//           },
//           {
//             "Name": "PhoneNumber",
//             "Value": 254706373252
//           }
//         ]
//       }
//     }
//   }
// }';      
                
$datass= $decodedResponce;
//$datass = json_decode($var);
foreach($datass as $datas){
    foreach($datas as $data){
        $MerchantRequestID=$data->MerchantRequestID;
        $ResultCode=$data->ResultCode;
        $ResultDesc=$data->ResultDesc;
        $logfile = "depositTestv3.txt";
        $log = fopen($logfile,"a");
        fwrite($log,json_encode($data));
        fclose($log);
        if($ResultDesc == "The service request is processed successfully."){
          $CallbackMetadata=$data->CallbackMetadata; 
            foreach($CallbackMetadata as $callBack){
                $amount = $callBack[0]->Value;
                $mpesaCode = $callBack[1]->Value;
                $balance= $callBack[2]->Value;
                $transactionDate = $callBack[3]->Value;
                $phone= $callBack[4]->Value;
                $activationInsert= "INSERT INTO `deposits`(`transId`, `date`, `phone`,`amout`,`status`) VALUES ('$mpesaCode','$php_date','$phone','$amount',0)";
                $resultQuery = mysqli_query($conn,$activationInsert); 
    }
}
}
}
?>