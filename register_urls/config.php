<?php
/* TESTED ON PHP Version 7.2.8. Refer to the version of your php if some/parts/whole has errors */
/**
* This function serves the purpose of saving the data into our database.
* It has the connection it, so by just doing it right, you will be up and running without any struggles
* @param array. The M-PESA response array is passed into the function which we use PDO to insert it to our db.
*
**/
function insert_response($jsonMpesaResponse){
	# 1.1. Config Section
		$dbName = '##';
		$dbHost = '127.0.0.1';
		$dbUser = '##';
		$dbPass = '##';
	# 1.1.1 establish a connection
	try{
		$con = new PDO("mysql:dbhost=$dbHost;dbname=$dbName", $dbUser, $dbPass);
		echo "Connection was successful";
	}
	catch(PDOException $e){
		die("Error Connecting ".$e->getMessage());
	}
	# 1.1.2 Insert Response to Database
	try{
		$insert = $con->prepare("INSERT INTO `deposit`(`TransactionType`, `TransID`, `TransTime`, `TransAmount`, `BusinessShortCode`, `BillRefNumber`, `InvoiceNumber`, `OrgAccountBalance`, `ThirdPartyTransID`, `MSISDN`, `FirstName`, `MiddleName`, `LastName`) VALUES (:TransactionType, :TransID, :TransTime, :TransAmount, :BusinessShortCode, :BillRefNumber, :InvoiceNumber, :OrgAccountBalance, :ThirdPartyTransID, :MSISDN, :FirstName, :MiddleName, :LastName)");
		$insert->execute((array)($jsonMpesaResponse));
		# 1.1.2o Optional - Log the transaction to a .txt or .log file(May Expose your transactions if anyone gets the links, be careful with this. If you don't need it, comment it out or secure it)
		$Transaction = fopen('Deposit.text', 'a');
		fwrite($Transaction, json_encode($jsonMpesaResponse));
		fclose($Transaction);
	}
	catch(PDOException $e){
		# 1.1.2b Log the error to a file. Optionally, you can set it to send a text message or an email notification during production.
		$errLog = fopen('db_paybill_error.txt', 'a');
		fwrite($errLog, $e->getMessage());
		fclose($errLog);
		# 1.1.2o Optional. Log the failed transaction. Remember, it has only failed to save to your database but M-PESA Transaction itself was successful. 
		$logFailedTransaction = fopen('failedDeposit.txt', 'a');
		fwrite($logFailedTransaction, json_encode($jsonMpesaResponse));
		fclose($logFailedTransaction);
	}
}
?>