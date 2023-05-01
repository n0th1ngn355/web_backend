<?php

header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $saved = FALSE;
  if (isset($_COOKIE['saved'])) {
    $saved = TRUE;
    setcookie('saved',NULL,1);
    // print('<center style="background-color:green;">Спасибо, результаты сохранены.</center>');
  }
  $errors = array();
  if (isset($_COOKIE['error_name'])){
    $errors['name'] = $_COOKIE['error_name'];
    setcookie('error_name',NULL,1);
  }
  if (isset($_COOKIE['error_email'])){
    $errors['email'] = $_COOKIE['error_email'];
    setcookie('error_email',NULL,1);
  }
  if (isset($_COOKIE['error_yob'])){
    $errors['yob'] = $_COOKIE['error_yob'];
    setcookie('error_yob',NULL,1); 
  }
  if (isset($_COOKIE['error_policyCheckBox'])){
    $errors['policyCheckBox'] = $_COOKIE['error_policyCheckBox'];
    setcookie('error_policyCheckBox',NULL,1);

  }
  if (isset($_COOKIE['error_superpowers'])){
    $errors['superpowers'] = $_COOKIE['error_superpowers'];
    setcookie('error_superpowers',NULL,1);
  }
  $values = array();
  $values['yob']  = empty($_COOKIE['yob']) ? "" : $_COOKIE['yob'];
  $values['name']  = empty($_COOKIE['name'])? "" : $_COOKIE['name']; 
  $values['email']  = empty($_COOKIE['email']) ? "" : $_COOKIE['email'];
  $values['sex']  = isset($_COOKIE['sex'])?$_COOKIE['sex']:1 ;
  $values['num_of_limbs']  = isset($_COOKIE['num_of_limbs'])?$_COOKIE['num_of_limbs']:4 ;
  $values['biography']  = empty($_COOKIE['biography']) ? "" : $_COOKIE['biography'];
  $values['superpowers']  = empty($_COOKIE['superpowers']) ? "" : $_COOKIE['superpowers'];
  $values['policyCheckBox']  = empty($_COOKIE['policyCheckBox']) ? 0 : $_COOKIE['policyCheckBox'];

  include('form.php');
  exit();
}


setcookie('yob',$_POST['yob']);
setcookie('name',$_POST['name']); 
setcookie('email',$_POST['email']);
setcookie('sex',$_POST['sex']);
setcookie('num_of_limbs',$_POST['num_of_limbs']);
setcookie('biography',$_POST['biography']);
if(empty($_POST['policyCheckBox']))
  setcookie('policyCheckBox','');
else setcookie('policyCheckBox', $_POST['policyCheckBox']);
if(!empty($_POST['superpowers']))
  setcookie('superpowers', json_encode($_POST['superpowers']) );

$errors = array();
if (empty($_POST['name'])) {
  $errors['name'] = 'Заполните имя';
}

if (empty($_POST['email'])) {
  $errors['email'] = 'Заполните email';
}else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  $errors['email'] = 'Неверный email';
}

// if (empty($_POST['yob']) || !is_numeric($_POST['yob']) || !preg_match('/^\d+$/', $_POST['yob'])) {
//   $errors['yob'] = 'Заполните год';
// }

if(empty($_POST['superpowers'])){
  $errors['superpowers'] = 'Выберите хотя бы 1 суперспособность';
}
if(empty($_POST['policyCheckBox'])){
  $errors['policyCheckBox'] = 'Необходимо подтвердить ознакомление с контрактом';
}
if ($errors) {
  foreach ($errors as $key => $value) {
    setcookie('error_'.$key, $value);
  }
  header('Location: /lab4');
  exit();
}


try{
  $user = 'u53011';
  $pass = '1234';
  $db = new PDO('mysql:host=localhost;dbname=u53011;', $user, $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch(PDOException $e){
  die($e->getMessage());
}

// try {
//   $user = 'postgres';
//   $pass = 'root';
// 	$dsn = "pgsql:host=127.0.0.1;port=5432;dbname=u53011;";
// 	$db = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
// } catch (PDOException $e) {
// 	die($e->getMessage());
// } 


try{
  $stmt = $db->prepare("INSERT INTO application (name,email,yob,sex,num_of_limbs,biography) VALUES (:name,:email,:yob,:sex,:num_of_limbs,:biography)");
  $stmt -> execute(['name'=>$_POST['name'], 'email'=>$_POST['email'],'yob'=>$_POST['yob'],'sex'=>$_POST['sex'],'num_of_limbs'=>$_POST['num_of_limbs'],'biography'=>$_POST['biography']]);
  $ap_id = $db->lastInsertId();
  foreach ($_POST['superpowers'] as $sup_id) {
    $stmt = $db->prepare("INSERT INTO application_superpower (application_id, sup_id) VALUES (:ap_id,:sup_id)");
    $stmt -> execute(['ap_id'=>$ap_id, 'sup_id'=>$sup_id]);
  }
} catch(PDOException $e){
    print('Error : ' . $e->getMessage());
    exit();
}
 
setcookie('name',NULL,1);
setcookie('email',NULL,1);
setcookie('yob',NULL,1);
setcookie('sex',NULL,1);
setcookie('num_of_limbs',NULL,1);
setcookie('biography',NULL,1);
setcookie('superpowers',NULL,1);
setcookie('policyCheckBox',NULL,1);
setcookie('saved',1);
header('Location: /lab4');