<?php

function get_user_by_email($email)
{
  $pdo = new PDO('mysql:host=localhost;dbname=my_project', 'root', '');
  $sql = 'SELECT * FROM users_project_one WHERE email=:email';
  $statement = $pdo->prepare($sql);
  $statement->execute(['email' => $email]);
  $result = $statement->fetch(PDO::FETCH_ASSOC);
  return $result;
}
function add_user($email, $password)
{
  $pdo = new PDO('mysql:host=localhost;dbname=my_project', 'root', '');
  $password_hash = password_hash($password, PASSWORD_DEFAULT);
  $sql = 'INSERT INTO users_project_one (email, password) VALUES (:email,:password)';
  $statement = $pdo->prepare($sql);
  $statement->execute(['email' => $email, 'password' => $password_hash]);
  $user_id = get_user_by_email($email)['id'];
  return $user_id;
}
function set_flash_message($name, $message)
{
  $_SESSION[$name] = $message;
}

function display_flash_message($name)
{
  if (isset($_SESSION[$name])) {
    echo "<div class=\"alert alert-{$name} text-dark\" role=\"alert\"><strong>Уведомление! </strong>{$_SESSION[$name]} </div>";
    unset($_SESSION[$name]);
  }
}

function redirect_to($path)
{
  return header("Location: {$path}");
}

function is_not_logged_in()
{
  if (isset($_SESSION['user'])) {
    return false;
  }
  return true;
}
function get_users()
{
  $pdo = new PDO('mysql:host=localhost;dbname=my_project', 'root', '');
  $sql = 'SELECT * FROM users_project_one';
  $statement = $pdo->prepare($sql);
  $statement->execute();
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

function get_authenticated_user()
{
  $current_user_email = $_SESSION['user']['email'];
  return get_user_by_email($current_user_email);
}
function is_admin($user)
{
  if ($user['role'] === 'admin') {
    return true;
  }
  return false;
}
function is_not_admin($user)
{
  return !is_admin($user);
}

function is_equal($user, $current_user)
{
  if ($user['id'] === $current_user['id']) {
    return true;
  }
  return false;
}
function edit_information($username, $job_title, $phone, $address, $user_id)
{
  $pdo = new PDO('mysql:host=localhost;dbname=my_project', 'root', '');
  $sql =
    'UPDATE `users_project_one` SET `username` = :username, `job_title` = :job_title, `phone` = :phone, `address` = :address   WHERE `id`=:user_id';
  $statement = $pdo->prepare($sql);
  $statement->execute([
    'username' => $username,
    'job_title' => $job_title,
    'phone' => $phone,
    'address' => $address,
    'user_id' => $user_id,
  ]);
}

function set_status($status, $user_id)
{
  $pdo = new PDO('mysql:host=localhost;dbname=my_project', 'root', '');
  $sql = 'UPDATE `users_project_one` SET `status` = :status  WHERE `id`=:user_id';
  $statement = $pdo->prepare($sql);
  $statement->execute([
    'status' => $status,
    'user_id' => $user_id,
  ]);
}
function upload_avatar($image, $user_id)
{
  $pdo = new PDO('mysql:host=localhost;dbname=my_project', 'root', '');
  $sql = 'UPDATE `users_project_one` SET `image` = :image  WHERE `id`=:user_id';
  $statement = $pdo->prepare($sql);
  $statement->execute(['image' => 'img/demo/avatars/' . $image, 'user_id' => $user_id]);
}

function add_social_links($telegram, $instagram, $vk, $user_id)
{
  $pdo = new PDO('mysql:host=localhost;dbname=my_project', 'root', '');
  $sql = 'UPDATE `users_project_one` SET `telegram` = :telegram, `instagram` = :instagram, `vk` = :vk   WHERE `id`=:user_id';
  $statement = $pdo->prepare($sql);
  $statement->execute([
    'telegram' => $telegram,
    'instagram' => $instagram,
    'vk' => $vk,
    'user_id' => $user_id,
  ]);
}
function is_author($logged_user_id, $edit_user_id)
{
  if ($logged_user_id === $edit_user_id) {
    return true;
  }
  return false;
}
function is_not_author($logged_user_id, $edit_user_id)
{
  return !is_author($logged_user_id, $edit_user_id);
}

function get_user_by_id($user_id)
{
  $pdo = new PDO('mysql:host=localhost;dbname=my_project', 'root', '');
  $sql = 'SELECT * FROM users_project_one WHERE id=:id';
  $statement = $pdo->prepare($sql);
  $statement->execute(['id' => $user_id]);
  $result = $statement->fetch(PDO::FETCH_ASSOC);
  return $result;
}

function edit_credentials($user_id, $email, $password)
{
  $pdo = new PDO('mysql:host=localhost;dbname=my_project', 'root', '');
  $password_hash = password_hash($password, PASSWORD_DEFAULT);
  $sql = 'UPDATE `users_project_one` SET `email` = :email, `password` = :password   WHERE `id`=:user_id';
  $statement = $pdo->prepare($sql);
  $statement->execute([
    'email' => $email,
    'password' => $password_hash,
    'user_id' => $user_id,
  ]);
}

$statuses = [
  'online' => 'Онлайн',
  'away' => 'Отошел',
  'unavailable' => 'Не беспокоить',
];

function has_image($user_id)
{
  if (get_user_by_id($user_id)['image']) {
    return true;
  }
  return false;
}

function delete_user($user_id)
{
  if (has_image($user_id)) {
    unlink(get_user_by_id($user_id)['image']);
  }
  $pdo = new PDO('mysql:host=localhost;dbname=my_project', 'root', '');
  $sql = 'DELETE FROM `users_project_one` WHERE  `id`=:user_id';
  $statement = $pdo->prepare($sql);
  $statement->execute([
    'user_id' => $user_id,
  ]);
}
