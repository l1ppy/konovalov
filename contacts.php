<?php  
session_start();
require 'db.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Контакты</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .contacts-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }
        .map-container {
            margin-top: 20px;
        }
        .map-container img {
            width: 100%;
            max-width: 600px;
            border-radius: 10px;
            cursor: pointer;
        }
        .map-container img {
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 10px;
            transition: transform 0.3s ease-in-out; 
        }

        .map-container img:hover {
            transform: scale(1.1); 
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

<div class="container contacts-container">
    <h1>Наши контакты</h1>
    <p><strong>Адрес:</strong> г. Санкт-Петербург, ул. Большая морская, д.67 лит. А</p>
    <p><strong>Телефон:</strong> +7 (812) 123-45-67</p>
    <p><strong>Email:</strong> info@shop.ru</p>
    <p><strong>График работы:</strong></p>
    <ul>
        <p>Понедельник - Пятница: 10:00 - 20:00</p>
        <p>Суббота - Воскресенье: 11:00 - 18:00</p>
    </ul>

    <div class="map-container">
        <p><strong>Мы на карте:</strong></p> <br>
        <a href="https://yandex.ru/maps/?text=Санкт-Петербург, ул. Большая морская, д.67 литА" target="_blank">
            <img src="map_preview.jpg" alt="Карта - нажмите для открытия в Яндекс.Картах">
        </a>
    </div>
</div>

<footer class="footer">
    <p>&copy; 2025 Магазин. Все права защищены.</p>
</footer>

</body>
</html>