<?php 
if (empty($_SERVER['PHP_AUTH_USER'])) {
    header('Location: /practice');
}
?>