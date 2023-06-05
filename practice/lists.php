<?php
switch ($entity) {
  case 'job':
    foreach($result as $k=>$v) {
      echo '<div class="d-flex m-1">
      <input class="form-check-input m-auto" style="margin-right: 5px !important; width:1.5em; height:1.5em;" type="checkbox" value="'.
      $v['job_id'].
      '">';
      echo '<a href="?id='.$v['job_id'].
      '" class="list-group-item border-0 rounded-4 list-group-item-action">';
      echo '<h4 class="d-flex justify-content-between">'.$v['job_id'].'. '
      .htmlspecialchars($v['name']).'</h4></a></div>';
    }
    break;
  case 'currency':
    foreach($result as $k=>$v) {
      echo '<div class="d-flex m-1">
      <input class="form-check-input m-auto" style="margin-right: 5px !important; width:1.5em; height:1.5em;" type="checkbox" value="'.
      $v['currency_id'].
      '">';
      echo '<a href="?id='.$v['currency_id'].
      '" class="list-group-item border-0 rounded-4 list-group-item-action">';
      echo '<h4 class="d-flex justify-content-between">'.$v['currency_id'].'. '
      .htmlspecialchars($v['name']).' <i>'.$v['code'].'</i></h4></a></div>';
    }
    break;
  case 'rate':
    foreach($result as $k=>$v) {
      echo '<div class="d-flex m-1">
      <input class="form-check-input m-auto" style="margin-right: 5px !important; width:1.5em; height:1.5em;" type="checkbox" value="'.
      $v['rate_id'].
      '">';
      echo '<a href="?id='.$v['rate_id'].
      '" class="list-group-item border-0 rounded-4 list-group-item-action">';
      echo '<h4 class="d-flex justify-content-between">'.$v['rate_id'].'. '
      .htmlspecialchars(($currencies[array_search($v['currency_id'],array_column($currencies,'currency_id'))]['name'])).' <i>'.$v['exchange_rate'].'</i></h4><h5><i>'.$v['rate_date'].'</i></h5></a></div>';
    }
    break;
  case 'operation':
    foreach($result as $k=>$v) {
      echo '<div class="d-flex m-1">
      <input class="form-check-input m-auto" style="margin-right: 5px !important; width:1.5em; height:1.5em;" type="checkbox" value="'.
      $v['operation_id'].
      '">';
      echo '<a href="?id='.$v['operation_id'].
      '" class="list-group-item border-0 rounded-4 list-group-item-action">';
      echo '<h4 class="d-flex justify-content-between">'.$v['operation_id'].'. из '.$v['amount'].' '.htmlspecialchars(($currencies[array_search($v['currency_id'],array_column($currencies,'currency_id'))]['code'])).' в '.$v['exchanged_amount'].' RUB <i>'.($emps[array_search($v['employee_id'],array_column($emps,'employee_id'))]['name']).
      '</i></h4><h5><i>'.$v['operation_date'].'</i></h5></a></div>';
    }
    break;
  default:
    foreach($result as $k=>$v) {
      echo '<div class="d-flex m-1">
      <input class="form-check-input m-auto" style="margin-right: 5px !important; width:1.5em; height:1.5em;" type="checkbox" value="'.
      $v['employee_id'].
      '">';
      echo '<a href="?id='.$v['employee_id'].
      '" class="list-group-item border-0 rounded-4 list-group-item-action">';
      echo '<h4 class="d-flex justify-content-between">'.$v['employee_id'].'. '
      .htmlspecialchars($v['name']).' <i>'.($jobs[array_search($v['job_id'],array_column($jobs,'job_id'))]['name']).
      '</i></h4><h5 class="d-flex justify-content-between"><i>'.$v['email'].' '.$v['phone'].'</i>'.$v['salary'].' руб.</h5></a></div>';
    }
    break;
}
?>