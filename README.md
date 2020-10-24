# mtn-momo-developer-basics
MTN MoMo Developer Basics is a repository aimed at giving developers a head start in interacting with the MTN MoMo API's found here: https://momodeveloper.mtn.com/

*Disclaimer: This repository is not officially affiliated with MTN*

# General Guidelines
The aim is to accommodate any framework, implementation or programming language. This repo will be organised by having individual branches catering for different solutions. Developers are free to contribute to any branch relevant to their skill or interest.

At a bare minimum, you will be expected to register on the [MTN MoMo Developer Portal](https://momodeveloper.mtn.com/) and follow the [Getting Started Guidelines](https://github.com/Chizzoz/mtn-momo-developer-basics) to enable you to:

* Subscribe To MTN MoMo API Products
* Manage Your Subscriptions (`Primary Key` and `Secondary Key`)
* Generate *API User* and *API Key*

which will be necessary in interacting with the API using those credentials generated.

# Integrating Using PHP cURL
After following the [Getting Started Guidelines](https://github.com/Chizzoz/mtn-momo-developer-basics), you should be able to use the credentials generated in the code below.

## Collections API

* /requesttopay - POST

    `requesttopay.php` included in this repository has the code required to generate *Basic Authentication Token*, *Bearer Token* and POST a *requesttopay* Request, you just have to replace three (3) values in the code listed below:

    * `$api_user = 'enter_api_user_here';`
    * `$api_key = 'enter_api_key_here';`
    * `$subscription_key = "Enter_Subscription_Key_Here";`

    ```
        <?php
        // generate UUID
        function gen_uuid() {
            return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                // 32 bits for "time_low"
                mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

                // 16 bits for "time_mid"
                mt_rand( 0, 0xffff ),

                // 16 bits for "time_hi_and_version",
                // four most significant bits holds version number 4
                mt_rand( 0, 0x0fff ) | 0x4000,

                // 16 bits, 8 bits for "clk_seq_hi_res",
                // 8 bits for "clk_seq_low",
                // two most significant bits holds zero and one for variant DCE1.1
                mt_rand( 0, 0x3fff ) | 0x8000,

                // 48 bits for "node"
                mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
            );
        }

        // API User
        $api_user = 'enter_api_user_here';

        // API Key
        $api_key = 'enter_api_key_here';

        //API User and Key
        $api_user_and_key  = $api_user . ':' . $api_key;

        // Basic Authorization
        $basic_auth = "Basic " . base64_encode($api_user_and_key);

        // JSON curl POST
        function doJSONCurl($host,$url,$basicAuth,$subscriptionKey,$postJSON = null){
            $headers = array(
                "Host: " . $host,
                "Content-type: application/json",
                "Authorization: " . $basicAuth,
                "Ocp-Apim-Subscription-Key: " . $subscriptionKey,
            ); 
            $CURL = curl_init();

            curl_setopt($CURL, CURLOPT_URL, $url); 
            curl_setopt($CURL, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); 
            curl_setopt($CURL, CURLOPT_POST, 1); 
            curl_setopt($CURL, CURLOPT_POSTFIELDS, $postJSON); 
            curl_setopt($CURL, CURLOPT_HEADER, false); 
            curl_setopt($CURL, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($CURL, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($CURL, CURLOPT_RETURNTRANSFER, true);
            $jsonResponse = curl_exec($CURL);
            curl_close($CURL);

            return $jsonResponse;
        }
        // Create API User data
        $host_server = "sandbox.momodeveloper.mtn.com";
        $request_url = "https://sandbox.momodeveloper.mtn.com/collection/token/";
        $subscription_key = "Enter_Subscription_Key_Here";

        // Submit for token creation
        try {
            $full_response = doJSONCurl($host_server, $request_url, $basic_auth, $subscription_key);
            $decoded_full_response = json_decode($full_response);
            if(!empty($decoded_full_response->message)) {
                if($decoded_full_response->message && $decoded_full_response->code) {
                    return 'Error Message: ' . $decoded_full_response->message . ' | Error Code: ' . $decoded_full_response->code;
                }
            }
        } catch(\Exception $e) {
            return 'Token failed to create. ' . $e;
        }

        // Bearer Token
        $bearer_token = 'Bearer ' . $decoded_full_response->access_token;

        // JSON curl Payment POST
        function doJSONCurlPay($host,$url,$bearerToken,$referenceId,$targetEnvironment,$subscriptionKey,$postJSON = null){
            $headers = array(
                "Host: " . $host,
                "Content-type: application/json",
                "Authorization: " . $bearerToken,
                "X-Reference-Id: " . $referenceId,
                "X-Target-Environment: " . $targetEnvironment,
                "Ocp-Apim-Subscription-Key: " . $subscriptionKey,
            ); 
            $CURL = curl_init();

            curl_setopt($CURL, CURLOPT_URL, $url); 
            curl_setopt($CURL, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); 
            curl_setopt($CURL, CURLOPT_POST, 1); 
            curl_setopt($CURL, CURLOPT_POSTFIELDS, $postJSON); 
            curl_setopt($CURL, CURLOPT_HEADER, false); 
            curl_setopt($CURL, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($CURL, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($CURL, CURLOPT_RETURNTRANSFER, true);
            $jsonResponse = curl_exec($CURL);
            $httpcode = curl_getinfo($CURL, CURLINFO_HTTP_CODE);
            curl_close($CURL);

            if($httpcode == 202) {
                return json_encode(array("code" => "202", "message" => "Accepted"));
            } elseif($httpcode == 400) {
                return json_encode(array("code" => "400", "message" => "Bad Request"));
            } elseif($httpcode == 409) {
                return json_encode(array("code" => "409", "message" => "Conflict"));
            } elseif($httpcode == 500) {
                return json_encode(array("code" => "500", "message" => "Internal Server Error"));
            } else {
                return $jsonResponse;
            }
        }
        // Request To Pay
        $amount = 500;
        $currency = "EUR";
        $number = "46733123453";
        $host_server = "sandbox.momodeveloper.mtn.com";
        $request_url = "https://sandbox.momodeveloper.mtn.com/collection/v1_0/requesttopay";
        $reference_id = gen_uuid();
        $target_environment = "sandbox";
        // $callback_url = $callback_url;
        $timestamp = date('Ymd_Gis');

        $REQUEST_BODY= <<<json
        {
            "amount": "{$amount}",
            "currency": "{$currency}",
            "externalId": "{$timestamp}",
            "payer": {
                "partyIdType": "MSISDN",
                "partyId": "{$number}"
            },
            "payerMessage": "Payment of K{$amount}",
            "payeeNote": "Payment of K{$amount} from {$number}"
        }
        json;

        // Submit payment json message
        try {
            $full_response = doJSONCurlPay($host_server, $request_url, $bearer_token, $reference_id, $target_environment, $subscription_key, $REQUEST_BODY);
            $decoded_full_response = json_decode($full_response);
            if($decoded_full_response->code == "202") {
                $app_data = array("amount"=>"{$amount}","reference"=>"{$reference_id}","narration"=>"Payment of K{$amount} by {$number}");

                header('Content-Type: application/json');
                echo json_encode($app_data);
            } else {
                header('Content-Type: application/json');
                echo $full_response;
            }
        } catch(\Exception $e) {
            return 'Payment failed! ' . $e;
        }

        ?>
    ```

* /requesttopay/{referenceId} - GET

    TODO

## Disbursements API

* /transfer - POST

    `transfer.php` included in this repository has the code required to generate *Basic Authentication Token*, *Bearer Token* and POST a *transfer* Request, you just have to replace three (3) values in the code listed below:

    * `$api_user = 'enter_api_user_here';`
    * `$api_key = 'enter_api_key_here';`
    * `$subscription_key = "Enter_Subscription_Key_Here";`

    ```
        <?php
        // generate UUID
        function gen_uuid() {
            return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                // 32 bits for "time_low"
                mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

                // 16 bits for "time_mid"
                mt_rand( 0, 0xffff ),

                // 16 bits for "time_hi_and_version",
                // four most significant bits holds version number 4
                mt_rand( 0, 0x0fff ) | 0x4000,

                // 16 bits, 8 bits for "clk_seq_hi_res",
                // 8 bits for "clk_seq_low",
                // two most significant bits holds zero and one for variant DCE1.1
                mt_rand( 0, 0x3fff ) | 0x8000,

                // 48 bits for "node"
                mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
            );
        }

        // API User
        $api_user = 'enter_api_user_here';

        // API Key
        $api_key = 'enter_api_key_here';

        //API User and Key
        $api_user_and_key  = $api_user . ':' . $api_key;

        // Basic Authorisation
        $basic_auth = "Basic " . base64_encode($api_user_and_key);

        // JSON curl POST
        function doJSONCurl($host,$url,$basicAuth,$subscriptionKey,$postJSON = null){
            $headers = array(
                "Host: " . $host,
                "Content-type: application/json",
                "Authorization: " . $basicAuth,
                "Ocp-Apim-Subscription-Key: " . $subscriptionKey,
            ); 
            $CURL = curl_init();

            curl_setopt($CURL, CURLOPT_URL, $url); 
            curl_setopt($CURL, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); 
            curl_setopt($CURL, CURLOPT_POST, 1); 
            curl_setopt($CURL, CURLOPT_POSTFIELDS, $postJSON); 
            curl_setopt($CURL, CURLOPT_HEADER, false); 
            curl_setopt($CURL, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($CURL, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($CURL, CURLOPT_RETURNTRANSFER, true);
            $jsonResponse = curl_exec($CURL);
            curl_close($CURL);

            return $jsonResponse;
        }
        // Create API User data
        $host_server = "sandbox.momodeveloper.mtn.com";
        $request_url = "https://sandbox.momodeveloper.mtn.com/disbursement/token/";
        $subscription_key = "Enter_Subscription_Key_Here";

        // Submit for token creation
        try {
            $full_response = doJSONCurl($host_server, $request_url, $basic_auth, $subscription_key);
            $decoded_full_response = json_decode($full_response);
            if(!empty($decoded_full_response->message)) {
                if($decoded_full_response->message && $decoded_full_response->code) {
                    return 'Error Message: ' . $decoded_full_response->message . ' | Error Code: ' . $decoded_full_response->code;
                }
            }
        } catch(\Exception $e) {
            return 'Token failed to create. ' . $e;
        }

        // Bearer Token
        $bearer_token = 'Bearer ' . $decoded_full_response->access_token;

        // JSON curl Payment POST
        function doJSONCurlPay($host,$url,$bearerToken,$referenceId,$targetEnvironment,$subscriptionKey,$postJSON = null){
            $headers = array(
                "Host: " . $host,
                "Content-type: application/json",
                "Authorization: " . $bearerToken,
                "X-Reference-Id: " . $referenceId,
                "X-Target-Environment: " . $targetEnvironment,
                "Ocp-Apim-Subscription-Key: " . $subscriptionKey,
            ); 
            $CURL = curl_init();

            curl_setopt($CURL, CURLOPT_URL, $url); 
            curl_setopt($CURL, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); 
            curl_setopt($CURL, CURLOPT_POST, 1); 
            curl_setopt($CURL, CURLOPT_POSTFIELDS, $postJSON); 
            curl_setopt($CURL, CURLOPT_HEADER, false); 
            curl_setopt($CURL, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($CURL, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($CURL, CURLOPT_RETURNTRANSFER, true);
            $jsonResponse = curl_exec($CURL);
            $httpcode = curl_getinfo($CURL, CURLINFO_HTTP_CODE);
            curl_close($CURL);

            if($httpcode == 202) {
                return json_encode(array("code" => "202", "message" => "Accepted"));
            } elseif($httpcode == 400) {
                return json_encode(array("code" => "400", "message" => "Bad Request"));
            } elseif($httpcode == 409) {
                return json_encode(array("code" => "409", "message" => "Conflict"));
            } elseif($httpcode == 500) {
                return json_encode(array("code" => "500", "message" => "Internal Server Error"));
            } else {
                return $jsonResponse;
            }
        }
        // Request To Pay
        $amount = 500;
        $currency = "EUR";
        $number = "46733123453";
        $host_server = "sandbox.momodeveloper.mtn.com";
        $request_url = "https://sandbox.momodeveloper.mtn.com/disbursement/v1_0/transfer";
        $reference_id = gen_uuid();
        $target_environment = "sandbox";
        // $callback_url = $callback_url; // Use this in production
        $timestamp = date('Ymd_Gis');

        $REQUEST_BODY= <<<json
        {
            "amount": "{$amount}",
            "currency": "{$currency}",
            "externalId": "{$timestamp}",
            "payee": {
                "partyIdType": "MSISDN",
                "partyId": "{$number}"
            },
            "payerMessage": "Transfer of K{$amount}",
            "payeeNote": "Transfer of K{$amount} from {$number}"
        }
        json;

        // Submit payment json message
        try {
            $full_response = doJSONCurlPay($host_server, $request_url, $bearer_token, $reference_id, $target_environment, $subscription_key, $REQUEST_BODY);
            $decoded_full_response = json_decode($full_response);
            if($decoded_full_response->code == "202") {
                $app_data = array("amount"=>"{$amount}","reference"=>"{$reference_id}","narration"=>"Transfer of K{$amount} to {$number}");

                header('Content-Type: application/json');
                echo json_encode($app_data);
            } else {
                header('Content-Type: application/json');
                echo $full_response;
            }
        } catch(\Exception $e) {
            return 'Transfer failed! ' . $e;
        }

        ?>
    ```

* /transfer/{referenceId} - GET

    TODO

# Contribution Guidelines
Contributions can be made through pull requests.
* You can start by forking this repo
* Contribute to a branch relevant to you, if it exists
* Otherwise, create a new branch, for a new implementation, for example; REST, Java, React, Vue, Laravel, etc
* Once you are ready and everything checks out, you can push to your forked repo and create a pull request against this repo
* We will then review and approve

# More ToDo...
