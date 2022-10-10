<?php 
session_start();
$email = $_POST['email'];
$password = $_POST['password'];
$password_hash = password_hash($password, PASSWORD_DEFAULT);

$pdo = new PDO('mysql:host=localhost;dbname=my_project', 'root', '');
$sql = "SELECT * FROM project_one WHERE email=:email"; 
$statement = $pdo->prepare($sql);
$statement->execute(['email' => $email]);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);

if(!empty($result)){
    $_SESSION['error'] = 'Этот эл. адрес уже занят другим пользователем.';
    header("Location: page_register.php");
    exit;
};

$sql = "INSERT INTO project_one (email, password) VALUES (:email,:password)";
$statement = $pdo->prepare($sql);
$statement->execute(['email' => $email, 'password' => $password_hash]);

$_SESSION['success'] = "Регистрация прошла успешно!";
header("Location: page_login.php");
exit();
