<?php
session_start();
require 'db.php';

$query = "SELECT image, nazvanie FROM tovar";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Галерея</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .gallery-container {
            max-width: 1200px;
            margin: 20px auto;
            text-align: center;
        }
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            justify-items: center;
            padding: 20px;
        }
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: transform 0.3s ease-in-out;
        }
        .gallery-item:hover {
            transform: scale(1.05);
        }
        .gallery-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }
        .gallery-caption {
            position: absolute;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            width: 100%;
            text-align: center;
            padding: 5px 0;
            font-size: 14px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<header>
    <div class="header-container">
        <img src="logo.png" class="logo" alt="Логотип магазина">
        <nav class="navbar">
            <ul>
                <li><a href="index.php">Главная</a></li>
                <li><a href="gallery.php">Галерея</a></li>
                <li><a href="products.php">Товары</a></li>
                <li><a href="contacts.php">Контакты</a></li>
                <?php if(isset($_SESSION['user'])): ?>
                    <li><a href="profile.php">Личный кабинет</a></li>
                    <li><a href="logout.php">Выход</a></li>
                <?php else: ?>
                    <li><a href="login.php">Вход</a></li>
                    <li><a href="register.php">Регистрация</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>

<div class="gallery-container">
    <h1>Галерея товаров</h1>
    <div class="gallery-grid">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="gallery-item">
                <img src="<?= $row['image'] ?: 'uploads/no-image.png'; ?>" alt="<?= htmlspecialchars($row['nazvanie']); ?>">
                <div class="gallery-caption"><?= htmlspecialchars($row['nazvanie']); ?></div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<footer class="footer">
    <p>&copy; 2025 Магазин. Все права защищены.</p>
</footer>

</body>
</html>
