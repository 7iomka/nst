<?php
session_start();
error_reporting(0);
include_once "./inc/db_conf.php";
//include_once "./inc/mysql.php";
include_once "./inc/pdo.php";
include_once "./inc/def.php";

include_once "./lib/phpmailer/config.php";
include_once "./lib/phpmailer/class.phpmailer.php";

include_once "./inc/functions.php";
include_once "./inc/functions_bitrix24.php";

$admin_emails = Array("lvovand@mail.ru");

$subj = "test";
$mes = "mes";
foreach($admin_emails As $email){
 notify_admin($email,$subj,$mes);
}
?>