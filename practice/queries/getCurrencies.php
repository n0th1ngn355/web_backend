<?php
    $stmt = $db->prepare("select * from currency");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
?>