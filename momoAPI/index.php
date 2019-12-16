<?php

include_once 'includes/MomoAPI.php';

include_once 'includes/RequestPayBody.php';

//first create an instant of MomoAPI
$momoTest = new MomoAPI('eeabff77f35c4ad8b7037a0d4cab14f2');

//create user and get unique uuid version 4 if successful
$uuid = $momoTest->createAPIUser(null, 'https://ggg.com');

echo ($uuid) ? "<br/>api user = $uuid <br/>" : "<br/>failed to create user<br/>";

// get api_key for the user
$apiKey = $momoTest->get_api_key($uuid);
echo "api key = $apiKey <br/>";

//get access token for the user using his/her uuid and api_key
$token = $momoTest->get_access_token($uuid, $apiKey);

echo "access_token = $token->access_token <br/>";

/*
46733123450	failed
46733123451	rejected
46733123452	timeout
46733123453	ongoing (will answer pending first and if requested again after 30 seconds it will respond success)
46733123454	pending
*/

$requestBody =
    new RequestPayBody("MSISDN", '46733123453', 40, 'EUR', "jkjkjhkbh",
        "some msg", "dsmndsm");

$payStatus = $momoTest->requestPay($token->access_token, $requestBody, 'https://ggg.com', $uuid);
if ($payStatus) {
    $payment = $momoTest->checkPaymentStatus($token->access_token, $uuid);
}

echo "<br/> pay_status=";
print_r($payment);


$bal = $momoTest->checkBalance($token->access_token);
echo "<br/> bal= ";
print_r($bal);

$isActive = $momoTest->isUserAccountActive($token->access_token, 'MSISDN', '0541355996');

echo ($isActive) ? "<br/>is Active" : "<br/>not Active";


