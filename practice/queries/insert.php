<?php 
include('../isAuth.php');
$entity = 'employee';
if(isset($_COOKIE['entity'])){
  $entity = $_COOKIE['entity'];
  if(!in_array($entity, ['employee', 'job', 'currency', 'rate', 'operation'])){
    $entity = 'employee';
    setcookie('entity', $entity, time()+3600);
  }
}
try{
  include('../connection.php');
switch ($entity) {
  case 'job':
    $stmt = $db->prepare("INSERT INTO job (name) VALUES (:name)");
    $stmt -> execute(['name'=>$_POST['name']]);
    header('Location: ./job.php');
    break;
  case 'currency':
    $stmt = $db->prepare("INSERT INTO currency (name,code) VALUES (:name,:code)");
    $stmt -> execute(['name'=>$_POST['name'], 'code'=>$_POST['code']]);
    header('Location: ./currency.php');
    break;
  case 'rate':
    $stmt = $db->prepare("INSERT INTO rate (currency_id,exchange_rate,rate_date) VALUES (:currency_id,:exchange_rate,:rate_date)");
    $stmt -> execute(['currency_id'=>$_POST['currency_id'], 'exchange_rate'=>$_POST['exchange_rate'],'rate_date'=>$_POST['rate_date']]);
    header('Location: ./rate.php');
    break;
  case 'operation':
    $stmt = $db->prepare("INSERT INTO operation (employee_id,currency_id,amount,exchanged_amount,operation_date) VALUES (:employee_id,:currency_id,:amount,:exchanged_amount,:operation_date)");
    $stmt -> execute(['employee_id'=>$_POST['employee_id'], 'currency_id'=>$_POST['currency_id'],'amount'=>$_POST['amount'],'exchanged_amount'=>$_POST['exchanged_amount'],'operation_date'=>$_POST['operation_date']]);
    header('Location: ./operation.php');
    break;
  default:
  $stmt = $db->prepare("INSERT INTO employee (name,email,phone,salary,job_id) VALUES (:name,:email,:phone,:salary,:job_id)");
  $stmt -> execute(['name'=>$_POST['name'], 'email'=>$_POST['email'],'phone'=>$_POST['phone'],'salary'=>$_POST['salary'],'job_id'=>$_POST['job_id']]);
  header('Location: ./employee.php');
    break;
}

}catch(PDOException $e){
  print('Error : ' . $e->getMessage());
  exit();
}
?>