
<?php
$conn = mysqli_connect("localhost", "root", "", "konovalov");

if (!$conn) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}
?>
