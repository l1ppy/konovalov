<?php 
session_start();
require_once 'db.php';  

$login = $_POST['login'] ?? '';
$password = md5($_POST['password'] ?? '');
$user_captcha = $_POST['captcha'] ?? '';

if (!isset($_SESSION['captcha']) || (int)$user_captcha !== (int)$_SESSION['captcha']) {
    $_SESSION['message'] = 'Неверный ответ на капчу.';
    header('Location: login.php');
    exit();
}
unset($_SESSION['captcha']); 



$query = "SELECT * FROM `client` WHERE `login` = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $login); 
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {
    if ($password === $user['password']) {
        $_SESSION['user'] = [
            "id_client" => $user['id_client'],
            "fio" => $user['fio'],
            "number" => $user['number'],  
            "email" => $user['email'],   
            "pasport" => $user['pasport'], 
            "login" => $user['login'],
            "avatar" => $user['avatar']
        ];
        header('Location: index.php');
            exit();
    } 
} else {
    $_SESSION['message'] = 'Неверный логин или пароль';
    header('Location: login.php');
    exit();
}

?>
