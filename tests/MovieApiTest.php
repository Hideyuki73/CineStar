<?php

use PHPUnit\Framework\TestCase;

class MovieApiTest extends TestCase
{
    private $baseUri;

    protected function setUp(): void
    {
        $this->baseUri = 'http://localhost:8080/src/api/';
    }

    private function getUserId()
{
    $userPayload = [
        'email' => 'john.doe@example.com',
        'senha' => 'password123'
    ];

    $response = $this->sendRequest('POST', 'users/login', $userPayload);

    return $response['body']['user_id'] ?? null;
}


    private function sendRequest(string $method, string $endpoint, array $data = []): array
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->baseUri . $endpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen(json_encode($data)),
            ]);
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return ['body' => json_decode($response, true), 'statusCode' => $httpCode];
    }

    public function testCreateMovieWithMissingFields()
    {
        $response = $this->sendRequest('POST', 'movies', [
            'title' => 'Missing Description',
            'rating' => 4
        ]);

        $this->assertEquals(400, $response['statusCode']);
    }
    

}
