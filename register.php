<?php
session_start();



$num1 = rand(1, 10);
$num2 = rand(1, 10);
$captcha_result = $num1 + $num2;
$_SESSION['captcha'] = $captcha_result;

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="auth.css">
</head>
<body>
    <div class="background"></div>
    <div class="container">
        <form action="signup.php" method="post" enctype="multipart/form-data">
            <label for="fio">ФИО</label>
            <input type="text" name="name" id="fio" placeholder="Введите ФИО" required>

            <label for="tel">Номер телефона</label>
            <input type="text" name="tel" id="tel" placeholder="Введите номер телефона" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Введите email" required>

            <label for="pasport">Паспорт</label>
            <input type="text" name="pasport" id="pasport" placeholder="Введите паспортные данные" required>

            <label for="login">Логин</label>
            <input type="text" name="login" id="login" placeholder="Введите логин" required>

            <label for="password">Пароль</label>
            <input type="password" name="password" id="password" placeholder="Введите пароль" required>

            <label for="confirm_password">Подтвердите пароль</label>
            <input type="password" name="confirm_password" id="confirm_password" placeholder="Подтвердите пароль" required>

            <label for="captcha">Капча</label>
            <p><?php echo "$num1 + $num2 = "; ?></p>
            <input type="number" name="captcha" id="captcha" placeholder="Ответ" required>

            <label for="avatar">Аватар</label>
            <input type="file" name="avatar" id="avatar">

            <button type="submit">Зарегистрироваться</button>

            <p class="acc">Уже есть аккаунт? <a href="login.php">Войдите</a>!</p>

            <?php if (isset($_SESSION['message'])): ?>
                <p class="msg"><?php echo htmlspecialchars($_SESSION['message']); ?></p>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
