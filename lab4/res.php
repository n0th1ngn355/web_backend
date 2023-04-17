<?php

header('Content-Type: text/html; charset=UTF-8');
echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">';
echo "<link rel='stylesheet' href='/styles/labsStyle.css'>";
echo '<body class="flex-row">';
echo "<div class='col-12 col-lg-6 m-auto'>";
echo "<table style='border: solid 1px white; font-size:25px;'>";
echo "<tr><th>Name</th><th>Email</th><th>Superpowers <span style='font-size:20px;'>(для удобства все собраны вместе)</span></th></tr>";

class TableRows extends RecursiveIteratorIterator {
  function __construct($it) {
    parent::__construct($it, self::LEAVES_ONLY);
  }

  function current() {
    return "<td style='padding: 10px; border:1px solid white;'>" . parent::current(). "</td>";
  }

  function beginChildren() {
    echo "<tr>";
  }

  function endChildren() {
    echo "</tr>" . "\n";
  }
}


try{
  $user = 'u53011';
  $pass = '1234';
  $db = new PDO('mysql:host=localhost;dbname=u53011;', $user, $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

  $stmt = $db->prepare("select application.name, email, group_concat(superpower.name separator ', ') as superpowers from application  join application_superpower on application.application_id =application_superpower.application_id join superpower on application_superpower.sup_id = superpower.sup_id group by application.name, application.email");
  $stmt->execute();

  $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
  foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
    echo $v;
  }
} catch(PDOException $e){
  die($e->getMessage());
}
echo "</table>";

