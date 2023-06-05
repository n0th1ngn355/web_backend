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
$query = '';
switch ($entity) {
  case 'employee':
    $query = "delete from employee where employee_id=:uid";
    break;
  case 'job':
    $query = "delete from job where job_id=:uid";
    break;
  case 'currency':
    $query = "delete from currency where currency_id=:uid";
    break;
  case 'rate':
    $query = "delete from rate where rate_id=:uid";
    break;
  case 'operation':
    $query = "delete from operation where operation_id=:uid";
    break;
  default:
  $query = "delete from employee where employee_id=:uid";
    break;
}

$data = json_decode(file_get_contents('php://input'), true);

$uid = $data['id'];
try{
  include('../connection.php');

  foreach ($uid as $v) {
    $stmt = $db->prepare($query);
    $stmt->execute(['uid'=>$v]);
  }
}catch(PDOException $e){
    die($e->getMessage());
}
$response = array(
    'status' => 'success',
    'message' => 'Данные успешно обновлены'
  );
  
  header('Content-Type: application/json');
  echo json_encode($response);
?>