<?php
session_start();
require 'functions.php';

$edit_user_id = $_GET['id'];
$email = $_POST['email'];
$password = $_POST['password'];
$is_same_email = get_user_by_id($edit_user_id)['email'] === $email;

if ($is_same_email) {
  edit_credentials($edit_user_id, $email, $password);
  set_flash_message('success', 'Данные профиля успешно изменены!');
  redirect_to('users.php');
  exit();
}

if (get_user_by_email($email) && !$is_same_email) {
  set_flash_message('danger', 'Этот эл. адрес уже занят другим пользователем.');
  redirect_to('users.php');
  exit();
}

edit_credentials($edit_user_id, $email, $password);
set_flash_message('success', 'Данные профиля успешно изменены!');
redirect_to('users.php');
exit();
