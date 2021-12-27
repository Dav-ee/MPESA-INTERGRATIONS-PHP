<?php
  $callbackResponse = file_get_contents('php://input');
  $logFile = "B2CtimeoutResponse.json";
  $log = fopen($logFile, "a");
  fwrite($log, $callbackResponse);
  fclose($log);