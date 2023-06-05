<?php
include('isAuth.php');
try{
  include('connection.php');
  $values = array();

  if($edit != 'NO'){
    $stmt = $db->prepare("select * from rate where rate_id=:uid");
    $stmt->execute(['uid'=>$uid]);
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $t = $stmt->fetchAll();


    $values['currency_id']  = $t[0]['currency_id'];
    $values['rate_date']  = $t[0]['rate_date'];
    $values['exchange_rate']  = $t[0]['exchange_rate'];
  }else{
    
    $values['currency_id']  = '';
    $values['rate_date']  = '';
    $values['exchange_rate']  = '';
  }
  include('queries/getCurrencies.php');
  $currencies = $result;
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
          location.replace('./rate.php');
        } else {
          console.error('Ошибка:', xhr.status);
        }
      }
    };
    xhr.send(JSON.stringify(data));
    
  }

  function getFullTimestamp () {
  const pad = (n,s=2) => (`${new Array(s).fill(0)}${n}`).slice(-s);
  const d = new Date();
  
  return `${pad(d.getFullYear(),4)}-${pad(d.getMonth()+1)}-${pad(d.getDate())} ${pad(d.getHours())}:${pad(d.getMinutes())}:${pad(d.getSeconds())}.${pad(d.getMilliseconds(),3)}`;
}
  function setTime(){
    let t = document.getElementById('formRateDate');
    t.value = getFullTimestamp();
  }
</script>
<?php
?>
<a style='font-size:30px; text-decoration:none;' href='./rate.php'>Назад</a>
<form method="post" autocomplete="off" id="form" class="col-12 col-md-9 m-auto row g-4">

          <div class="col-md-6">
            <label for="currency" class="form-label">Валюта</label>
            <select name="currency_id" id="currency" class="form-select">
                <?php
                foreach($currencies as $currency) { 
                    echo '<option value="'.$currency['currency_id'].'"'.(($currency['currency_id']==$values['currency_id'])?'selected':'').'>'.$currency['name'].'</option>';
                }
                ?>
            </select>
          </div>
          
          <div class="col-md-6">
            <label for="formRateDate" class="form-label">Дата <button class='btn btn-primary' type="button" onclick="setTime()">Время</button></label>
            <input name="rate_date" id="formRateDate" type='text' class="form-control" placeholder="Введите" required value="<?php print $values['rate_date']; ?>">
          </div>

          <div class="col-md-6 m-auto my-5">
            <label for="formRate" class="form-label">Курс обмена</label>
            <input name="exchange_rate" id="formRate" class="form-control" type="number" step="any" placeholder="Введите курс" required value="<?php print $values['exchange_rate']; ?>">
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
