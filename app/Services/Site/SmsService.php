<?php

namespace App\Services\Site;
/*
* SigmaSMS REST API
* https://online.sigmasms.ru/#/documentation/api/HTTP-REST
*/

class SmsService
{
    private $api_url = 'https://online.sigmasms.ru/api/';
    private $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    // Отправка сообщения
    public function send_msg($data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api_url . "sendings");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json;charset=UTF-8",
            "Accept: application/json",
            "Authorization: " . $this->token
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($response);
        return $result;
    }

    public function get_user_data_by_phone(string $phone): array
    {
        $url = $this->api_url . "users" . "?" . '$search=' . $phone;
        $response = $this->get_data_by_url($url);
        return $response;
    }

    public function get_data_by_url(string $url): array
    {
        $ch = curl_init($url);
        $headers = array("Content-Type:application/json", "Authorization:" . $this->token);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $response = json_decode($response, true);
        return $response;
    }

    // Регистрация
    public function sign_up($login, $firstName, $lastname, $email, $phone, $password, $x_fordered_for, $amo_confirmed)
    {
        $data = ['username' => $login, 'password' => $password, 'data' => ['phone' => $phone, 'email' => $email, 'firstName' => $firstName, 'lastName' => $lastname], '$amo_confirmed' => $amo_confirmed];
        $test = $data;
        file_put_contents("test_register.txt", "<pre>" . json_encode($data) . "</pre>");
        $curl = curl_init($this->api_url . 'registration');
        if ($x_fordered_for) {
            $headers = array("x-forwarded-for:" . $x_fordered_for, "Content-Type: application/json;charset=UTF-8", "Accept: application/json",);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        $curl_jason = json_decode($response, true);
        return $curl_jason;
    }

    public function get_profile_data(): array
    {
        $params = http_build_query(['$scope[0]' => "full"]);
        $url = $this->api_url . "users/" . $data['id'] . "?" . $params;
        $user_data = $this->get_data_by_url($url);
        return $user_data;
    }

    public function get_user_data_by_id($id, $params)
    {
        $params = http_build_query($params);
        $url = $this->api_url . "users/" . $id;
        $ch = curl_init($url . "?" . $params);
        $headers = array("Content-Type:application/json", "Authorization:" . $this->token);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $response = json_decode($response, true);
        return $ch;
    }

    public function check_answer($url_path): array
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api_url . $url_path);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json;charset=UTF-8", "Accept: application/json", "Authorization: " . $this->token));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);
        return $response;
    }

    public function check_status($id): array
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api_url . 'sendings/' . $id);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json;charset=UTF-8", "Accept: application/json", "Authorization: " . $this->token));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($response, true);
        return $result;
    }

    // Загрузка файла
    public function send_file($file_path): array
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api_url . "storage");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: " . mime_content_type($file_path), "Content-length: " . filesize($file_path), "Authorization: " . $this->token));
        curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents($file_path));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($response, true);
        return $result;
    }

    function clear_phone(string $phone): string
    {
        $phone_number = preg_replace('/[+() -]+/', '', $phone);
        return $phone_number;
    }
}
