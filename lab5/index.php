<?php

header('Content-Type: text/html; charset=UTF-8'); 
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $saved = FALSE;
  if (isset($_COOKIE['saved'])) {
    $saved = TRUE;
    setcookie('saved',NULL,1);
    if (isset($_COOKIE['changed'])) {
      $changed = TRUE;
      setcookie('changed',NULL,1);
    }else{
      $login = $_COOKIE['login'];
      $password = $_COOKIE['password'];
      setcookie('login',NULL,1);
      setcookie('password',NULL,1);
    }  // print('<center style="background-color:green;">Спасибо, результаты сохранены.</center>');
  }
  $auth = FALSE;
  if(session_start() && !empty($_SESSION['uid'])){
    $auth = TRUE;
  }
  
  if($auth && empty($_COOKIE['name'])){
    try{
      $user = 'u53011';
      $pass = '1234';
      $db = new PDO('mysql:host=localhost;dbname=u53011;', $user, $pass,
          [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
      // $user = 'postgres';
      // $pass = 'root';
      // $dsn = "pgsql:host=127.0.0.1;port=5432;dbname=u53011;";
      // $db = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
  
      $stmt = $db->prepare("select * from application where application_id=:uid");
      $stmt->execute(['uid'=>$_SESSION['uid']]);
      $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $t = $stmt->fetchAll();

      $stmt = $db->prepare("select s.sup_id from superpower s join application_superpower a on s.sup_id=a.sup_id where application_id=:uid");
      $stmt->execute(['uid'=>$_SESSION['uid']]);
      $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $t1 = $stmt->fetchAll();
      $sups = array();
      foreach($t1 as $value) { 
        array_push($sups,$value['sup_id']);
      }
      setcookie('yob',$t[0]['yob']);
      setcookie('name',$t[0]['name']);
      setcookie('email',$t[0]['email']);
      setcookie('sex',$t[0]['sex']);
      setcookie('num_of_limbs',$t[0]['num_of_limbs']);
      setcookie('biography',$t[0]['biography']);
      setcookie('superpowers',json_encode($sups));
      setcookie('policyCheckBox','on');
      $values = array();
      $values['yob']  = $t[0]['yob'];
      $values['name']  = $t[0]['name'];
      $values['email']  = $t[0]['email'];
      $values['sex']  = $t[0]['sex'];
      
      $values['num_of_limbs']  = $t[0]['num_of_limbs'];
      $values['biography']  = $t[0]['biography'];
      $values['superpowers']  = json_encode($sups);
      $values['policyCheckBox']  = 'on';

    } catch(PDOException $e){
        die($e->getMessage());
    }
  }else{
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
  }
  
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
  header('Location: .');
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

$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ#$%&';
function generate_string($input, $strength = 16) {
    $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }
    return $random_string;
}
if(session_start() && !empty($_SESSION['uid'])){
  try{
    $stmt = $db->prepare("UPDATE application SET name=:name,email=:email,yob=:yob,sex=:sex,num_of_limbs=:num_of_limbs,biography=:biography WHERE application_id=:uid ");
    $stmt -> execute(['uid'=>$_SESSION['uid'], 'name'=>$_POST['name'], 'email'=>$_POST['email'],'yob'=>$_POST['yob'],'sex'=>$_POST['sex'],'num_of_limbs'=>$_POST['num_of_limbs'],'biography'=>$_POST['biography']]);
    $stmt = $db->prepare("DELETE from application_superpower WHERE application_id=:uid");
    $stmt -> execute(['uid'=>$_SESSION['uid']]);
    foreach ($_POST['superpowers'] as $sup_id) {
      $stmt = $db->prepare("INSERT INTO application_superpower (application_id, sup_id) VALUES (:ap_id,:sup_id)");
      $stmt -> execute(['ap_id'=>$_SESSION['uid'], 'sup_id'=>$sup_id]);
    }
    $ap_id = $_SESSION['uid'];
    setcookie('changed',TRUE);
  } catch(PDOException $e){
      print('Error : ' . $e->getMessage());
      exit();
  }
}else{
  $login = generate_string($permitted_chars, 8);
  $password = generate_string($permitted_chars, 8);

  $ap_id = 0;
  try{
    $stmt = $db->prepare("INSERT INTO application (login, password, name,email,yob,sex,num_of_limbs,biography) VALUES (:login,:password,:name,:email,:yob,:sex,:num_of_limbs,:biography)");
    $stmt -> execute(['login'=>$login, 'password'=>password_hash($password,PASSWORD_DEFAULT), 'name'=>$_POST['name'], 'email'=>$_POST['email'],'yob'=>$_POST['yob'],'sex'=>$_POST['sex'],'num_of_limbs'=>$_POST['num_of_limbs'],'biography'=>$_POST['biography']]);
    $ap_id = $db->lastInsertId();
    foreach ($_POST['superpowers'] as $sup_id) {
      $stmt = $db->prepare("INSERT INTO application_superpower (application_id, sup_id) VALUES (:ap_id,:sup_id)");
      $stmt -> execute(['ap_id'=>$ap_id, 'sup_id'=>$sup_id]);
    }
  } catch(PDOException $e){
      print('Error : ' . $e->getMessage());
      exit();
  }
}

// setcookie('name',NULL,1);
// setcookie('email',NULL,1);
// setcookie('yob',NULL,1);
// setcookie('sex',NULL,1);
// setcookie('num_of_limbs',NULL,1);
// setcookie('biography',NULL,1);
// setcookie('superpowers',NULL,1);
// setcookie('policyCheckBox',NULL,1);
session_start();
$_SESSION['uid'] = $ap_id;
setcookie('saved',1);
setcookie('login',$login);
setcookie('password',$password);

header('Location: .');