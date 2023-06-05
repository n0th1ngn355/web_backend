<?php
include('isAuth.php');
try{
  include('connection.php');
  $values = array();

  if($edit != 'NO'){
    $stmt = $db->prepare("select * from currency where currency_id=:uid");
    $stmt->execute(['uid'=>$uid]);
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $t = $stmt->fetchAll();

    $values['name']  = $t[0]['name'];
    $values['code']  = $t[0]['code'];
  }else{
    $values['name']  = '';
    $values['code']  = '';
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
          location.replace('./currency.php');
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
<a style='font-size:30px; text-decoration:none;' href='./currency.php'>Назад</a>
<form method="post" autocomplete="off" id="form" class="col-12 col-md-9 m-auto row g-4">
          <div class="col-md-6 my-5">
            <label for="formName" class="form-label">Название</label>
            <input name="name" id="formName" class="form-control" placeholder="Введите название" required value="<?php print $values['name']; ?>">
          </div>

          <div class="col-md-6 my-5">
            <label for="formName" class="form-label">Код</label>
            <input name="code" id="formCode" class="form-control" placeholder="Введите код" required value="<?php print $values['code']; ?>">
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
