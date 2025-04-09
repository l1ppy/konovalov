<?php  
session_start();
require_once 'db.php';  

$login = $_POST['login'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';
$fio = $_POST['name'] ?? '';
$number = $_POST['tel'] ?? '';
$email = $_POST['email'] ?? '';  
$pasport = $_POST['pasport'] ?? '';  

if ($password === $confirm_password) {
    $uploadDir = 'uploads/';
    
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
        $fileName = time() . "_" . basename($_FILES['avatar']['name']);
        $filePath = $uploadDir . $fileName;
        
        if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $filePath)) {
            $_SESSION['message'] = 'Ошибка загрузки изображения!';
            header('Location: register.php');
            exit();
        }
    } else {
        $filePath = 'uploads/default_avatar.png';
    }

    $password = md5($password);

    $query = "INSERT INTO `client` (`fio`, `number`, `email`, `pasport`, `login`, `password`, `avatar`) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssssss', $fio, $number, $email, $pasport, $login, $password, $filePath); 


    if ($stmt->execute()) {
        $_SESSION['user'] = [
            'id_client' => $conn->insert_id,
            'fio' => $fio,
            'number' => $number,
            'email' => $email,  
            'pasport' => $pasport, 
            'login' => $login,
            'avatar' => $filePath
        ];
        unset($_SESSION['user']); 

        $_SESSION['message'] = 'Регистрация прошла успешно!';
        header('Location: login.php');
        exit();
    } else {
        $_SESSION['message'] = 'Ошибка при регистрации!';
        header('Location: register.php');
        exit();
    }

} 
?>
