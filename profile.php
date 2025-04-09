<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user']['id_client'];

$query = "SELECT * FROM client WHERE id_client = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .profile-container {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 2px 2px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #007bff;
            margin-bottom: 15px;
        }
        .profile-info {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .btn {
            display: inline-block;
            padding: 10px 15px;
            margin: 10px;
            text-decoration: none;
            color: white;
            border-radius: 5px;
            font-size: 16px;
        }
        .btn-edit {
            background: #007bff;
        }
        .btn-edit:hover {
            background: #0056b3;
        }
        .btn-orders {
            background: #28a745;
        }
        .btn-orders:hover {
            background: #218838;
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
                <li><a href="profile.php">Личный кабинет</a></li>
                <li><a href="logout.php">Выход</a></li>
            </ul>
        </nav>
    </div>
</header>

<div class="profile-container">
    <img src="<?= $user['avatar'] ?: 'uploads/default-avatar.png'; ?>" alt="Аватар" class="profile-avatar">
    <h2><?= htmlspecialchars($user['fio']) ?: 'Не указано' ?></h2>
    <p class="profile-info"><strong>Телефон:</strong> <?= htmlspecialchars($user['number']) ?: 'Не указано' ?></p>
    <p class="profile-info"><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?: 'Не указано' ?></p>
    <p class="profile-info"><strong>Паспорт:</strong> <?= htmlspecialchars($user['pasport']) ?: 'Не указано' ?></p>
    <p class="profile-info"><strong>Логин:</strong> <?= htmlspecialchars($user['login']) ?: 'Не указано' ?></p>

    <a href="edit_profile.php" class="btn btn-edit">Редактировать данные</a>
    <a href="orders.php" class="btn btn-orders">Мои покупки</a>
</div>

<footer class="footer">
    <p>&copy; 2025 Магазин. Все права защищены.</p>
</footer>

</body>
</html>
