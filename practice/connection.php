<?php
    $user = 'u53011';
    $pass = '1234';
    $db = new PDO('mysql:host=localhost;dbname=u53011;', $user, $pass,
          [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    
    // $user = 'postgres';
    // $pass = 'root';
    // $dsn = "pgsql:host=127.0.0.1;port=5432;dbname=u53011;options='--client_encoding=UTF8'";
    // $db = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
?>