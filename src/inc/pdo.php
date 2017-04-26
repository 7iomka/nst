<?php
 include_once "db_conf.php";

 $DBH = new PDO("mysql:host=" . $database_host . ";dbname=".$database_name, $database_username, $database_password);  
 $DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );  
 $DBH->prepare('SET NAMES UTF8')->execute();
?>