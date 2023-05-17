<?php 
include('isAuth.php');

$data = json_decode(file_get_contents('php://input'), true);

$uid = $data['id'];
try{
  include('connection.php');
  foreach ($uid as $v) {
    $stmt = $db->prepare("delete from application where application_id=:uid");
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