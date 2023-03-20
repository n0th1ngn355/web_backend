<?php

header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (!empty($_GET['save'])) {
    print('Спасибо, результаты сохранены.');
    setcookie('name',NULL);
    setcookie('email',NULL);
    setcookie('yob',NULL);
    setcookie('sex',NULL);
    setcookie('num_of_limbs',NULL);
    setcookie('biography',NULL);
    setcookie('superpowers',NULL);
    setcookie('policyCheckBox',NULL);
  }
  include('form.php');
  exit();
}


setcookie('name',$_POST['name']);
setcookie('email',$_POST['email']);
setcookie('yob',$_POST['yob']);
setcookie('sex',$_POST['sex']);
setcookie('num_of_limbs',$_POST['num_of_limbs']);
setcookie('biography',$_POST['biography']);
if(empty($_POST['policyCheckBox']))
  setcookie('policyCheckBox','');
else setcookie('policyCheckBox', $_POST['policyCheckBox']);
if(!empty($_POST['superpowers']))
  setcookie('superpowers', json_encode($_POST['superpowers']) );

$errors = FALSE;
if (empty($_POST['name'])) {
  print('Заполните имя.<br/>');
  $errors = TRUE;
}

if (empty($_POST['email'])) {
  print('Заполните email.<br/>');
  $errors = TRUE;
}else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  print('Неверный email.<br/>');
  $errors = TRUE;
}

if (empty($_POST['yob']) || !is_numeric($_POST['yob']) || !preg_match('/^\d+$/', $_POST['yob'])) {
  print('Заполните год.<br/>');
  $errors = TRUE;
}

if(empty($_POST['superpowers'])){
  print('Выберите хотя бы 1 суперспособность.<br/>');
  $errors = TRUE;
}
if(empty($_POST['policyCheckBox'])){
  print('Необходимо подтвердить ознакомление с контрактом.<br/>');
  $errors = TRUE;
}

if ($errors) {
  exit();
}


$user = 'u53011';
$pass = '1234';
$db = new PDO('mysql:host=localhost;dbname=u53011', $user, $pass,
  [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

// Подготовленный запрос. Не именованные метки.
// try {
//   $stmt = $db->prepare("INSERT INTO application SET name = ?");
//   $stmt->execute([$_POST['fio']]);
// }
// catch(PDOException $e){
//   print('Error : ' . $e->getMessage());
//   exit();
// }

//  stmt - это "дескриптор состояния".
 
//  Именованные метки.
$stmt = $db->prepare("INSERT INTO application VALUES (:name,:email,:yob,:sex,:num_of_limbs,:biography)");
$stmt -> execute(['name'=>$_POST['name'], 'email'=>$_POST['email'],'yob'=>$_POST['yob'],'sex'=>$_POST['sex'],'num_of_limbs'=>$_POST['num_of_limbs'],'biography'=>$_POST['biography'],]);
 
//Еще вариант
/*$stmt = $db->prepare("INSERT INTO users (firstname, lastname, email) VALUES (:firstname, :lastname, :email)");
$stmt->bindParam(':firstname', $firstname);
$stmt->bindParam(':lastname', $lastname);
$stmt->bindParam(':email', $email);
$firstname = "John";
$lastname = "Smith";
$email = "john@test.com";
$stmt->execute();
*/

// Делаем перенаправление.
// Если запись не сохраняется, но ошибок не видно, то можно закомментировать эту строку чтобы увидеть ошибку.
// Если ошибок при этом не видно, то необходимо настроить параметр display_errors для PHP.
header('Location: ?save=1');
