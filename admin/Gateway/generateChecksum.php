<?php
 
$orderid =$_POST['orderid'];
$email =$_POST['email'];
$mobile =$_POST['mobile'];
$amount =$_POST['amount'];
 
//require_once('db_Connect.php');
 
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");
// following files need to be included
require_once("./lib/config_paytm.php");
require_once("./lib/encdec_paytm.php");
//$checkSum = "qwertyasdfg12345";
 
// below code snippet is mandatory, so that no one can use your checksumgeneration url for other purpose .
$paramList = array();
$paramList["MID"] = 'BISHTT25323905043969'; //Provided by Paytm
$paramList["ORDER_ID"] = $orderid; //unique OrderId for every request
$paramList["CUST_ID"] = 'CUST563214'; // unique customer identifier 
$paramList["INDUSTRY_TYPE_ID"] = 'Retail109'; //Provided by Paytm
$paramList["TXN_AMOUNT"] = $amount; // transaction amount
$paramList["CHANNEL_ID"] = 'WAP'; // transaction amount
$paramList["WEBSITE"] = 'APPPROD'; // transaction amount
$paramList["EMAIL"] = $email; // customer email id
$paramList["MOBILE_NO"] = $mobile; // customer 10 digit mobile no.
//$paramList["CALLBACK_URL"] = 'https://pguat.paytm.com/paytmchecksum/paytmCallback.jsp'; //Provided by Paytm
$paramList["CALLBACK_URL"] = 'http://neerajbisht.com/grocery_test/Gateway/verifyChecksum.php'; //Provided by Paytm
 
$checkSum = getChecksumFromArray($paramList,'R%yMhRjqYU%53&c2');
$paramList["CHECKSUMHASH"] = $checkSum;
 
echo json_encode($paramList);
//echo json_encode(array("category_sub_list"=>$paramList));
//print_r($paramList);
 
?>
