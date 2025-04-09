<?php
session_start();

if (isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

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
    <title>Авторизация и регистрация</title>
    <link rel="stylesheet" href="auth.css">
</head>
<body>
    <div class="background"></div>
    <div class="container">
        <form action="signin.php" method="post">
            <label for="login">Логин</label>
            <input type="text" name="login" id="login" placeholder="Введите логин" required>
            
            <label for="password">Пароль</label>
            <input type="password" name="password" id="password" placeholder="Введите пароль" required>
            
            <label for="captcha">Капча</label>
            <p><?php echo "$num1 + $num2 = "; ?></p>
            <input type="number" name="captcha" id="captcha" placeholder="Ответ" required>
            
            <button type="submit">Войти</button>
            
            <p class="acc">У вас нет акаунта? <a href="register.php">Зарегистрируйтесь</a>!</p>
            
            <?php if (isset($_SESSION['message'])): ?>
                <p class="msg"><?php echo htmlspecialchars($_SESSION['message']); ?></p>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
