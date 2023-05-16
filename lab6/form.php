<?php
try{
  include('connection.php');
  $stmt = $db->prepare("select * from application where application_id=:uid");
  $stmt->execute(['uid'=>$uid]);
  $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
  $t = $stmt->fetchAll();

  $stmt = $db->prepare("select s.sup_id from superpower s join application_superpower a on s.sup_id=a.sup_id where application_id=:uid");
  $stmt->execute(['uid'=>$uid]);
  $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
  $t1 = $stmt->fetchAll();
  $sups = array();
  foreach($t1 as $value) { 
    array_push($sups,$value['sup_id']);
  }
  $values = array();
  $values['yob']  = $t[0]['yob'];
  $values['name']  = $t[0]['name'];
  $values['email']  = $t[0]['email'];
  $values['sex']  = $t[0]['sex'];
  
  $values['num_of_limbs']  = $t[0]['num_of_limbs'];
  $values['biography']  = $t[0]['biography'];
  $values['superpowers']  = json_encode($sups);
  $values['policyCheckBox']  = 'on';

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
  function deleteUser(){
    alert('тут должны удаляться строки');
  }
</script>
<a style='font-size:30px; text-decoration:none;' href='./admin.php'>Назад</a>
<form method="post" autocomplete="off" id="form" novalidate class="col-12 col-md-9 m-auto row g-4">
          <div class="col-md-6">
            <label for="formName" class="form-label">Имя</label>
            <input name="name" id="formName" class="form-control" placeholder="Введите имя" value="<?php print $values['name']; ?>">
          </div>
          <div class="col-md-6">
            <label for="formEmail" class="form-label">Email</label>
            <input name="email" id="formEmail" class="form-control" type="email" placeholder="Введите почту" value="<?php print $values['email']; ?>">
          </div>
          
          <div class="col-md-6">
            <label for="year" class="form-label">Год рождения</label>
            <select name="yob" id="year" class="form-select">
            <?php 
              if(!empty($values['yob'])){
                for ($i = 2023; $i >= 1900; $i--) {
                  if($i == $values['yob'])
                    printf('<option value="%d" selected>%d год</option>', $i, $i);
                  else
                    printf('<option value="%d">%d год</option>', $i, $i);
                }
              }else{
                for ($i = 2023; $i >= 1900; $i--) {
                    printf('<option value="%d">%d год</option>', $i, $i);
                }
              }
              ?>
            </select>
          </div>

          <div class="col-md-6 d-flex justify-content-center">

            <div class="col-6 m-auto row">
              <label class="form-label">Пол</label>
              <div class="col-6 ">
                <input class="form-check-input" type="radio" name="sex" value="1" <?php 
              if($values['sex']==1)
                echo 'checked';
              ?> id="M">
                <label class="form-check-label" for="M">М</label>
              </div>
              <div class="col-6">
                <input class="form-check-input" type="radio" name="sex" value="0" <?php 
              if($values['sex']==0)
                echo 'checked';
              ?> id="ZH">
                <label class="form-check- label" for="ZH">Ж</label>
              </div>
            </div>
            
            <div class="col-6 m-auto row">
              <label class="form-label">Количество конечностей</label>
              <div class="col-6 col-md-2">
                <input class="form-check-input" type="radio" name="num_of_limbs" value="0" <?php 
              if($values['num_of_limbs']==0)echo 'checked'; ?> id="0">
                <label class="form-check-label" for="0">0</label>
              </div>
              <div class="col-6 col-md-2">
                <input class="form-check-input" type="radio" name="num_of_limbs" value="1" <?php 
              if($values['num_of_limbs']==1)echo 'checked'; ?> id="1">
                <label class="form-check-label" for="1">1</label>
              </div>
              <div class="col-6 col-md-2">
                <input class="form-check-input" type="radio" name="num_of_limbs" value="2" <?php 
              if($values['num_of_limbs']==2)echo 'checked'; ?> id="2">
                <label class="form-check-label" for="2">2</label>
              </div>
              <div class="col-6 col-md-2">
                <input class="form-check-input" type="radio" name="num_of_limbs" value="3" <?php 
              if($values['num_of_limbs']==3)echo 'checked'; ?> id="3">
                <label class="form-check-label" for="3">3</label>
              </div>
              <div class="col-6 col-md-2">
                <input class="form-check-input" type="radio" name="num_of_limbs" value="4" 
                <?php 
                  if($values['num_of_limbs']==4)echo 'checked';
              ?>  id="4">
                <label class="form-check-label" for="4">4</label>
              </div>
              <div class="col-6 col-md-2">
                <input class="form-check-input" type="radio" name="num_of_limbs" value="5" <?php 
              if($values['num_of_limbs']==5)echo 'checked'; ?> id="5">
                <label class="form-check-label" for="5">5</label>
              </div>
            </div>

          </div>

          <div class="col-12">
            <label for="superpowers" class="form-label">Сверхспособности</label>
            <select name="superpowers[]" id="superpowers" multiple="multiple" class="form-select">
              <?php
                $ar = array();
                if(!empty($values['superpowers']))
                  $ar = json_decode($values['superpowers']);
               ?>
              <option value="1" <?php if(in_array(1,$ar)) echo 'selected' ?>>бессмертие</option>
              <option value="2" <?php if(in_array(2,$ar)) echo 'selected' ?>>прохождение сквозь стены</option>
              <option value="3" <?php if(in_array(3,$ar)) echo 'selected' ?>>левитация</option>
            </select>
          </div>

          <div class="col-12">
            <label for="biography" class="form-label">Биография</label>
            <textarea id="biography" class="form-control" name="biography" placeholder="Введите биографию"><?php
              if(!empty($values['biography']))
                printf($values['biography']);
               ?></textarea>
          </div>
          
          <div class="col-6 d-flex">          
            <input type="submit" id="submitBtn" class="btn btn-success m-auto" value="Отправить">
          </div>
          <div class="col-6 d-flex">          
            <button type="button" id="deleteBtn" class="btn btn-danger m-auto" onclick='tryDelete()'>Удалить</button>
          </div>
        </form>

<div class="modal fade" data-bs-backdrop='static' id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body d-flex flex-column text-center p-0">
        <h1>Вы уверены что хотите удалить этого пользователя?</h1>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Нет -_-</button>
        <button type="button" class="btn btn-danger" onclick="deleteUser()">Ага</button>
      </div>
    </div>
  </div>
</div>
<!-- <form method="post" action='./delete.php' autocomplete="off" id="form" novalidate class="col-12 col-md-9 m-auto row g-4">
          <input type="hidden" name="id" value="<?php echo $uid;?>">
          <input type="submit" class="btn btn-danger" value="Ага">
        </form> -->
