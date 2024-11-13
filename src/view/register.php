<?php
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nickname = $_POST['nickname'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $data = [
        'nickname' => $nickname,
        'email' => $email,
        'senha' => $senha
    ];

    $ch = curl_init("http://localhost:8000/src/api/users"); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    if (isset($result['message']) && $result['message'] == 'Usuário criado com sucesso.') {
        header("Location: login.php");
        exit();
    } else {
        $error_message = $result['message'] ?? "Falha no registro";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="style.css">
    <style>
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

    <div class="form-container" id="register-form">
        <h2>Cadastro</h2>

        <?php if (!empty($error_message)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <form action="register.php" method="POST">
            <label for="register-email">Email:</label>
            <input type="email" id="register-email" name="email" required>
            <br>
            <label for="register-nickname">Nickname:</label>
            <input type="text" id="register-nickname" name="nickname" required>
            <br>
            <label for="register-password">Senha:</label>
            <input type="password" id="register-password" name="senha" required>
            <button type="submit">Cadastrar</button>
            <p>Já possui conta? <a href="login.php">Faça login</a></p>
        </form>
    </div>
</body>
</html>
