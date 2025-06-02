<?php

namespace App\Services\Site;

class MangoService
{
    private $api_url = 'https://api.mango-office.ru/v2/';
    private $api_key;
    private $api_salt;

    public function __construct($api_key, $api_salt)
    {
        $this->api_key = $api_key;
        $this->api_salt = $api_salt;
    }

    public function send_msg($to, $text, $sender = 'B-Media')
    {
        $data = [
            'command_id' => uniqid(),
            'from' => $sender,
            'to' => $to,
            'text' => $text
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api_url . "sms/send");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Basic " . base64_encode($this->api_key . ":" . $this->api_salt)
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        
        $response = curl_exec($ch);
        
        if ($response === false) {
            throw new \Exception('Curl error: ' . curl_error($ch));
        }
        
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode !== 200) {
            throw new \Exception('HTTP error: ' . $httpCode . ', Response: ' . $response);
        }
        
        curl_close($ch);
        
        $result = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('JSON decode error: ' . json_last_error_msg());
        }
        
        return $result;
    }
} 