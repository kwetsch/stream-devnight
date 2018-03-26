<? include 'includes/secure.php'; ?>
<?php
$youtube = $_POST['url'];
try{
    $pdo = new PDO('sqlite:'.dirname(__FILE__)."/users.db");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $e){
    die ('DB Error');
}
$statement = $pdo->prepare("UPDATE link SET url=?");
$statement->execute(array($youtube));
header("Location: ../?success=1");