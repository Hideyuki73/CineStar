<?php

use PHPUnit\Framework\TestCase;

class UserApiTest extends TestCase
{
    private $baseUrl = "http://localhost:8080/src/api/users"; 

    public function testCreateUser()
    {
        $email = 'teste@teste.com';
        $payload = [
            'nickname' => 'teste',
            'email' => $email,
            'senha' => 'password123'
        ];

        $response = $this->sendRequest('POST', '', $payload);

        $this->assertEquals(201, $response['statusCode']);

        // Buscar o usuário criado para obter o ID correto
        $userResponse = $this->sendRequest('GET', "?email=$email");
        $createdUserId = $this->extractUserId($userResponse['body'], $email);
        $this->assertNotNull($createdUserId, "Usuário criado com sucesso.");
    }

    public function testLogin()
{
    $email = 'teste@teste.com';
    $senha = 'password123';

    // Tentativa de login com dados válidos
    $payload = [
        'email' => $email,
        'senha' => $senha
    ];
    $response = $this->sendRequest('POST', '/login', $payload);
    $this->assertEquals(200, $response['statusCode']);
    $this->assertEquals('Login realizado com sucesso.', $response['body']['message']);

    // Tentativa de login com senha incorreta
    $payloadWrongPassword = [
        'email' => $email,
        'senha' => 'wrongpassword'
    ];
    $responseWrongPassword = $this->sendRequest('POST', '/login', $payloadWrongPassword);
    $this->assertEquals(401, $responseWrongPassword['statusCode']);
    $this->assertEquals('Email ou senha incorretos.', $responseWrongPassword['body']['message']);

    // Tentativa de login com email inexistente
    $payloadWrongEmail = [
        'email' => 'email_inexistente@teste.com',
        'senha' => 'password123'
    ];
    $responseWrongEmail = $this->sendRequest('POST', '/login', $payloadWrongEmail);
    $this->assertEquals(401, $responseWrongEmail['statusCode']);
    $this->assertEquals('Email ou senha incorretos.', $responseWrongEmail['body']['message']);
}



    public function testUpdateUser()
    {
        // Buscar o usuário criado no teste anterior
        $email = 'teste@teste.com';
        $userResponse = $this->sendRequest('GET', "?email=$email");
        $createdUserId = $this->extractUserId($userResponse['body'], $email);

        // Atualizar o usuário criado
        $payloadUpdate = [
            'id' => $createdUserId,
            'nickname' => 'teste2',
            'email' => 'teste2@teste.com',
            'senha' => 'newpassword123'
        ];
        $responseUpdate = $this->sendRequest('PUT', '', $payloadUpdate);
        $this->assertEquals(200, $responseUpdate['statusCode']);
        $this->assertEquals('Usuário atualizado com sucesso.', $responseUpdate['body']['message']);
    }

    public function testDeleteUser()
    {
        // Buscar o usuário atualizado no teste anterior
        $email = 'teste2@teste.com';
        $userResponse = $this->sendRequest('GET', "?email=$email");
        $updatedUserId = $this->extractUserId($userResponse['body'], $email);

        // Deletar o usuário atualizado
        $payloadDelete = ['id' => $updatedUserId];
        $responseDelete = $this->sendRequest('DELETE', '', $payloadDelete);
        $this->assertEquals(200, $responseDelete['statusCode']);
        $this->assertEquals('Usuário deletado com sucesso.', $responseDelete['body']['message']);
    }

    private function extractUserId(array $users, string $email): ?string
    {
        foreach ($users as $user) {
            if ($user['email'] === $email) {
                return $user['id'];
            }
        }
        return null;
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

    public function testCreateUserWithIncompleteData()
{
    // Tentativa de criação de usuário sem o campo 'nickname'
    $payloadWithoutNickname = [
        'email' => 'teste@incompleto.com',
        'senha' => 'password123'
    ];
    $responseWithoutNickname = $this->sendRequest('POST', '', $payloadWithoutNickname);
    $this->assertEquals(400, $responseWithoutNickname['statusCode']);
    $this->assertEquals('Dados incompletos.', $responseWithoutNickname['body']['message']);

    // Tentativa de criação de usuário sem o campo 'email'
    $payloadWithoutEmail = [
        'nickname' => 'teste_incompleto',
        'senha' => 'password123'
    ];
    $responseWithoutEmail = $this->sendRequest('POST', '', $payloadWithoutEmail);
    $this->assertEquals(400, $responseWithoutEmail['statusCode']);
    $this->assertEquals('Dados incompletos.', $responseWithoutEmail['body']['message']);

    // Tentativa de criação de usuário sem o campo 'senha'
    $payloadWithoutSenha = [
        'nickname' => 'teste_incompleto',
        'email' => 'teste@incompleto.com'
    ];
    $responseWithoutSenha = $this->sendRequest('POST', '', $payloadWithoutSenha);
    $this->assertEquals(400, $responseWithoutSenha['statusCode']);
    $this->assertEquals('Dados incompletos.', $responseWithoutSenha['body']['message']);
}
}
