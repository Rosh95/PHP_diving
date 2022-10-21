<?php
session_start();
require 'functions.php';
$email = $_POST['email'];
$password = $_POST['password'];
$username = $_POST['username'];
$job_title = $_POST['job_title'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$status = $_POST['status'];
$status_in_english = array_keys($statuses, $status)[0];
$image = $_FILES['image'];
$vk = $_POST['vk'];
$telegram = $_POST['telegram'];
$instagram = $_POST['instagram'];

if (get_user_by_email($email)) {
  set_flash_message('danger', 'Этот эл. адрес уже занят другим пользователем.');
  redirect_to('create_user.php');
  exit();
}

$new_user_id = add_user($email, $password);
/* $new_user_id = get_user_by_email($email)['id'];
 */
edit_information($username, $job_title, $phone, $address, $new_user_id);
set_status($status_in_english, $new_user_id);

$type_file_name = pathinfo($_FILES['image']['name']);
$image_name = uniqid() . '.' . $type_file_name['extension'];
move_uploaded_file($_FILES['image']['tmp_name'], 'img/demo/avatars/' . $image_name);

upload_avatar($image_name, $new_user_id);
add_social_links($telegram, $instagram, $vk, $new_user_id);

set_flash_message('success', 'Добавлен новый пользователь!');
redirect_to('users.php');
exit();
