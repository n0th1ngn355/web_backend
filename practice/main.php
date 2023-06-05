<?php
include('style.php');
include('isAuth.php');
$entity = 'employee';
if(isset($_COOKIE['entity'])){
  $entity = $_COOKIE['entity'];
  if(!in_array($entity, ['employee', 'job', 'currency', 'rate', 'operation'])){
    $entity = 'employee';
    setcookie('entity', $entity, time()+3600);
  }
}else{
  setcookie('entity', $entity, time()+3600);
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  include('nav_panel.php');
if(!empty($_GET['id'])){
  if(isset($_COOKIE['saved']) && $_COOKIE['saved']==1){
    echo "<div class='d-flex flex-column m-auto'>";
    echo "<div class='col alert alert-success m-auto'>Данные сохранены</div>";
    echo "</div>";
  }
  setcookie('saved',NULL,1);
  $uid = $_GET['id'];
  // и здесь тоже
  include($form_template);
  exit;
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
      const url = 'queries/delete.php';
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
<?php
echo '<body>';
echo "<div class='col-12 col-lg-10 m-auto d-flex flex-column'>";
// switch ($entity) {
//   case 'employee':
//     include('emps_list.php');
//     break;
//   case 'job':
//     include('jobs_list.php');
//     break;
//   case 'currency':
//     include('currencies_list.php');
//     break;
//   case 'rate':
//     include('rates_list.php');
//     break;
//   case 'operation':
//     include('operations_list.php');
//     break;
//   default:
//     include('emps_list.php');
//     break;
// }
//include($list);
?>
<?php
try{
    include('connection.php');

    switch ($entity) {
      case 'job':
        include('queries/getJobs.php');
        break;
      case 'currency':
        include('queries/getCurrencies.php');
        break;
      case 'rate':
        include('queries/getCurrencies.php');
        $currencies = $result;
        include('queries/getRates.php');
        break;
      case 'operation':
        include('queries/getEmps.php');
        $emps = $result;
        include('queries/getCurrencies.php');
        $currencies = $result;
        include('queries/getOperations.php');
        break;
      default:
        include('queries/getJobs.php');
        $jobs = $result;
        include('queries/getEmps.php');
        break;
    }
    
    echo '<h1>Всего записей: '.count($result).' ';
?>
<button class='btn btn-secondary' onclick='location.href = "add_rec.php"'>Добавить</button></h1>
<div class='col-11 col-md-6 m-auto'>
  <input class="form-control" id="myInput" type="text" placeholder="Поиск..">
  <script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".list-group *").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>

<?php
  echo '</div></div>';
    echo "<div class='m-2 list-group col col-md-7'>";
    include('lists.php');
    echo "</div>";
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
    /// использовать здесь проверку
    include('queries/update.php');
    setcookie('changed',TRUE);
  } catch(PDOException $e){
      print('Error : ' . $e->getMessage());
      exit();
  }
  setcookie('saved',1);
  header('Refresh: 0');
}
?>