<?php
include('../isAuth.php');
try{
    $stmt = $db->prepare("INSERT INTO employee (name,email,phone,salary,job_id) VALUES (:name,:email,:phone,:salary,:job_id)");
    $stmt -> execute(['name'=>$_POST['name'], 'email'=>$_POST['email'],'phone'=>$_POST['phone'],'salary'=>$_POST['salary'],'job_id'=>$_POST['job_id']]);
    header('Location: ./employee.php');
  } catch(PDOException $e){
      print('Error : ' . $e->getMessage());
      exit();
}
?>