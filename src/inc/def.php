<?php

 $text_len = 170;

 //Menu
 //1 - каталог
 //2 - статьи
 //3 - акции   
 $type_image = Array('image/png','image/jpg','image/gif','image/jpeg','image/pjpeg');
 
 $status_messages = array(
   '0' => 'Новое сообщение',
	 '1' => 'Обработано'
 );
 
 $status_zakaz = array(
	 '0' => 'Заказ в обработке',
   '1' => 'Готов к оплате',
   '2' => 'Оплачен',
   '3' => 'Выполнен'
 );
 
 $status_dostav = array(
	 '0' => 'Самовывоз',
   '1' => 'Доствка по г.Москва',
   '2' => 'Доствка по области'
 );
  
 //$sizes = Array("XXS","XS","S","M","L","XL","XXL","XXXL","BXL","BXXL","BXXXL"); 
 for($i=18; $i<=64; $i+=2){
  $sizes[] = $i;
 }
 $months_rus = Array("Янв.","Фев.","Мар.","Апр.","Май","Июн.","Июл.","Авг.","Сен.","Окт.","Ноя.","Дек.");
  
 $path_full_images = $_SERVER['DOCUMENT_ROOT']."/upload/";
 $path_images = "/upload/";
 
 $path_full_materials = $_SERVER['DOCUMENT_ROOT'] . "/images_materials/";
 $path_materials = "/images_materials/";

 $path_full_types = $_SERVER['DOCUMENT_ROOT'] . "/images_types/";
 $path_types = "/images_types/";
 
 $path_full_polirov = $_SERVER['DOCUMENT_ROOT'] . "/images_polirov/";
 $path_polirov = "/images_polirov/";
 
 $path_full_tips = $_SERVER['DOCUMENT_ROOT'] . "/images_tips/";
 $path_tips = "/images_tips/";
 
 $path_full_makets = $_SERVER['DOCUMENT_ROOT'] . "/makets/";
 $path_makets = "/makets/";
 
 $path_full_files = $_SERVER['DOCUMENT_ROOT']."/uploads/";
 
 $sm_width = 150;
 $sm_height = 150;

 
 $photo_width = 454;
 //$photo_height = 513;
 $photo_height = 454;
 

 $num_per_page = 10;
 
 //$slider_width = 696;
 //$slider_height = 319;
 
 //$admin_emails = Array("lvovand@mail.ru","design@prettysites.ru");
 //$admin_emails = Array("lvovand@mail.ru","");
 
 
 /*
 * Настройки магазина
 */ 
$SHOP_ID = "14865";
$PWD = "mDcGnmlNxd";
$Shop_sign = "nYlHzLSlkQZYbuoLUtJb";
$Av_sign = "UuoiRwktgBfFWZmshFMr"; 
?>