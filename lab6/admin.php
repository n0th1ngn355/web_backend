<?php
include('style.php');
include('isAuth.php');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

if(!empty($_GET['id'])){
  if(isset($_COOKIE['saved']) && $_COOKIE['saved']==1){
    echo "<div class='d-flex flex-column m-auto'>";
    echo "<div class='col alert alert-success m-auto'>Данные сохранены</div>";
    echo "</div>";
  }
  setcookie('saved',NULL,1);
  $uid = $_GET['id'];
  include('form.php');
}
else{
?>
<script>
    let sw = true;
  function DoNav(theUrl){
    let a = false;
    for (let na of document.getElementsByTagName('input')) {
        a |= na.checked;
    }
    if(!a)document.location.href = theUrl;
  }
  function selectAll(){
    for (let na of document.getElementsByTagName('input')) {
        na.checked=sw;
    }
    sw = !sw;
  }
  function tryDelete(){
    $(document).ready(function(){
      $('#modal').modal('show');
    });
  }
  function deleteRows(){
    let t = [];
    document.querySelectorAll('input:checked').forEach(element => {
      t.push(parseInt(element.value));
    });
    if(t.length != 0){
      const url = './delete.php';
      const data = {
        id: t,
      };
      const xhr = new XMLHttpRequest();
      xhr.open('POST', url, true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            console.log('Ответ сервера:', response);
            location.reload();
          } else {
            console.error('Ошибка:', xhr.status);
          }
        }
      };
      xhr.send(JSON.stringify(data));
    }else{
      location.reload();
    }
  }
</script>
<a class='btn btn-primary m-3' href='./'>Выйти</a>
<?php
echo '<body>';
echo "<div class='col-12 col-lg-10 m-auto d-flex flex-column'>";
  try{
    include('connection.php');
    // запрашиваем кол-во пользователей
    $stmt = $db->prepare('select count(*) from application;');
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $peps = $stmt->fetchColumn();

    // запрашиваем статистику по способностям
    $stmt = $db->prepare('select s.name, count(a_s.id) as count from application a join application_superpower a_s on a.application_id =a_s.application_id join superpower s on a_s.sup_id = s.sup_id group by s.name;');
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $sups = $stmt->fetchAll();
    
    // запрашиваем пользователей
    $stmt = $db->prepare("select application_id, name, login, email from application");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    echo '<h1>Всего записей: '.$peps.'</h1>';
    $m = max(array_column($sups, 'count'));
    echo '<div class="col-12 col-md-6 m-auto">';
    foreach($sups as $k=>$v) {
      echo '<div class="progress" role="progressbar">';
      $t = 100*$v['count']/$m;
      echo '<div class="progress-bar" style="width:'.$t.'%">'.$v['name'].' : '.$v['count'].'</div></div>';
      //echo '<h2>'.$v['name'].' : '.$v['count'].'</h2>';
    }
    echo '</div>';
    echo "<div class='m-2 list-group'>";
    foreach($stmt->fetchAll() as $k=>$v) {
      echo '<div class="d-flex m-1"><input class="form-check-input m-auto" style="margin-right: 5px !important; width:1.5em; height:1.5em;" type="checkbox" value="'.$v['application_id'].'">';
      echo '<a href="./admin.php?id='.$v['application_id'].'" class="list-group-item list-group-item-secondary rounded-4 list-group-item-action">';
      echo '<h3>'.htmlspecialchars($v['name']).'</h3><h5><i>login: </i><code>'.$v['login'].'</code> <i>email: </i><code>'.$v['email'].'</code></h5></a></div>';
    }
  } catch(PDOException $e){
    die($e->getMessage());
  }
  echo "</div>";

?>
<div class='m-auto'>
<button class='btn btn-primary m-auto' onclick='selectAll()'>Выделить все</button>
<button class='btn btn-danger m-auto' onclick='tryDelete()'>Удалить выделенное</button>
</div>

<div class="modal fade" data-bs-backdrop='static' id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body d-flex flex-column text-center p-0">
        <h1>Вы уверены что хотите удалить выделенное?</h1>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Нет -_-</button>
        <button type="button" class="btn btn-danger" onclick="deleteRows()">Ага</button>
      </div>
    </div>
  </div>
</div>

<?php 
}
}else{
  try{
    $uid = $_GET['id'];
    include('connection.php');
    $stmt = $db->prepare("UPDATE application SET name=:name,email=:email,yob=:yob,sex=:sex,num_of_limbs=:num_of_limbs,biography=:biography WHERE application_id=:uid ");
    $stmt -> execute(['uid'=>$uid, 'name'=>$_POST['name'], 'email'=>$_POST['email'],'yob'=>$_POST['yob'],'sex'=>$_POST['sex'],'num_of_limbs'=>$_POST['num_of_limbs'],'biography'=>$_POST['biography']]);
    $stmt = $db->prepare("DELETE from application_superpower WHERE application_id=:uid");
    $stmt -> execute(['uid'=>$uid]);
    foreach ($_POST['superpowers'] as $sup_id) {
      $stmt = $db->prepare("INSERT INTO application_superpower (application_id, sup_id) VALUES (:ap_id,:sup_id)");
      $stmt -> execute(['ap_id'=>$uid, 'sup_id'=>$sup_id]);
    }
    $ap_id = $uid;
    setcookie('changed',TRUE);
  } catch(PDOException $e){
      print('Error : ' . $e->getMessage());
      exit();
  }
  setcookie('saved',1);
  header('Refresh: 0');
}
?>