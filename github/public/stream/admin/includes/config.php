<?php
try{
    $pdo = new PDO('sqlite:'.dirname(__FILE__)."/users.db");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $e){
    die ('DB Error');
}
?>