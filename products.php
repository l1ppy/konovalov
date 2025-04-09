<?php
session_start();
require 'db.php'; 

$search = $_GET['search'] ?? '';
$sort = $_GET['sort'] ?? 'nazvanie';
$order = strtoupper($_GET['order'] ?? 'ASC');
$order = ($order === 'DESC') ? 'DESC' : 'ASC';

$validSorts = ['nazvanie', 'price'];
if (!in_array($sort, $validSorts)) $sort = 'nazvanie';

$searchParam = "%" . $search . "%";

$query = "
SELECT 
    t.id_tovar, 
    t.nazvanie, 
    t.price, 
    t.opisanie, 
    ty.nazvanie AS type_name, 
    p.nazvanie AS postavshik
FROM tovar t
LEFT JOIN type ty ON t.id_type = ty.id_type
LEFT JOIN postavki p ON t.id_postavki = p.id_postavki
WHERE t.nazvanie LIKE ?
ORDER BY $sort $order
";

$stmt = $conn->prepare($query);
$stmt->bind_param('s', $searchParam);
$stmt->execute();
$result = $stmt->get_result();

$managerQuery = "SELECT id_manager FROM manager ORDER BY RAND() LIMIT 1";
$managerResult = $conn->query($managerQuery);
$randomManager = $managerResult->fetch_assoc()['id_manager'] ?? 1;

$id_client = $_SESSION['user']['id_client'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected'])) {
    foreach ($_POST['selected'] as $id_tovar) {
        $kol = intval($_POST['quantity'][$id_tovar] ?? 1);
        if ($kol < 1) $kol = 1;

        $insert = $conn->prepare("INSERT INTO checki (id_tovar, id_manager, id_client, date, kolichestvo) VALUES (?, ?, ?, NOW(), ?)");
        $insert->bind_param("iiii", $id_tovar, $randomManager, $id_client, $kol);
        $insert->execute();
    }
    echo "<script>alert('Заказ успешно оформлен!'); location.href='orders.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Товары</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #f4f4f4;
            color: #333;
            background: url('background.jpg') no-repeat center center;
            background-attachment: scroll;
            background-size: cover;
            line-height: 1.6;
        }
        h2 {
            text-align: center;
        }
        form.search-sort {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #343a40;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .submit-btn {
            background-color: #343a40;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            display: block;
            margin: 0 auto;
        }
        .submit-btn:hover {
            background-color: #495057;
        }
        header {
            background: #333;
            padding: 10px 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0;
            padding: 0 20px;
        }

        .logo {
            height: 50px;
            width: auto;
            border-radius: 50%;
        }

        .footer {
    background: #333;
    color: #fff;
    text-align: center;
    padding: 15px 0;
    margin-top: 20px;
    position: relative;
    bottom: 0;
    width: 100%;
}

        .navbar {
            flex-grow: 1;
            display: flex;
            justify-content: center;
        }

        .navbar ul {
            list-style: none;
            display: flex;
            gap: 20px;
            padding: 0;
            margin: 0;
        }

        .navbar ul li {
            display: inline;
        }

        .navbar ul li a {
            text-decoration: none;
            color: #ffffff;
            font-weight: bold;
            padding: 10px 15px;
            transition: 0.3s;
        }

        .navbar ul li a:hover {
            color: #007bff;
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
<h2>Товары</h2>

<form class="search-sort" method="get">
    <input type="text" name="search" placeholder="Поиск..." value="<?= htmlspecialchars($search) ?>">
    <select name="sort">
        <option value="nazvanie" <?= $sort === 'nazvanie' ? 'selected' : '' ?>>По названию</option>
        <option value="price" <?= $sort === 'price' ? 'selected' : '' ?>>По цене</option>
    </select>
    <select name="order">
        <option value="ASC" <?= $order === 'ASC' ? 'selected' : '' ?>>По возрастанию</option>
        <option value="DESC" <?= $order === 'DESC' ? 'selected' : '' ?>>По убыванию</option>
    </select>
    <button type="submit">Применить</button>
</form>

<form method="post">
    <table>
        <thead>
            <tr>
                <th>Выбрать</th>
                <th>Название</th>
                <th>Цена</th>
                <th>Тип</th>
                <th>Поставщик</th>
                <th>Описание</th>
                <th>Количество</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($tovar = $result->fetch_assoc()): ?>
                <tr>
                    <td><input type="checkbox" name="selected[]" value="<?= $tovar['id_tovar'] ?>"></td>
                    <td><?= htmlspecialchars($tovar['nazvanie']) ?></td>
                    <td><?= $tovar['price'] ?> руб.</td>
                    <td><?= htmlspecialchars($tovar['type_name']) ?></td>
                    <td><?= htmlspecialchars($tovar['postavshik']) ?></td>
                    <td><?= htmlspecialchars($tovar['opisanie']) ?></td>
                    <td><input type="number" name="quantity[<?= $tovar['id_tovar'] ?>]" min="1" value="1" style="width:60px;"></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <button type="submit" class="submit-btn">Оплатить</button>
</form>

<footer class="footer">
    &copy; <?= date('Y') ?> Все права защищены.
</footer>

</body>
</html>
