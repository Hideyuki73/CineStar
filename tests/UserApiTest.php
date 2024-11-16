<?php

use PHPUnit\Framework\TestCase;

class UserApiTest extends TestCase
{
    private $baseUrl = "http://localhost:8080/src/api/users"; 

    public function testUserLogin()
    {
        $payload = [
            'email' => 'john.doe@example.com',
            'senha' => 'password123'
        ];
    
        $response = $this->sendRequest('POST', '/login', $payload);
    
        $this->assertEquals(200, $response['statusCode']);
        $this->assertArrayHasKey('user_id', $response['body']);
        $this->assertEquals('Login realizado com sucesso.', $response['body']['message']);
    }
    

    private function sendRequest($method, $endpoint, $data = [], $token = null)
    {
        $url = $this->baseUrl . $endpoint;

        $options = [
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json'
            ],
            CURLOPT_POSTFIELDS => json_encode($data)
        ];

        if ($token) {
            $options[CURLOPT_HTTPHEADER][] = "Authorization: Bearer $token";
        }

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);

        $result = curl_exec($ch);
        if ($result === false) {
            throw new \Exception('Request failed: ' . curl_error($ch));
        }
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return [
            'statusCode' => $httpCode,
            'body' => json_decode($result, true)
        ];
    }

    private function getUserId()
    {
        $payload = [
            'email' => 'john.doe@example.com',
            'senha' => 'password123'
        ];
    
        $response = $this->sendRequest('POST', '/login', $payload);
    
        return $response['body']['user_id'] ?? null;
    }
    
}
