<?php

use PHPUnit\Framework\TestCase;

class MovieApiTest extends TestCase
{
    private $baseUri;

    protected function setUp(): void
    {
        $this->baseUri = 'http://localhost:8080/src/api/';
        // Assume que o usuário já foi criado externamente
    }

    public function testCreateMovie()
    {
        $userId = $this->getUserIdByEmail('filme@teste.com');
        $this->assertNotNull($userId, "User ID should not be null");

        $_SESSION['user_id'] = $userId;  // Configurando o user_id na sessão

        $payload = [
            'nome' => 'The Matrix',
            'descricao' => 'A sci-fi classic.',
            'rating' => 5,
            'id_users' => $userId
        ];

        $response = $this->sendRequest('POST', 'movies', $payload);
        $this->logResponse('Create Movie', $response);

        $this->assertEquals(201, $response['statusCode']);

        $movieResponse = $this->sendRequest('GET', 'movies');
        $this->logResponse('Get Movies', $movieResponse);
        
        $this->assertIsArray($movieResponse['body'], "Movies response should be an array");
        
        $movieId = $this->extractMovieId($movieResponse['body'], 'The Matrix');
        $this->assertNotNull($movieId, "Filme criado com sucesso.");
    }

    public function testUpdateMovie()
    {
        // Criar um filme para atualizar
        $userId = $this->getUserIdByEmail('filme@teste.com');
        $this->assertNotNull($userId, "User ID should not be null");

        $_SESSION['user_id'] = $userId;  // Configurando o user_id na sessão

        $payloadCreate = [
            'nome' => 'The Matrix',
            'descricao' => 'A sci-fi classic.',
            'rating' => 5,
            'id_users' => $userId
        ];

        $responseCreate = $this->sendRequest('POST', 'movies', $payloadCreate);
        $this->logResponse('Create Movie for Update', $responseCreate);
        $this->assertEquals(201, $responseCreate['statusCode']);

        $movieResponse = $this->sendRequest('GET', 'movies');
        $this->logResponse('Get Movies for Update', $movieResponse);
        $this->assertIsArray($movieResponse['body'], "Movies response should be an array");

        $movieId = $this->extractMovieId($movieResponse['body'], 'The Matrix');

        // Atualizar o filme criado
        $payloadUpdate = [
            'id' => $movieId,
            'nome' => 'The Matrix Reloaded',
            'descricao' => 'The second part of the classic.',
            'rating' => 4,
            'id_users' => $userId
        ];

        $responseUpdate = $this->sendRequest('PUT', 'movies', $payloadUpdate);
        $this->logResponse('Update Movie', $responseUpdate);
        $this->assertEquals(200, $responseUpdate['statusCode']);
        $this->assertEquals('Filme atualizado com sucesso.', $responseUpdate['body']['message']);
    }

    public function testDeleteMovie()
    {
        // Criar um filme para deletar
        $userId = $this->getUserIdByEmail('filme@teste.com');
        $this->assertNotNull($userId, "User ID should not be null");

        $_SESSION['user_id'] = $userId;  // Configurando o user_id na sessão

        $payloadCreate = [
            'nome' => 'The Matrix',
            'descricao' => 'A sci-fi classic.',
            'rating' => 5,
            'id_users' => $userId
        ];

        $responseCreate = $this->sendRequest('POST', 'movies', $payloadCreate);
        $this->logResponse('Create Movie for Delete', $responseCreate);
        $this->assertEquals(201, $responseCreate['statusCode']);

        $movieResponse = $this->sendRequest('GET', 'movies');
        $this->logResponse('Get Movies for Delete', $movieResponse);
        $this->assertIsArray($movieResponse['body'], "Movies response should be an array");

        $movieId = $this->extractMovieId($movieResponse['body'], 'The Matrix');

        // Deletar o filme criado
        $payloadDelete = [
            'id' => $movieId,
            'id_users' => $userId
        ];
        $responseDelete = $this->sendRequest('DELETE', 'movies', $payloadDelete);
        $this->logResponse('Delete Movie', $responseDelete);
        $this->assertEquals(200, $responseDelete['statusCode']);
        $this->assertEquals('Filme deletado com sucesso.', $responseDelete['body']['message']);
    }

    private function extractMovieId(array $movies, string $nome): ?string
    {
        foreach ($movies as $movie) {
            if ($movie['nome'] === $nome) {
                return $movie['id'];
            }
        }
        return null;
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

        // Verificar se a resposta é válida
        $decodedResponse = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Invalid JSON response: ' . json_last_error_msg());
        }

        return ['body' => $decodedResponse, 'statusCode' => $httpCode];
    }

    private function getUserIdByEmail($email)
    {
        $response = $this->sendRequest('GET', "users?email=$email");

        if (isset($response['body'][0]['id'])) {
            return $response['body'][0]['id'];
        }

        return null;
    }

    private function logResponse(string $action, array $response): void
    {
        error_log("Action: $action");
        error_log("Status Code: " . $response['statusCode']);
        error_log("Response Body: " . json_encode($response['body']));
    }
}
