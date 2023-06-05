<?php
    $stmt = $db->prepare("select * from rate");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
?>