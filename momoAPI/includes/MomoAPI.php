<?php

define("BASE_URL", "https://sandbox.momodeveloper.mtn.com/v1_0");
define("BASE_URL_COLLECTION", "https://sandbox.momodeveloper.mtn.com/collection");


class MomoAPI
{
    /**
     * @var string
     */
    private $subscriptionKey;
    /**
     * @var string use to store
     */
    private $target_environment;

    public function __construct($ocp_subscription_key, $target_environment = "sandbox")
    {
        $this->subscriptionKey = $ocp_subscription_key;
        $this->target_environment = $target_environment;
    }

    private function gen_uuid()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    /**
     * @param $reference_id
     * example response:
     * @param $callbackUrl
     * @return string|false return the reference_id if successful or false if it fails
     */
    function createAPIUser($reference_id, $callbackUrl)
    {
        $url = BASE_URL . "/apiuser";
        if ($reference_id === null) {
            $reference_id = $this->gen_uuid();
        }

        $body = array(
            'providerCallbackHost' => $callbackUrl
        );


        $header = array(
            "Accept: */*",
            "Accept-Encoding: gzip, deflate",
            "Content-Type: application/json",
            "Ocp-Apim-Subscription-Key: $this->subscriptionKey",
            "X-Reference-Id: $reference_id"
        );
        $res = $this->curl_post($url, $header, $body, "POST", false);

        return ($res['http_code'] == 201) ? $reference_id : false;
    }

    public function get_api_key($reference_id)
    {
        $url = BASE_URL . "/apiuser" . '/' . $reference_id . "/apikey";
        $header = array(
            "Accept: */*",
            "Accept-Encoding: gzip, deflate",
            "Content-Type: application/json",
            "Host: sandbox.momodeveloper.mtn.com",
            "Ocp-Apim-Subscription-Key: $this->subscriptionKey",
        );

        //echo "url is $url";
        $res = $this->curl_post($url, $header, null);
        // print_r($res);
        return ($res['http_code'] == 201) ? $res['response']->apiKey : null;

    }

    /**
     * retrieve the access token for the provided reference_id(api_user) and $api_key pair
     * @param $reference_id
     * @param $api_key
     * @return mixed|null an object with keys access_token,token_type, expires_in or null on failure
     */
    public function get_access_token($reference_id, $api_key)
    {
        $url = BASE_URL_COLLECTION . "/token/";
        //  echo "<br> url = $url";
        $data_base64 = base64_encode("$reference_id:$api_key");
        // echo $data_base64;
        $header = array(
            "Accept: */*",
            "Accept-Encoding: gzip, deflate",
            "Authorization: Basic $data_base64",
            "Content-Type: application/json",
            "Host: sandbox.momodeveloper.mtn.com",
            "Ocp-Apim-Subscription-Key: $this->subscriptionKey",
        );
        $res = $this->curl_post($url, $header, null);

        return ($res['http_code'] == 200) ? $res['response'] : null;
    }

    /**
     * @param  $access_token
     * @param RequestPayBody $requestPayBody
     * @param $callback_url string not used for testing
     * @param $external_reference string external reference id
     * @return bool true when successful or false other wise
     */
    public function requestPay($access_token, RequestPayBody $requestPayBody, $callback_url = "", $external_reference)
    {
        $url = BASE_URL_COLLECTION . "/v1_0/requesttopay";
        $header = array(
            "Authorization: Bearer $access_token",
            //"X-Callback-Url: $callback_url",  //causing the request to pay to failed
            "X-Reference-Id: $external_reference",
            "X-Target-Environment: $this->target_environment",
            "Content-Type: application/json",
            "Ocp-Apim-Subscription-Key: $this->subscriptionKey"
        );

        //echo "<br> body";
        // print_r($requestPayBody);
        $res = $this->curl_post($url, $header, $requestPayBody);
        return ($res['http_code'] == 202) ? true : false;
    }

    /**
     * @param $access_token
     * @param $reference_id
     * @return mixed
     */
    public function checkPaymentStatus($access_token, $reference_id)
    {
        $url = BASE_URL_COLLECTION . "/v1_0/requesttopay/$reference_id";
        $header = array(
            "Authorization: Bearer $access_token",
            "X-Target-Environment: $this->target_environment",
            "Content-Type: application/json",
            "Ocp-Apim-Subscription-Key: $this->subscriptionKey"
        );

        $res = $this->curl_post($url, $header, null, 'GET');

        return $res['response'];
    }


    public function checkBalance($access_token)
    {
        $url = BASE_URL_COLLECTION . "/v1_0/account/balance";
        $header = array(
            "Authorization: Bearer $access_token",
            "Content-Type: application/json",
            "X-Target-Environment: $this->target_environment",
            "Ocp-Apim-Subscription-Key: $this->subscriptionKey"
        );
        $res = $this->curl_post($url, $header, null, 'GET');
        // print_r($res);
        return $res['response'];
    }

    public function isUserAccountActive($access_token, $partyIdType, $partyId)
    {
        $url = BASE_URL_COLLECTION . "/v1_0/accountholder/$partyIdType/$partyId/active";
        $header = array(
            "Authorization: Bearer $access_token",
            "Content-Type: application/json",
            "X-Target-Environment: $this->target_environment",
            "Ocp-Apim-Subscription-Key: $this->subscriptionKey"
        );
        $res = $this->curl_post($url, $header, null, 'GET');
        //  print_r($res);
        //todo may be an error too
        return ($res['http_code'] == 200) ? true : false;
    }

    /**
     * Use to make http request
     * @param $url string the url to send the request
     * @param $headers array of string. the headers for the http request
     * @param $body array|object associative array of the http body
     * @param string $type request type POST or GET, default is POST
     * @param bool $returnResult , the return type is boolean when false or the result of the request when true
     * @return mixed|null return array of request result when $returnResult=true or boolean when $returnResult=false
     */
    private function curl_post($url, $headers, $body, $type = "POST", $returnResult = true)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => $returnResult,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $type,
            CURLOPT_POSTFIELDS => json_encode($body),
            CURLOPT_HTTPHEADER => $headers,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $res_info = curl_getinfo($curl);
        curl_close($curl);
        $http_code = $res_info['http_code'];

        if ($err) {
            echo "Error #:" . $err . "<br/>";
            $resData = null;
        } else {

            $resData = json_decode($response);

        }
        return ['http_code' => $http_code, 'response' => $resData];
    }
}
