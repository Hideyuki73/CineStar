<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro e Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Formulário de Login -->
    <div class="form-container" id="login-form">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <label for="login-email">Email:</label>
            <input type="email" id="login-email" name="email" required>
            <br>
            <label for="login-password">Senha:</label>
            <input type="password" id="login-password" name="password" required>
            <br>
            <button type="submit">Entrar</button>
            <p>Não possui conta? <a href="cadastro.php">Cadastre-se</a></p>
        </form>
    </div>
</body>
</html>
