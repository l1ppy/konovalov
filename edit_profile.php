<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user']['id_client'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fio = $_POST['fio'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $pasport = $_POST['pasport'];
    $login = $_POST['login'];

    if (!empty($_FILES['avatar']['name'])) {
        $avatar_path = "uploads/" . basename($_FILES["avatar"]["name"]);
        move_uploaded_file($_FILES["avatar"]["tmp_name"], $avatar_path);
    } else {
        $avatar_path = $_POST['current_avatar'];
    }

    $query = "UPDATE client SET fio=?, number=?, email=?, pasport=?, login=?, avatar=? WHERE id_client=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssssi", $fio, $number, $email, $pasport, $login, $avatar_path, $user_id);
    mysqli_stmt_execute($stmt);

    $_SESSION['message'] = "Данные успешно обновлены!";
    header("Location: profile.php");
    exit();
}

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
    <title>Редактирование профиля</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .edit-container {
            max-width: 500px;
            margin: 30px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 2px 2px 15px rgba(0, 0, 0, 0.1);
        }
        .edit-form label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        .edit-form input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .edit-avatar {
            text-align: center;
        }
        .edit-avatar img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #007bff;
            margin-bottom: 10px;
        }
        .btn-save {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .btn-save:hover {
            background: #0056b3;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
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

<div class="edit-container">
    <h2>Редактирование профиля</h2>
    <form action="edit_profile.php" method="post" enctype="multipart/form-data" class="edit-form">
        <div class="edit-avatar">
            <img src="<?= $user['avatar'] ?: 'uploads/default-avatar.png'; ?>" alt="Аватар">
            <input type="file" name="avatar" accept="image/*">
            <input type="hidden" name="current_avatar" value="<?= $user['avatar']; ?>">
        </div>
        
        <label for="fio">ФИО:</label>
        <input type="text" name="fio" value="<?= htmlspecialchars($user['fio']) ?>" required>

        <label for="number">Телефон:</label>
        <input type="text" name="number" value="<?= htmlspecialchars($user['number']) ?>" required>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <label for="pasport">Паспорт:</label>
        <input type="text" name="pasport" value="<?= htmlspecialchars($user['pasport']) ?>" required>

        <label for="login">Логин:</label>
        <input type="text" name="login" value="<?= htmlspecialchars($user['login']) ?>" required>

        <button type="submit" class="btn-save">Сохранить изменения</button>
    </form>
    <a href="profile.php" class="back-link">Вернуться в профиль</a>
</div>

<footer class="footer">
    <p>&copy; 2025 Магазин. Все права защищены.</p>
</footer>

</body>
</html>
