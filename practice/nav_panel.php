<script>
  function changeTab(entity){
    document.cookie = "entity="+entity;
    location.href  = `./${entity}.php`;
  }
</script>
<div class='bg-dark w-100 d-flex flex-wrap justify-content-center'>
  <button class='btn col col-sm-2' onclick="changeTab('employee')">Сотрудники</button>
  <button class='btn col col-sm-2' onclick="changeTab('job')">Должности</button>
  <button class='btn col col-sm-2' onclick="changeTab('currency')">Валюты</button>
  <button class='btn col col-sm-2' onclick="changeTab('rate')">Курсы валют</button>
  <button class='btn col col-sm-2' onclick="changeTab('operation')">Операции</button>
  <a class='btn btn-danger m-3' href='./'>Выйти</a>
</div>