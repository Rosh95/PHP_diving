<?php
session_start();
require 'functions.php';

$edit_user_id = $_GET['id'];
$image = $_FILES['image'];
get_user_by_id($edit_user_id)['image'];

if (has_image($edit_user_id)) {
  unlink(get_user_by_id($edit_user_id)['image']);
}
$type_file_name = pathinfo($_FILES['image']['name']);
$image_name = uniqid() . '.' . $type_file_name['extension'];
move_uploaded_file($_FILES['image']['tmp_name'], 'img/demo/avatars/' . $image_name);
upload_avatar($image_name, $edit_user_id);

set_flash_message('success', 'Данные профиля успешно изменены!');
redirect_to('users.php');
exit();
