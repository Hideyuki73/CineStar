<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../config/db.php';
require_once '../controller/RatingController.php';
require_once '../controller/Movie.php';

$ratingController = new RatingController($pdo);
$movieController = new MovieController($pdo);

$ratings = $ratingController->list();
$movies = $movieController->list();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = $_POST['rating'];
    $movieId = $_POST['movie_id'];
    $userId = $_SESSION['user_id']; 


    if (!empty($rating) && !empty($movieId)) {
        $ratingController->create($rating, $userId, $movieId);
        header("Location: ratings.php");
        exit();
    } else {
        $error = "Por favor, preencha todos os campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliações - CineStar</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Avaliações de Filmes</h1>
        <nav>
            <a href="home.php" class="button">Home</a>
            <a href="logout.php" class="button">Logout</a>
        </nav>
    </header>

    <main>
        <section class="rating-list">
            <h2>Avaliações Existentes</h2>
            <?php if (count($ratings) > 0): ?>
                <ul>
                    <?php foreach ($ratings as $rating): ?>
                        <li>
                            <p><strong>Filme:</strong> <?php echo htmlspecialchars($rating['movie_title']); ?></p>
                            <p><strong>Avaliação:</strong> <?php echo htmlspecialchars($rating['rating']); ?>/5</p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Nenhuma avaliação encontrada.</p>
            <?php endif; ?>
        </section>

        <section class="rating-form">
            <h2>Adicionar Avaliação</h2>
            <?php if (isset($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <form method="POST" action="ratings.php">
                <label for="movie_id">Filme:</label>
                <select name="movie_id" id="movie_id" required>
                    <option value="">Selecione um filme</option>
                    <?php foreach ($movies as $movie): ?>
                        <option value="<?php echo $movie['id']; ?>"><?php echo htmlspecialchars($movie['title']); ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="rating">Avaliação (1 a 5):</label>
                <input type="number" name="rating" id="rating" min="1" max="5" required>

                <button type="submit">Enviar Avaliação</button>
            </form>
        </section>
    </main>
</body>
</html>
