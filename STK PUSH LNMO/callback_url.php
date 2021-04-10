<?php
  $stkCallbackResponse = file_get_contents('php://input');
  $logFile = "CallbackResponse.txt";
  $log = fopen($logFile, "a");
  fwrite($log, $stkCallbackResponse);
  fclose($log);


  ?>