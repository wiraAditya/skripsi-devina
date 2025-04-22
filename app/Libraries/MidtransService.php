<?php

namespace App\Libraries;

class MidtransService
{
    private $serverKey;
    private $isProduction;
    
    public function __construct()
    {
        $this->serverKey = "SB-Mid-server-i6hgjRkB3NyIpmjMGG3rwq9t";
        $this->isProduction = false;
    }

    public function createSnapToken($params)
    {
        $url = $this->isProduction 
            ? 'https://app.midtrans.com/snap/v1/transactions' 
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';
            
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Basic ' . base64_encode($this->serverKey . ':')
        ];
        
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($params),
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_CAINFO => APPPATH . 'ThirdParty/cacert.pem'
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
            print_r($err);
            die();
            log_message('error', 'Midtrans cURL Error: ' . $err);
            return null;
        } else {
            $responseArray = json_decode($response, true);
            log_message('info', 'Midtrans response: ' . $response);
            return $responseArray['token'] ?? null;
        }
    }
}