<?php
session_start();
require 'functions.php';
$email = $_POST['email'];
$password = $_POST['password'];

function login($email, $password)
{
  $user = get_user_by_email($email);

  if (empty($user)) {
    set_flash_message('danger', 'Введен не правильный логин или пароль');
    redirect_to('page_login.php');
    return false;
    exit();
  }
  if (!password_verify($password, $user['password'])) {
    set_flash_message('danger', 'Введен не правильный логин или пароль');
    redirect_to('page_login.php');
    return false;
    exit();
  }
  $_SESSION['user'] = ['email' => $user['email'], 'id' => $user['id'], 'role' => $user['role']];

  return true;
}

if (login($email, $password)) {
  redirect_to('users.php');
}
exit();
