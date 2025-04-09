<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user']['id_client'];

$query = "
SELECT 
    c.date, 
    t.nazvanie AS tovar_name, 
    ty.nazvanie AS type_name,
    t.price,
    c.kolichestvo
FROM checki c
JOIN tovar t ON c.id_tovar = t.id_tovar
LEFT JOIN type ty ON t.id_type = ty.id_type
WHERE c.id_client = ?
ORDER BY c.date DESC
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мои заказы</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .orders-container {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 2px 2px 15px rgba(0, 0, 0, 0.1);
        }
        .orders-container h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fafafa;
        }
        th, td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #333;
            color: #fff;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #007bff;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
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

<div class="orders-container">
    <h2>Мои заказы</h2>
    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Дата</th>
                    <th>Название товара</th>
                    <th>Тип</th>
                    <th>Цена (руб)</th>
                    <th>Количество</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= date('d.m.Y', strtotime($order['date'])) ?></td>
                        <td><?= htmlspecialchars($order['tovar_name']) ?></td>
                        <td><?= htmlspecialchars($order['type_name']) ?></td>
                        <td><?= number_format($order['price'], 2, ',', ' ') ?></td>
                        <td><?= $order['kolichestvo'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align: center;">У вас пока нет заказов.</p>
    <?php endif; ?>

    <a href="profile.php" class="back-link">← Вернуться в личный кабинет</a>
</div>

<footer class="footer">
    &copy; <?= date('Y') ?> Все права защищены.
</footer>

</body>
</html>
