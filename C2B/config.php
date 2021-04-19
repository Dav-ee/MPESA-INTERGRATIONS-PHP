<?php
function insert_response($jsonMpesaResponse){
		$dbName = 'easyswif_payments_daraja';
		$dbHost = '127.0.0.1';
		$dbUser = 'easyswif_payments';
		$dbPass = 'zlAZk&qpx{HB';
	try{
		$con = new PDO("mysql:dbhost=$dbHost;dbname=$dbName", $dbUser, $dbPass);
		echo "Connection was successful";
	}
	catch(PDOException $e){
		die("Error Connecting ".$e->getMessage());
	}
	try{
		$insert = $con->prepare("INSERT INTO `mobile_payments`(`TransactionType`, `TransID`, `TransTime`, `TransAmount`, `BusinessShortCode`, `BillRefNumber`, `InvoiceNumber`, `OrgAccountBalance`, `ThirdPartyTransID`, `MSISDN`, `FirstName`, `MiddleName`, `LastName`) VALUES (:TransactionType, :TransID, :TransTime, :TransAmount, :BusinessShortCode, :BillRefNumber, :InvoiceNumber, :OrgAccountBalance, :ThirdPartyTransID, :MSISDN, :FirstName, :MiddleName, :LastName)");
		$insert->execute((array)($jsonMpesaResponse));

		$Transaction = fopen('Transaction.txt', 'a');
		fwrite($Transaction, json_encode($jsonMpesaResponse));
		fclose($Transaction);
	}
	catch(PDOException $e){

		# 1.1.2b Log the error to a file. Optionally, you can set it to send a text message or an email notification during production.
		$errLog = fopen('error.txt', 'a');
		fwrite($errLog, $e->getMessage());
		fclose($errLog);

		# 1.1.2o Optional. Log the failed transaction. Remember, it has only failed to save to your database but M-PESA Transaction itself was successful. 
		$logFailedTransaction = fopen('failedTransaction.txt', 'a');
		fwrite($logFailedTransaction, json_encode($jsonMpesaResponse));
		fclose($logFailedTransaction);
	}
}
?>