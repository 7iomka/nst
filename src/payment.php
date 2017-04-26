<?php
$log_name = "./log/".date('Ym')."_pay.log";

error_log("\r\n ------------------------" , 3, $log_name);
error_log("\r\n" . date('Y-m-d H:i',time()), 3, $log_name);
foreach ($_REQUEST as $key=>$val) {
	error_log("\r\n" . $key .": " . $val, 3, $log_name);
}

include_once "./inc/db_conf.php";
include_once "./inc/mysql.php";
include_once "./inc/def.php";

include_once "./lib/phpmailer/config.php";
include_once "./lib/phpmailer/class.phpmailer.php";

include_once "./inc/functions.php";

$id_zakaz = intval($_REQUEST['order_number']);
$sql_zakaz = "SELECT * FROM `r_zakaz` WHERE `id` = '".$id_zakaz."' LIMIT 1 ";
$row_zakaz = mysql_fetch_assoc(mysql_query($sql_zakaz));
if(!$row_zakaz){
 error_log("\r\n Err: Заказ не найден" , 3, $log_name);
 exit;
}

$sql_upd = "UPDATE `r_zakaz` SET `ticket` = '".$_REQUEST['ticket']."' WHERE `id` = '".$id_zakaz."' LIMIT 1 ";
$res_upd = mysql_query($sql_upd);

if(intval($_REQUEST['status_code']) != 3){
 error_log("\r\n Err: Заказ не оплачен (".$_REQUEST['status_desc'].")" , 3, $log_name);
 exit;
}

$row_zakaz['amount'] = $row_zakaz['sum'] * 100; 
$sign = strtoupper(md5(strtoupper(md5($Av_sign) . md5($SHOP_ID . $row_zakaz['id'] . $row_zakaz['amount']))));

if($sign != $_REQUEST['signature']){
 error_log("\r\n Err: Неверная контрольная подпись" , 3, $log_name);
 exit;
}

if($row_zakaz['amount'] != intval($_REQUEST['amount'])){
 error_log("\r\n Err: Неверная сумма заказа" , 3, $log_name);
 exit;
}

$sql_upd = "UPDATE `r_zakaz` SET `status` = 2 WHERE `id` = '".$id_zakaz."' LIMIT 1 ";
$res_upd = mysql_query($sql_upd);
if(!$res_upd){
 error_log("\r\n Err: Ошибка при обновлении статуса заказа" , 3, $log_name);
 exit;
}
else{
 $sql_emails = "SELECT `emails` FROM `admins` WHERE `id` =1 LIMIT 1 ";
 $row_emails = mysql_fetch_assoc(mysql_query($sql_emails));
 $admin_emails = explode(";", $row_emails['emails']);
 $subj = "Оплата счета с сайта стекло24";
  $mes = "";
  $mes .= "<html>
            <head>
             <title>Оплата счета с сайта стекло24</title>
             <meta charset='utf-8'>
            </head>                    
           <body>";
  $mes .= "<h3>Оплачен заказ № ".$row_zakaz['id']." на сумму: ".$row_zakaz['sum']." руб.</h3>";         
  $mes .= "</body>";         
  $mes .= "</html>";         
 foreach($admin_emails As $email){
   $email = trim($email);
   notify_admin($email,$subj,$mes);
  }
 error_log("\r\n Ok: Статус заказа обновлен" , 3, $log_name);
}

error_log("\r\n ------------------------" , 3, $log_name);
header("HTTP/1.1 202 Accepted");
?>
