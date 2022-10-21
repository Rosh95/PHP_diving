<?php
session_start();
require 'functions.php';

$edit_user_id = $_GET['id'];
$username = $_POST['username'];
$job_title = $_POST['job_title'];
$phone = $_POST['phone'];
$address = $_POST['address'];

edit_information($username, $job_title, $phone, $address, $edit_user_id);
set_flash_message('success', 'Данные профиля успешно изменены!');
redirect_to('users.php');
exit();
