<?php
session_start();
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $data = [
        'email' => $email,
        'senha' => $senha
    ];

    // Atualize o endpoint para o correto de login
    $ch = curl_init("http://localhost/src/api/users/login"); // Rota configurada para o login
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    // Executa a requisição e obtém a resposta
    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    // Verifica o resultado do login
    if (isset($result['status']) && $result['status'] == 'success') {
        $_SESSION['user_id'] = $result['user_id'];
        header("Location: home.php");
        exit();
    } else {
        $error_message = $result['message'] ?? "Falha no login";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/src/view/style.css">
    <style>
        /* Estilo da mensagem de erro */
        .error-message {
            color: #d9534f;
            background-color: #f2dede;
            border: 1px solid #ebccd1;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Formulário de Login -->
    <div class="form-container" id="login-form">
        <h2>Login</h2>

        <!-- Mensagem de erro -->
        <?php if (!empty($error_message)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <label for="login-email">Email:</label>
            <input type="email" id="login-email" name="email" required>
            <br>
            <label for="login-password">Senha:</label>
            <input type="password" id="login-password" name="senha" required> <!-- Alterado para "senha" -->
            <br>
            <button type="submit">Entrar</button>
            <p>Não possui conta? <a href="register.php">Cadastre-se</a></p>
        </form>
    </div>
</body>
</html>
