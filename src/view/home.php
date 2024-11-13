

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - CineStar</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Bem-vindo ao CineStar</h1>
        <nav>
            <a href="ratings.php" class="button">Avaliações</a>
            <a href="logout.php" class="button">Logout</a>
        </nav>
    </header>

    <main>

        <form method="GET" action="home.php">
            <input type="text" name="search" placeholder="Pesquisar filmes..." value="<?php echo htmlspecialchars($searchTerm); ?>">
            <button type="submit">Buscar</button>
        </form>

        <section class="movie-list">
            <h2>Filmes Cadastrados</h2>
            <?php if (count($movies) > 0): ?>
                <ul>
                    <?php foreach ($movies as $movie): ?>
                        <li>
                            <h3><?php echo htmlspecialchars($movie['title']); ?></h3>
                            <p><?php echo htmlspecialchars($movie['description']); ?></p>
                            <p><strong>Ano:</strong> <?php echo htmlspecialchars($movie['year']); ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Nenhum filme encontrado.</p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
