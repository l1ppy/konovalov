<?php 
session_start();
require 'db.php';

$query = "SELECT * FROM tovar LIMIT 5";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Магазин</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .products {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .product-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            width: 200px;
            background: #fff;
            box-shadow: 2px 2px 10px rgba(0,0,0,0.1);
        }
        .product-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
        }
        .btn {
            display: inline-block;
            margin-top: 10px;
            padding: 5px 10px;
            background: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover {
            background: #0056b3;
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

    <div class="container">
        <h1>Добро пожаловать в наш магазин!</h1>
        <p>Мы предлагаем качественные товары по доступным ценам.</p>
        
        <p>
            Мы — ваш надежный партнер в мире качественных товаров по доступным ценам.  
            Наш магазин предлагает широкий ассортимент продукции, начиная от стильной одежды 
            и аксессуаров, заканчивая электроникой и бытовыми товарами.  
            Мы сотрудничаем только с проверенными поставщиками, гарантируя высокое качество 
            и долговечность каждой единицы товара.
        </p>
        <p>
            Почему выбирают нас?
            <ul>
                <li>✅ Высокое качество продукции</li>
                <li>✅ Доступные цены и регулярные скидки</li>
                <li>✅ Быстрая и удобная доставка</li>
                <li>✅ Гарантия возврата и обмена</li>
                <li>✅ Поддержка 24/7 для наших клиентов</li>
            </ul>
        </p>
        <p>
            Делайте покупки с удовольствием! Ознакомьтесь с нашим ассортиментом, выберите лучшее 
            для себя и наслаждайтесь качеством и сервисом.
        </p>

        <h2>Популярные товары</h2>
        <div class="products">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="product-card">
                    <img src="<?= $row['image'] ?: 'uploads/no-image.png'; ?>" alt="<?= $row['nazvanie']; ?>">
                    <h3><?= $row['nazvanie']; ?></h3>
                    <p>Цена: <?= $row['price']; ?> руб.</p>
                    <a href="products.php" class="btn">Подробнее</a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 Магазин. Все права защищены.</p>
    </footer>

</body>
</html>
