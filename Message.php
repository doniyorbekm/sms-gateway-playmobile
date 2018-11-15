<?php

/**
 * Created by Doniyor Mamatkulov.
 * User: d.mamatkulov
 * Date: 15.11.2018
 * Time: 17:47
 */

class Message {

    public $pm_login = "login";
    public $pm_password = "password";
    public $pm_url = "http://url:8083/broker-api/send";

    public function sendMessage($recipient, $code) {
        $data = [
            'messages' => [
                [
                    'recipient'  => $recipient,
                    'message-id' => rand(1111111, 9999999),
                    'sms'        => [
                        'originator' => '3700',
                        'content'    => [
                            'text' => 'Nano Wi-Fi code: '.$code,
                        ]
                    ]
                ],
            ]
        ];

        $data_string = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$this->pm_url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$this->pm_login:$this->pm_password");
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}