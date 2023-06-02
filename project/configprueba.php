<?php
$pdo = new PDO('mysql:host=localhost;dbname=dlif', 'dlif', '123');
$dsn = 'mysql:host=localhost;dbname=dlif';
$username = 'dlif';
$password = '123';
$options = [];

try {
    $conn = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

?>
