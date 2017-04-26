<?php
require_once('./lib/smarty/Smarty.class.php');

$smarty = new Smarty();
$smarty->caching = false;
//$smarty->caching = true;

$smarty->template_dir = './templates/';
$smarty->compile_dir = './templates_c/';
$smarty->config_dir = './configs/';
$smarty->cache_dir = './cache/';
?>