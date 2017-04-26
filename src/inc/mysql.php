<?php
 include_once "db_conf.php";

 $link = mysql_connect ($database_host, $database_username, $database_password);
 mysql_select_db ($database_name, $link);
 mysql_query("SET NAMES UTF8");
?>