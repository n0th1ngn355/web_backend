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
    $stmt = $db->prepare("UPDATE job SET name=:name WHERE job_id=:uid ");
    $stmt -> execute(['uid'=>$uid, 'name'=>$_POST['name']]);
    break;
  case 'currency':
    $stmt = $db->prepare("UPDATE currency SET name=:name, code=:code WHERE currency_id=:uid ");
    $stmt -> execute(['uid'=>$uid, 'name'=>$_POST['name'], 'code'=>$_POST['code']]);
    break;
  case 'rate':
    $stmt = $db->prepare("UPDATE rate SET currency_id=:currency_id, exchange_rate=:exchange_rate, rate_date=:rate_date WHERE rate_id=:uid ");
    $stmt -> execute(['uid'=>$uid, 'currency_id'=>$_POST['currency_id'],'exchange_rate'=>$_POST['exchange_rate'],'rate_date'=>$_POST['rate_date']]);
    break;
  case 'operation':
    $stmt = $db->prepare("UPDATE operation SET employee_id=:employee_id, currency_id=:currency_id, amount=:amount, exchanged_amount=:exchanged_amount, operation_date=:operation_date WHERE operation_id=:uid");
    $stmt -> execute(['uid'=>$uid, 'employee_id'=>$_POST['employee_id'], 'currency_id'=>$_POST['currency_id'],'amount'=>$_POST['amount'],'exchanged_amount'=>$_POST['exchanged_amount'],'operation_date'=>$_POST['operation_date']]);
    break;
  default:
  $stmt = $db->prepare("UPDATE employee SET name=:name, job_id=:job_id, salary=:salary, email=:email, phone=:phone WHERE employee_id=:uid ");
  $stmt -> execute(['uid'=>$uid, 'name'=>$_POST['name'], 'job_id'=>$_POST['job_id'],'salary'=>$_POST['salary'],'email'=>$_POST['email'],'phone'=>$_POST['phone']]);
    break;
}

}catch(PDOException $e){
    die($e->getMessage());
}
?>