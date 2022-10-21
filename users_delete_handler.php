<?php
session_start();
require 'functions.php';

if (is_not_logged_in()) {
  redirect_to('page_login.php');
  exit();
}
$edit_user_id = $_GET['id'];
$authenticated_user_id = get_authenticated_user()['id'];
$edit_user = get_user_by_id($edit_user_id);

if (is_not_admin(get_authenticated_user()) && is_not_author($authenticated_user_id, $edit_user_id)) {
  set_flash_message('danger', 'Можно редактировать только свой профиль!');
  redirect_to('users.php');
  exit();
}

delete_user($edit_user_id);

if (is_author($authenticated_user_id, $edit_user_id)) {
  unset($_SESSION['user']);
  redirect_to('page_register.php');
  exit();
}
if (is_not_author($authenticated_user_id, $edit_user_id)) {
  set_flash_message('success', 'Профиль успешно удален!');
  redirect_to('users.php');
  exit();
}
