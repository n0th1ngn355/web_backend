<?php
include('style.php');
include('isAuth.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $entity = 'employee';
    if(isset($_COOKIE['entity'])){
        $entity = $_COOKIE['entity'];
        if(!in_array($entity, ['employee', 'job', 'currency', 'rate', 'operation'])){
            $entity = 'employee';
            setcookie('entity', $entity, time()+3600);
        }
    }

    $edit = 'NO';
    include('nav_panel.php');
    switch ($entity) {
        case 'job':
            include('job_form.php');
            break;
        case 'currency':
            include('currency_form.php');
            break;
        case 'rate':
            include('rate_form.php');
            break;
        case 'operation':
            include('operation_form.php');
            break;
        default:
            include('employee_form.php');
            break;
      }
}else{
    try{
        include('connection.php');
        include('queries/insert.php');
      } catch(PDOException $e){
          print('Error : ' . $e->getMessage());
          exit();
      }
      header('Location: ./'.$entity.'.php');
      exit;
}
?>