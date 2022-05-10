<?php
namespace App\Http\Controllers;


class ShurjoPay
{
    protected $merchant_username;
    protected $merchant_password;
    protected $client_ip;
    protected $merchant_key_prefix;
    protected $tx_id;
    protected $server_url;

    public function __construct()
    {
        $this->merchant_username = env('SHURJOPAY_MERCHANT_USERNAME');
        $this->merchant_password = env('SHURJOPAY_MERCHANT_PASSWORD');
        $this->client_ip = $_SERVER["REMOTE_ADDR"] ?? '127.0.0.1';
        $this->merchant_key_prefix = env('SHURJOPAY_MERCHANT_KEY_PREFIX');
        $this->server_url = env('SHURJOPAY_SERVER_URL');
    }

    public function generateTxId($unique_id = null)
    {
        $this->tx_id = $unique_id ? $this->merchant_key_prefix.$unique_id : $this->merchant_key_prefix.uniqid();
        return $this->tx_id;
    }

    public function sendPayment($reqdata, $success_url = null)
    {
        $return_url = route('shurjopay.callback');
        if ($success_url) {
            $return_url .= "?success_url={$success_url}";
        }
        $amount=$reqdata['amount'];
        $data = array(
            'merchantName' => $this->merchant_username,
            'merchantPass' => $this->merchant_password,
            'userIP' => $this->client_ip,
            'uniqID' => $this->generateTxId(),
            'custom1' => $reqdata['custom1'],
            'custom2' => $reqdata['custom2'],
            'custom3' => $reqdata['custom3'],
            'custom4' => $reqdata['custom4'],
            //'school' => $reqdata['amount'],
            'paymentterm' => '', //Tenure Months like 3,6,12,18,36
            'minimumamount' => '', //Minimum Amount 10000
            'totalAmount' => $amount,
            'is_emi'=>0, //0 NO EMI 1 EMI True
            'paymentOption' => 'shurjopay',
            'returnURL' => $return_url,
        );
        $payload = array("spdata" => json_encode($data));

        $ch = curl_init();
        $url = $this->server_url . "/sp-pp.php";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);                //0 for a get request
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        print_r($response);

    }
}
