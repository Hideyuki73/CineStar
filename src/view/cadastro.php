<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- Formulário de Cadastro -->
    <div class="form-container" id="register-form">
        <h2>Cadastro</h2>
        <form action="register.php" method="POST">
            <label for="register-email">Email:</label>
            <input type="email" id="register-email" name="email" required>
            <br>
            <label for="register-nickname">Nickname:</label>
            <input type="text" id="register-nickname" name="nickname" required>
            <br>
            <label for="register-password">Senha:</label>
            <input type="password" id="register-password" name="password" required>
            <br>
            <button type="submit">Cadastrar</button>
            <p>Já possui conta? <a href="login.php">Faça login</a></p>
        </form>
    </div>
</body>
</html>