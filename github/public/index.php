<?php
require_once("../generator.php");

generateFiles($_POST['payload'], $_GET['action'], json_decode(file_get_contents("../config.json")));