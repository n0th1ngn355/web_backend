<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.1.slim.min.js"
integrity="sha256-w8CvhFs7iHNVUtnSP0YKEg00p9Ih13rlL9zGqvLdePA=" crossorigin="anonymous"></script>
<!-- <script src="saved.js" defer></script> -->
<link rel="stylesheet" href="/styles/labsStyle.css">
<form method="post" autocomplete="off" id="form" novalidate class="m-auto row g-4">
          <div class="col-md-6">
            <label for="formName" class="form-label">Имя</label>
            <input name="name" id="formName" class="form-control" placeholder="Введите имя" value="<?php  
              if(isset($_COOKIE['name']))
              print $_COOKIE['name'];
              ?>">
          </div>

          <div class="col-md-6">
            <label for="formEmail" class="form-label">Email</label>
            <input name="email" id="formEmail" class="form-control" type="email" placeholder="Введите почту" value="<?php  
              if(isset($_COOKIE['email']))
              print $_COOKIE['email'];
              ?>">
          </div>
          
          <div class="col-md-6">
            <label for="year" class="form-label">Год рождения</label>
            <select name="yob" id="year" class="form-select">
            <?php 
              if(isset($_COOKIE['yob'])){
                for ($i = 2023; $i >= 1900; $i--) {
                  if($i == $_COOKIE['yob'])
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
              if(isset($_COOKIE['sex'])){
                if($_COOKIE['sex']!=0)
                echo 'checked';
              }else echo 'checked';
              ?> id="M">
                <label class="form-check-label" for="M">М</label>
              </div>
              <div class="col-6">
                <input class="form-check-input" type="radio" name="sex" value="0" <?php 
              if(isset($_COOKIE['sex']) && $_COOKIE['sex']==0){
                echo 'checked';
              }
              ?> id="ZH">
                <label class="form-check-label" for="ZH">Ж</label>
              </div>
            </div>
            
            <div class="col-6 m-auto row">
              <label class="form-label">Количество конечностей</label>
              <div class="col-6 col-md-2">
                <input class="form-check-input" type="radio" name="num_of_limbs" value="0" <?php 
              if(isset($_COOKIE['num_of_limbs']) && $_COOKIE['num_of_limbs']==0){
                echo 'checked';
              } ?> id="0">
                <label class="form-check-label" for="0">0</label>
              </div>
              <div class="col-6 col-md-2">
                <input class="form-check-input" type="radio" name="num_of_limbs" value="1" <?php 
              if(isset($_COOKIE['num_of_limbs']) && $_COOKIE['num_of_limbs']==1){
                echo 'checked';
              } ?> id="1">
                <label class="form-check-label" for="1">1</label>
              </div>
              <div class="col-6 col-md-2">
                <input class="form-check-input" type="radio" name="num_of_limbs" value="2" <?php 
              if(isset($_COOKIE['num_of_limbs']) && $_COOKIE['num_of_limbs']==2){
                echo 'checked';
              } ?> id="2">
                <label class="form-check-label" for="2">2</label>
              </div>
              <div class="col-6 col-md-2">
                <input class="form-check-input" type="radio" name="num_of_limbs" value="3" <?php 
              if(isset($_COOKIE['num_of_limbs']) && $_COOKIE['num_of_limbs']==3){
                echo 'checked';
              } ?> id="3">
                <label class="form-check-label" for="3">3</label>
              </div>
              <div class="col-6 col-md-2">
                <input class="form-check-input" type="radio" name="num_of_limbs" value="4" 
                <?php 
                if(isset($_COOKIE['num_of_limbs'])){
                  if($_COOKIE['num_of_limbs']==4)
                    echo 'checked';
                }else echo 'checked';
              ?>  id="4">
                <label class="form-check-label" for="4">4</label>
              </div>
              <div class="col-6 col-md-2">
                <input class="form-check-input" type="radio" name="num_of_limbs" value="5" <?php 
              if(isset($_COOKIE['num_of_limbs']) && $_COOKIE['num_of_limbs']==5){
                echo 'checked';
              } ?> id="5">
                <label class="form-check-label" for="5">5</label>
              </div>
            </div>

          </div>

          <div class="col-12">
            <label for="superpowers" class="form-label">Сверхспособности</label>
            <select name="superpowers[]" id="superpowers" multiple="multiple" class="form-select">
              <?php
                $ar = array();
                if(isset($_COOKIE['superpowers']))
                  $ar = json_decode($_COOKIE['superpowers']);
               ?>
              <option value="1" <?php if(in_array(1,$ar)) echo 'selected' ?>>бессмертие</option>
              <option value="2" <?php if(in_array(2,$ar)) echo 'selected' ?>>прохождение сквозь стены</option>
              <option value="3" <?php if(in_array(3,$ar)) echo 'selected' ?>>левитация</option>
            </select>
          </div>

          <div class="col-12">
            <label for="biography" class="form-label">Биография</label>
            <textarea id="biography" class="form-control" name="biography" placeholder="Введите биографию"><?php
              if(isset($_COOKIE['biography']))
                printf($_COOKIE['biography']);
               ?></textarea>
          </div>
          
          <div class="col-12 d-flex">
            <div class="form-check m-auto">
              <label class="form-check-label" for="policyCheckBox">С контрактом ознакомлен(а)</label>
              <input class="form-check-input" type="checkbox" id="policyCheckBox" <?php 
              if(isset($_COOKIE['policyCheckBox']) && $_COOKIE['policyCheckBox']=='on'){
                echo 'checked';
              } ?> name="policyCheckBox">
            </div>
          </div>
          <div class="col-12 d-flex">          
            <input type="submit" id="submitBtn" class="btn btn-success m-auto" value="Отправить">
          </div>
        </form>

<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body d-flex p-0">
        <h1>Спасибо, результаты сохранены.</h1>
      </div>
    </div>
  </div>
</div>

<?php
if (isset($_COOKIE['saved'])) {
echo "<script type='text/javascript'>
$(document).ready(function(){
  $('#modal').modal('show');
});
</script>";}
