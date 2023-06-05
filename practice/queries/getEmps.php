<?php
    $stmt = $db->prepare("select * from employee");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
?>