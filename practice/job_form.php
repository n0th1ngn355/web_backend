<?php
include('isAuth.php');
try{
  include('connection.php');
  if($edit != 'NO'){
    $stmt = $db->prepare("select * from job where job_id=:uid");
    $stmt->execute(['uid'=>$uid]);
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $t = $stmt->fetchAll();


    $values = array();
    $values['name']  = $t[0]['name'];
  }
} catch(PDOException $e){
    die($e->getMessage());
}
?>
<script>
  function tryDelete(){
    $(document).ready(function(){
      $('#modal').modal('show');
    });
  }
  function deleteRec(){
    const url = 'queries/delete.php';
    const data = {
      id: [<?php echo $uid; ?>],
    };

    const xhr = new XMLHttpRequest();
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          const response = JSON.parse(xhr.responseText);
          console.log('Ответ сервера:', response);
          location.replace('./job.php');
        } else {
          console.error('Ошибка:', xhr.status);
        }
      }
    };
    xhr.send(JSON.stringify(data));
    
  }
</script>
<?php
?>
<a style='font-size:30px; text-decoration:none;' href='./job.php'>Назад</a>
<form method="post" autocomplete="off" id="form" class="col-12 col-md-9 m-auto row g-4">
          <div class="col-md-6 m-auto my-5">
            <label for="formName" class="form-label">Название</label>
            <input name="name" id="formName" class="form-control" placeholder="Введите название" required value="<?php print $values['name']; ?>">
          </div>

          <div class="row">
            <div class="col-6 d-flex <?php if($edit == "NO") echo 'm-auto';?>">          
                <input type="submit" id="submitBtn" class="btn btn-success m-auto" value="Сохранить">
            </div>
            <?php if($edit != 'NO'){?>
                <div class="col-6 d-flex">          
                    <button type="button" id="deleteBtn" class="btn btn-danger m-auto" onclick='tryDelete()'>Удалить</button>
                </div>
            <?php } ?>
          </div>
        </form>

<div class="modal fade" data-bs-backdrop='static' id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body d-flex flex-column text-center p-0">
        <h1>Вы уверены что хотите удалить эту запись?</h1>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Нет -_-</button>
        <button type="button" class="btn btn-danger" onclick="deleteRec()">Ага</button>
      </div>
    </div>
  </div>
</div>
