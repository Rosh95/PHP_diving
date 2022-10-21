<?php
session_start();
require 'functions.php';

$edit_user_id = $_GET['id'];
$status = $_POST['status'];
$status_in_english = array_keys($statuses, $status)[0];

set_status($status_in_english, $edit_user_id);
set_flash_message('success', 'Данные профиля успешно изменены!');
redirect_to('users.php');
exit();
