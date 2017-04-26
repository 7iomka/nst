<?php
require_once('./../lib/smarty/Smarty.class.php');

$smarty = new Smarty();
$smarty->caching = false;

$smarty->template_dir = './../templates_admin/';
$smarty->compile_dir = './../templates_admin_c/';
$smarty->config_dir = './../configs/';
$smarty->cache_dir = './../cache_admin/';
?>