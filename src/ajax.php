<?php

session_start();
error_reporting(0);
// ini_set("display_errors",1);
include_once "./inc/db_conf.php";
//include_once "./inc/mysql.php";
include_once "./inc/pdo.php";
include_once "./inc/def.php";

include_once "./lib/phpmailer/config.php";
include_once "./lib/phpmailer/class.phpmailer.php";

include_once "./inc/functions.php";
include_once "./inc/functions_bitrix24.php";

if (isset($_REQUEST['task'])) {
    $task = trim($_REQUEST['task']);
} elseif (isset($_GET['task'])) {
    $task = trim($_GET['task']);
} else {
    $task = 'main';
}
$admin_emails = Array("7iomka@gmail.com");
$sql_emails   = "SELECT `emails` FROM `admins` WHERE `id` =1 LIMIT 1 ";
$row_emails   = $DBH->query($sql_emails)->fetch();
// $admin_emails = explode(";", $row_emails['emails']);
$S_min        = 500;
// echo print_r($_REQUEST);
// die;
switch ($task) {
    case "getMaterials":
        $id_material = intval($_REQUEST['id_material']);

        $sql_materials = "SELECT * FROM `r_material` WHERE `id_material` = '" . $id_material . "' ORDER BY `order` ";
        $res_materials = $DBH->query($sql_materials);
        while ($row_material = $res_materials->fetch()) {
            $materials[] = $row_material;
        }
        switch ($id_material) {
            case 1:
                $data['type_material'] = "Вид<br>стекла";
                break;
            case 2:
                $data['type_material'] = "Вид<br>зеркала";
                break;
        }

        $data['is_err']    = 0;
        $data['materials'] = $materials;
        echo json_encode($data);
        exit;
        break;

    case "getTypes":
        $id_material = intval($_REQUEST['id_material']);

        $sql_types = "SELECT * FROM `r_material_type` WHERE `id_material` = '" . $id_material . "' ORDER BY `depth` ";
        $res_types = $DBH->query($sql_types);
        while ($row_type = $res_types->fetch()) {
            $types[] = $row_type;
        }

        $sql_material = "SELECT * FROM `r_material` WHERE `id` = '" . $id_material . "' LIMIT 1 ";
        $row_material = $DBH->query($sql_material)->fetch();

        switch ($row_material['id_material']) {
            case 1:
                $data['type_material'] = "Толщина<br>стекла";
                break;
            case 2:
                $data['type_material'] = "Толщина<br>зеркала";
                break;
        }

        $data['is_err'] = 0;
        $data['types']  = $types;
        echo json_encode($data);
        exit;
        break;

    case "getFacet":
        $depth = intval($_REQUEST['depth']);

        $sql_polirovs     = "SELECT * FROM `r_polirov` WHERE 1 ORDER BY `order` ASC ";
        $res_polirovs     = $DBH->query($sql_polirovs);
        $polirovs_facet   = Array();
        $polirovs_nofacet = Array();

        while ($row_polirov = $res_polirovs->fetch()) {
            $row_polirov   = stripslashes_array($row_polirov);
            $sql_min_depth = "SELECT MIN(`depth`) AS min_depth FROM `r_polirov_type` WHERE `id_polirov` = '" . $row_polirov['id'] . "' ";
            $row_min_depth = $DBH->query($sql_min_depth)->fetch();
            if (isset($row_min_depth['min_depth']) && $depth >= $row_min_depth['min_depth']) {
                if ($row_polirov['isfacet']) {
                    $polirovs_facet[] = $row_polirov;
                } else {
                    $polirovs_nofacet[] = $row_polirov;
                }
            }
        }

        $data['is_err']      = 0;
        $data['facet_arr']   = $polirovs_facet;
        $data['nofacet_arr'] = $polirovs_nofacet;
        echo json_encode($data);
        exit;
        break;

    case "getRaschet":
        $id_material      = intval($_REQUEST['id_material']); //материал
        $id_material_type = intval($_REQUEST['id_material_type']); //тип материала
        $depth            = intval($_REQUEST['depth']); //толщина
        $height           = intval($_REQUEST['height']); //высота
        $width            = intval($_REQUEST['width']); //ширина
        $form             = trim($_REQUEST['form']); //форма стекла
        $diametr          = intval($_REQUEST['diametr']); //диаметр
        $polirov          = intval($_REQUEST['polirov']); //обработка

        //дополнительно
        //закалка
        $harding      = intval($_REQUEST['harding']);
        //отверстия
        $otverst      = intval($_REQUEST['otverst']);
        $cnt_otverst  = intval($_REQUEST['cnt_otverst']);
        //вырез
        $vyrez        = intval($_REQUEST['vyrez']);
        $cnt_vyrez    = intval($_REQUEST['cnt_vyrez']);
        //скругление
        $rounding     = intval($_REQUEST['rounding']);
        $cnt_rounding = intval($_REQUEST['cnt_rounding']);
        //пленка
        $safety       = intval($_REQUEST['safety']);
        //бронепленка
        $bron         = intval($_REQUEST['bron']);

        //доставка
        $dostavka = intval($_REQUEST['dostavka']);

        //количество
        $cnt = intval($_REQUEST['cnt']);

        if (!$id_material_type) {
            $data['is_err'] = 1;
            $data['err']    = "Не указан материал";
            echo json_encode($data);
            exit;
        }
        if (!$depth) {
            $data['is_err'] = 1;
            $data['err']    = "Не указана толщина";
            echo json_encode($data);
            exit;
        }

        switch ($form) {
            case "square":
                $k = 1;
                if (!$height) {
                    $data['is_err'] = 1;
                    $data['err']    = "Не указана высота";
                    echo json_encode($data);
                    exit;
                }
                if (!$width) {
                    $data['is_err'] = 1;
                    $data['err']    = "Не указана ширина";
                    echo json_encode($data);
                    exit;
                }
                //площадь
                //$S = round($width * $height / (1000*1000),1);
                $S         = $width * $height / (1000 * 1000);
                //периметр
                //$P = round( (($width * 2) + ($height*2))/ 1000,1);
                $P         = (($width * 2) + ($height * 2)) / 1000;
                $form_name = "Прямоугольная";
                break;
            case "other":
                $k = 2.3;
                if (!$height) {
                    $data['is_err'] = 1;
                    $data['err']    = "Не указана высота";
                    echo json_encode($data);
                    exit;
                }
                if (!$width) {
                    $data['is_err'] = 1;
                    $data['err']    = "Не указана ширина";
                    echo json_encode($data);
                    exit;
                }
                //площадь
                //$S = round($width * $height / (1000*1000),1);
                $S         = $width * $height / (1000 * 1000);
                //периметр
                //$P = round( (($width * 2) + ($height*2))/ 1000,1);
                $P         = (($width * 2) + ($height * 2)) / 1000;
                $form_name = "Другая";
                break;

            case "round":
                $k = 2.3;
                if (!$diametr) {
                    $data['is_err'] = 1;
                    $data['err']    = "Не указан диаметр";
                    echo json_encode($data);
                    exit;
                }
                //площадь
                //$S = round(3.14*$diametr * $diametr / (4*1000*1000),1);
                //$S = 3.14*$diametr * $diametr / (4*1000*1000);
                $S         = $diametr * $diametr / (1000 * 1000);
                //периметр
                //$P = round(3.14*$diametr / 1000,1);
                //$P = 3.14*$diametr / 1000;
                $P         = ($diametr * 4) / 1000;
                $form_name = "Круг";
                break;
        }


        if (!$polirov) {
            $sql_min_polirov = "SELECT `id` FROM `r_polirov` WHERE 1 ORDER BY `order` ASC LIMIT 1 ";
            $row_min_polirov = $DBH->query($sql_min_polirov)->fetch();
            $polirov         = $row_min_polirov['id'];
        }

        //цена за материал
        $sql_price = "SELECT `price` FROM `r_material_type` WHERE 1 AND `id_material` = '" . $id_material_type . "' AND `depth` = '" . $depth . "' LIMIT 1 ";
        $row_price = $DBH->query($sql_price)->fetch();
        $price_S   = $row_price['price'] * $S;

        //цена за полировку
        $sql_price = "SELECT `price` FROM `r_polirov_type` WHERE `id_polirov` = '" . $polirov . "' AND `depth` = '" . $depth . "' LIMIT 1 ";
        $row_price = $DBH->query($sql_price)->fetch();
        $price_P   = $row_price['price'] * $P * $k;

        //закалка
        $price_Z = 0;
        if ($harding) {
            //цена за закалку
            //$sql_price = "SELECT `price` FROM `r_harding` WHERE 1 AND `depth` = '".$depth."' LIMIT 1 ";
            $sql_price = "SELECT `price_harding` FROM `r_material_type` WHERE 1 AND `id_material` = '" . $id_material_type . "' AND `depth` = '" . $depth . "' LIMIT 1 ";
            $row_price = $DBH->query($sql_price)->fetch();
            $price_Z   = $row_price['price_harding'] * $S;
        }


        //отверстия
        $price_Otverst = 0;
        if ($otverst && $cnt_otverst) {
            //цена за отверстия
            $sql_price     = "SELECT `price` FROM `r_dopolnit` WHERE 1 AND `name_perem` = 'hole' LIMIT 1 ";
            $row_price     = $DBH->query($sql_price)->fetch();
            $price_Otverst = $row_price['price'] * $cnt_otverst;
        }

        //вырез
        $price_Vyrez = 0;
        if ($vyrez && $cnt_vyrez) {
            //цена за вырез
            $sql_price   = "SELECT `price` FROM `r_dopolnit` WHERE 1 AND `name_perem` = 'cutout' LIMIT 1 ";
            $row_price   = $DBH->query($sql_price)->fetch();
            $price_Vyrez = $row_price['price'] * $cnt_vyrez;
        }

        //скругление
        $price_Rounding = 0;
        if ($rounding && $cnt_rounding) {
            //цена за скругление
            $sql_price      = "SELECT `price` FROM `r_dopolnit` WHERE 1 AND `name_perem` = 'rounding' LIMIT 1 ";
            $row_price      = $DBH->query($sql_price)->fetch();
            $price_Rounding = $row_price['price'] * $cnt_rounding;
        }
        //пленка
        $price_Safety = 0;
        if ($safety) {
            //цена за скругление
            $sql_price    = "SELECT `price` FROM `r_dopolnit` WHERE 1 AND `name_perem` = 'safety' LIMIT 1 ";
            $row_price    = $DBH->query($sql_price)->fetch();
            $price_Safety = $row_price['price'] * $S;
        }
        //бронепленка
        $price_Bron = 0;
        if ($bron) {
            //цена за скругление
            $sql_price  = "SELECT `price` FROM `r_dopolnit` WHERE 1 AND `name_perem` = 'bron' LIMIT 1 ";
            $row_price  = $DBH->query($sql_price)->fetch();
            $price_Bron = $row_price['price'] * $S;
        }

        //Доставка
        $price_Dostavka = 0;
        if ($dostavka) {
            switch ($dostavka) {
                case "1":
                    $sql_price      = "SELECT `price` FROM `r_dopolnit` WHERE 1 AND `name_perem` = 'dostavka_moscow' LIMIT 1 ";
                    $row_price      = $DBH->query($sql_price)->fetch();
                    $price_Dostavka = $row_price['price'];
                    break;
                case "2":
                    $sql_price      = "SELECT `price` FROM `r_dopolnit` WHERE 1 AND `name_perem` = 'dostavka_oblast' LIMIT 1 ";
                    $row_price      = $DBH->query($sql_price)->fetch();
                    $price_Dostavka = $row_price['price'];
                    break;
                default:
                    $price_Dostavka = 0;
            }
        }
        /*
        if($_SERVER['REMOTE_ADDR'] == "82.112.183.175"){
        error_log("\r\n---\r\n".$price_S.",".$price_P.",".$price_Z.",".$price_Otverst.",".$price_Vyrez.",".$price_Rounding.",".$price_Safety.",".$price_Bron,3,"log.log");
        }
        */
        $Sum = $price_S + $price_P + $price_Z + $price_Otverst + $price_Vyrez + $price_Rounding + $price_Safety + $price_Bron;
        $Sum = my_round($Sum, 50);
        if ($Sum < $S_min) {
            $Sum = $S_min;
        }
        $Sum              = $Sum * $cnt;
        $Sum              = $Sum + $price_Dostavka;
        //error_log("\r\n GETORDER " . $Sum.":".$price_S.":".$price_P.":".$price_Z.":".$price_Otverst.":".$price_Vyrez.":".$price_Rounding.":".$price_Safety.":".$price_Bron,3,'log.log');
        $data['res']      = $price_S;
        $data['is_err']   = 0;
        $data['itog_sum'] = $Sum;
        //$data['itog_sum'] = $price_S." ".$price_P." ".$price_Z." ".$price_Otverst." ".$price_Vyrez." ".$price_Rounding." ".$price_Safety." ".$price_Dostavka;
        echo json_encode($data);
        exit;
        break;

    case "action-order":
        //пользователь
        $user_name     = trim($_REQUEST['user_name']); //имя
        $user_phone    = trim($_REQUEST['user_phone']); //тел
        $user_email    = trim($_REQUEST['user_email']); //email
        $user_comments = trim($_REQUEST['user_comments']); //comments
        // $user_inn = trim($_REQUEST['inn_user']); //inn
        $user_inn      = 'none'; //inn off

        $id_material      = intval($_REQUEST['id_material']); //материал
        $id_material_type = intval($_REQUEST['id_material_type']); //тип материала
        $depth            = intval($_REQUEST['depth']); //толщина
        $height           = intval($_REQUEST['height']); //высота
        $width            = intval($_REQUEST['width']); //ширина
        $form             = trim($_REQUEST['form']); //форма стекла
        $diametr          = intval($_REQUEST['diametr']); //диаметр
        $polirov          = intval($_REQUEST['polirov']); //обработка

        //дополнительно
        //закалка
        $harding      = intval($_REQUEST['harding']);
        //отверстия
        $otverst      = intval($_REQUEST['otverst']);
        $cnt_otverst  = intval($_REQUEST['cnt_otverst']);
        //вырез
        $vyrez        = intval($_REQUEST['vyrez']);
        $cnt_vyrez    = intval($_REQUEST['cnt_vyrez']);
        //скругление
        $rounding     = intval($_REQUEST['rounding']);
        $cnt_rounding = intval($_REQUEST['cnt_rounding']);
        //пленка
        $safety       = intval($_REQUEST['safety']);
        //бронепленка
        $bron         = intval($_REQUEST['bron']);

        //доставка
        $dostavka      = intval($_REQUEST['dostavka']);
        $dostavka_addr = trim($_REQUEST['dostavka_addr']);

        //дата
        $date_zakaz = trim($_REQUEST['date_zakaz']);

        //количество
        $cnt = intval($_REQUEST['cnt']);

        if (!$id_material_type) {
            $data['is_err'] = 1;
            $data['err']    = "Не указан материал";
            echo json_encode($data);
            exit;
        }
        if (!$depth) {
            $data['is_err'] = 1;
            $data['err']    = "Не указана толщина";
            echo json_encode($data);
            exit;
        }

        switch ($form) {
            case "square":
                $k = 1;
                if (!$height) {
                    $data['is_err'] = 1;
                    $data['err']    = "Не указана высота";
                    echo json_encode($data);
                    exit;
                }
                if (!$width) {
                    $data['is_err'] = 1;
                    $data['err']    = "Не указана ширина";
                    echo json_encode($data);
                    exit;
                }
                //площадь
                //$S = round($width * $height / (1000*1000),1);
                $S         = $width * $height / (1000 * 1000);
                //периметр
                //$P = round( (($width * 2) + ($height*2))/ 1000,1);
                $P         = (($width * 2) + ($height * 2)) / 1000;
                $form_name = "Прямоугольная";
                break;
            case "other":
                $k = 2.3;
                if (!$height) {
                    $data['is_err'] = 1;
                    $data['err']    = "Не указана высота";
                    echo json_encode($data);
                    exit;
                }
                if (!$width) {
                    $data['is_err'] = 1;
                    $data['err']    = "Не указана ширина";
                    echo json_encode($data);
                    exit;
                }
                //площадь
                //$S = round($width * $height / (1000*1000),1);
                $S         = $width * $height / (1000 * 1000);
                //периметр
                //$P = round( (($width * 2) + ($height*2))/ 1000,1);
                $P         = (($width * 2) + ($height * 2)) / 1000;
                $form_name = "Другая";
                break;

            case "round":
                $k = 2.3;
                if (!$diametr) {
                    $data['is_err'] = 1;
                    $data['err']    = "Не указан диаметр";
                    echo json_encode($data);
                    exit;
                }
                //площадь
                //$S = round(3.14*$diametr * $diametr / (4*1000*1000),1);
                //$S = 3.14*$diametr * $diametr / (4*1000*1000);
                $S         = $diametr * $diametr / (1000 * 1000);
                //периметр
                //$P = round(3.14*$diametr / 1000,1);
                //$P = 3.14*$diametr / 1000;
                $P         = ($diametr * 4) / 1000;
                $form_name = "Круг";
                break;
        }


        if (!$polirov) {
            $sql_min_polirov = "SELECT `id` FROM `r_polirov` WHERE 1 ORDER BY `order` ASC LIMIT 1 ";
            $row_min_polirov = $DBH->query($sql_min_polirov)->fetch();
            $polirov         = $row_min_polirov['id'];
        }

        //цена за материал
        $sql_price = "SELECT `price` FROM `r_material_type` WHERE 1 AND `id_material` = '" . $id_material_type . "' AND `depth` = '" . $depth . "' LIMIT 1 ";
        $row_price = $DBH->query($sql_price)->fetch();
        $price_S   = $row_price['price'] * $S;

        //цена за полировку
        $sql_price = "SELECT `price` FROM `r_polirov_type` WHERE `id_polirov` = '" . $polirov . "' AND `depth` = '" . $depth . "' LIMIT 1 ";
        $row_price = $DBH->query($sql_price)->fetch();
        $price_P   = $row_price['price'] * $P * $k;

        //закалка
        $price_Z = 0;
        if ($harding) {
            //цена за закалку
            //$sql_price = "SELECT `price` FROM `r_harding` WHERE 1 AND `depth` = '".$depth."' LIMIT 1 ";
            $sql_price = "SELECT `price_harding` FROM `r_material_type` WHERE 1 AND `id_material` = '" . $id_material_type . "' AND `depth` = '" . $depth . "' LIMIT 1 ";
            $row_price = $DBH->query($sql_price)->fetch();
            $price_Z   = $row_price['price_harding'] * $S;
        }

        //отверстия
        $price_Otverst = 0;
        if ($otverst && $cnt_otverst) {
            //цена за отверстия
            $sql_price     = "SELECT `price` FROM `r_dopolnit` WHERE 1 AND `name_perem` = 'hole' LIMIT 1 ";
            $row_price     = $DBH->query($sql_price)->fetch();
            $price_Otverst = $row_price['price'] * $cnt_otverst;
        }

        //вырез
        $price_Vyrez = 0;
        if ($vyrez && $cnt_vyrez) {
            //цена за вырез
            $sql_price   = "SELECT `price` FROM `r_dopolnit` WHERE 1 AND `name_perem` = 'cutout' LIMIT 1 ";
            $row_price   = $DBH->query($sql_price)->fetch();
            $price_Vyrez = $row_price['price'] * $cnt_vyrez;
        }

        //скругление
        $price_Rounding = 0;
        if ($rounding && $cnt_rounding) {
            //цена за скругление
            $sql_price      = "SELECT `price` FROM `r_dopolnit` WHERE 1 AND `name_perem` = 'rounding' LIMIT 1 ";
            $row_price      = $DBH->query($sql_price)->fetch();
            $price_Rounding = $row_price['price'] * $cnt_rounding;
        }
        //пленка
        $price_Safety = 0;
        if ($safety) {
            //цена
            $sql_price    = "SELECT `price` FROM `r_dopolnit` WHERE 1 AND `name_perem` = 'safety' LIMIT 1 ";
            $row_price    = $DBH->query($sql_price)->fetch();
            $price_Safety = $row_price['price'] * $S;
        }
        //бронепленка
        $price_Bron = 0;
        if ($bron) {
            //цена
            $sql_price  = "SELECT `price` FROM `r_dopolnit` WHERE 1 AND `name_perem` = 'bron' LIMIT 1 ";
            $row_price  = $DBH->query($sql_price)->fetch();
            $price_Bron = $row_price['price'] * $S;
        }

        //Доставка
        $price_Dostavka = 0;
        if ($dostavka) {
            switch ($dostavka) {
                case "1":
                    $sql_price      = "SELECT `price` FROM `r_dopolnit` WHERE 1 AND `name_perem` = 'dostavka_moscow' LIMIT 1 ";
                    $row_price      = $DBH->query($sql_price)->fetch();
                    $price_Dostavka = $row_price['price'];
                    //$dostavka_name = "Доставка. Москва. " . $dostavka_addr;
                    $dostavka_name  = $dostavka_addr;
                    break;
                case "2":
                    $sql_price      = "SELECT `price` FROM `r_dopolnit` WHERE 1 AND `name_perem` = 'dostavka_oblast' LIMIT 1 ";
                    $row_price      = $DBH->query($sql_price)->fetch();
                    $price_Dostavka = $row_price['price'];
                    //$dostavka_name = "Доставка. МО. " . $dostavka_addr;
                    $dostavka_name  = $dostavka_addr;
                    break;
                default:
                    $price_Dostavka = 0;
                    $dostavka_name  = "Самовывоз";
            }
        } else {
            $price_Dostavka = 0;
            $dostavka_name  = "Самовывоз";
        }
        /*
        if($_SERVER['REMOTE_ADDR'] == "82.112.183.175"){
        error_log("\r\n---\r\n".$price_S.",".$price_P.",".$price_Z.",".$price_Otverst.",".$price_Vyrez.",".$price_Rounding.",".$price_Safety.",".$price_Bron,3,"log.log");
        }
        */
        $Sum = $price_S + $price_P + $price_Z + $price_Otverst + $price_Vyrez + $price_Rounding + $price_Safety + $price_Bron;
        $Sum = my_round($Sum, 50);
        if ($Sum < $S_min) {
            $Sum = $S_min;
        }
        $Sum = $Sum * $cnt;
        $Sum = $Sum + $price_Dostavka;

        //error_log('\r\n SENDORDER:' . $Sum.":".$price_S.":".$price_P.":".$price_Z.":".$price_Otverst.":".$price_Vyrez.":".$price_Rounding.":".$price_Safety.":".$price_Bron,3,'log.log');
        //Название материала
        $sql = "SELECT * FROM `r_material_type` WHERE `id` = '" . $id_material_type . "' LIMIT 1 ";
        $row = $DBH->query($sql)->fetch();

        $sql                = "SELECT * FROM `r_material` WHERE `id` = '" . $id_material_type . "' LIMIT 1 ";
        $row                = $DBH->query($sql)->fetch();
        $material_type_name = $row['name'];

        $sql           = "SELECT * FROM `r_names` WHERE `id` = '" . $row['id_material'] . "' LIMIT 1 ";
        $row           = $DBH->query($sql)->fetch();
        $material_name = $row['name'];

        $sql = "SELECT * FROM `r_polirov` WHERE `id` = '" . $polirov . "' LIMIT 1 ";
        $row = $DBH->query($sql)->fetch();
        if ($row['is_facet']) {
            $polirov_name = "Фацет " . $row['name'];
        } else {
            $polirov_name = $row['name'];
        }

        if ($harding) {
            $harding_name = "Требуется";
        } else {
            $harding_name = "Не требуется";
        }

        if ($otverst && $cnt_otverst) {
            $otverst_name = "Требуется " . $cnt_otverst . " отверст.";
        } else {
            $otverst_name = "Не требуется";
        }

        if ($vyrez && $cnt_vyrez) {
            $vyrez_name = "Требуется " . $cnt_vyrez . " вырез.";
        } else {
            $vyrez_name = "Не требуется";
        }

        if ($rounding && $cnt_rounding) {
            $rounding_name = "Требуется " . $cnt_rounding . " скруглен.";
        } else {
            $rounding_name = "Не требуется ";
        }

        if ($safety) {
            $safety_name = "Требуется";
        } else {
            $safety_name = "Не требуется";
        }

        if ($bron) {
            $bron_name = "Требуется";
        } else {
            $bron_name = "Не требуется";
        }

        //прикрепленные макеты
        $sess_id   = session_id();
        $files_arr = Array();
        if ($handle = opendir($path_full_files . $sess_id)) {
            /* Именно этот способ чтения элементов каталога является правильным. */
            while (false !== ($file = readdir($handle))) {
                if ($file != '.' && $file != '..') {
                    $files_arr[] = $file;
                }
            }
            closedir($handle);
        }
        //var_dump($files_arr);exit;
        $time       = time() - 3600; //разница на -1 час
        $files_name = "";
        if (!count($files_arr)) {
            $files_name = "Макеты не прикреплены";
            $attach     = false;
        } else {
            //$dir = $_SERVER['DOCUMENT_ROOT'] . "/upload_orders/" .$time;
            //@mkdir();
            $files_name .= "<p>Прикреплено " . count($files_arr) . " файл</p>";
            for ($i = 0; $i < count($files_arr); $i++) {
                $files_arr[$i]      = urlencode($files_arr[$i]);
                //$files_name .= "<p><a target='_blank' href='http://".$_SERVER['HTTP_HOST']."/uploads/".$sess_id."/".$files_arr[$i]."'>".urldecode($files_arr[$i])."</a></p><br>";
                $attach[$i]['path'] = $_SERVER['DOCUMENT_ROOT'] . "/uploads/" . $sess_id . "/" . $files_arr[$i];
                $attach[$i]['name'] = urldecode($files_arr[$i]);
            }
        }
        $date_zakaz_arr  = explode("/", $date_zakaz);
        $date_zakaz_base = intval($date_zakaz_arr[2]) . "-" . intval($date_zakaz_arr[1]) . "-" . intval($date_zakaz_arr[0]);
        $sql_ins         = "INSERT INTO `r_zakaz` SET
                `added` = '" . $time . "',
                `cnt` = '" . $cnt . "',
                `status` = 0,
                `sum` = '" . $Sum . "',
                `name` = '" . $user_name . "',
                `phone` = '" . $user_phone . "',
                `email` = '" . $user_email . "',
                `inn` = '" . $user_inn . "',
                `material` = '" . $material_name . "',
                `type_material` = '" . $material_type_name . "',
                `width_material` = '" . $depth . "',
                `form` = '" . $form_name . "',
                `w` = '" . $width . "',
                `h` = '" . $height . "',
                `d` = '" . $diametr . "',
                `polirov` = '" . $polirov_name . "',
                `date` = '" . $date_zakaz_base . "',
                `dostavka` = '" . $dostavka . "',
                `dostavka_addr` = '" . $dostavka_name . "' ";
        $res_ins         = $DBH->query($sql_ins);

        $id_zakaz = $DBH->lastInsertId();
        if ($harding) {
            $sql_ins = "INSERT INTO `r_zakaz_dopolnit` SET `id_zakaz` = '" . $id_zakaz . "',`name` = 'Закалка' ";
            $res_ins = $DBH->query($sql_ins);
        }

        if ($otverst && $cnt_otverst) {
            $sql_ins = "INSERT INTO `r_zakaz_dopolnit` SET `id_zakaz` = '" . $id_zakaz . "',`name` = 'Отверстия',`cnt` = '" . $cnt_otverst . "' ";
            $res_ins = $DBH->query($sql_ins);
        }

        if ($vyrez && $cnt_vyrez) {
            $sql_ins = "INSERT INTO `r_zakaz_dopolnit` SET `id_zakaz` = '" . $id_zakaz . "',`name` = 'Вырезы',`cnt` = '" . $cnt_vyrez . "' ";
            $res_ins = $DBH->query($sql_ins);
        }

        if ($rounding && $cnt_rounding) {
            $sql_ins = "INSERT INTO `r_zakaz_dopolnit` SET `id_zakaz` = '" . $id_zakaz . "',`name` = 'Скругления',`cnt` = '" . $cnt_rounding . "' ";
            $res_ins = $DBH->query($sql_ins);
        }

        if ($safety) {
            $sql_ins = "INSERT INTO `r_zakaz_dopolnit` SET `id_zakaz` = '" . $id_zakaz . "',`name` = 'Защитная пленка' ";
            $res_ins = $DBH->query($sql_ins);
        }

        if ($bron) {
            $sql_ins = "INSERT INTO `r_zakaz_dopolnit` SET `id_zakaz` = '" . $id_zakaz . "',`name` = 'Бронепленка' ";
            $res_ins = $DBH->query($sql_ins);
        }

        if (count($files_arr)) {
            $r = @mkdir($path_full_makets . $id_zakaz);
        }
        for ($i = 0; $i < count($files_arr); $i++) {
            //$files_name .= "<p><a target='_blank' href='http://".$_SERVER['HTTP_HOST']."/uploads/".$sess_id."/".$files_arr[$i]."'>".urldecode($files_arr[$i])."</a></p><br>";
            //@unlink($_SERVER['DOCUMENT_ROOT']."/uploads/".$sess_id."/".$files_arr[$i]);
            //@rmdir($_SERVER['DOCUMENT_ROOT']."/uploads/".$sess_id);
            $c       = copy($_SERVER['DOCUMENT_ROOT'] . "/uploads/" . $sess_id . "/" . $files_arr[$i], $path_full_makets . $id_zakaz . "/" . $files_arr[$i]);
            $sql_ins = "INSERT INTO `r_zakaz_files` SET `id_zakaz` = '" . $id_zakaz . "', `file` = '" . $files_arr[$i] . "' ";
            $res_ins = $DBH->query($sql_ins);
        }

        $subj = "Сообщение с сайта стекло24";
        $mes  = "";
        $mes .= "<html>
                    <head>
                      <title>Сообщение с сайта стекло24</title>
                    </head>
                  <body>";
        $mes .= "<table>";
        $mes .= "<tr><th colspan='2'>Данные заказа</th></tr>";
        $mes .= "<tr><td>Дата:</td><td>" . date('Y-m-d H:i', $time) . "</td></tr>";
        $mes .= "<tr><td>Имя:</td><td>" . $user_name . "</td></tr>";
        $mes .= "<tr><td>Тел.:</td><td>" . $user_phone . "</td></tr>";
        $mes .= "<tr><td>Email:</td><td>" . $user_email . "</td></tr>";
        $mes .= "<tr><td>Комментарии к заказу:</td><td>" . $user_comments . "</td></tr>";
        // if($user_inn != ""){
        if ($user_inn != "none") {
            $mes .= "<tr><td>ИНН:</td><td>" . $user_inn . "</td></tr>";
        }
        $mes .= "<tr><th colspan='2'>Данные заказа</th></tr>";
        $mes .= "<tr><td>№ заказа:</td><td>" . $id_zakaz . "</td></tr>";
        $mes .= "<tr><td>Материал:</td><td>" . $material_name . "</td></tr>";
        $mes .= "<tr><td>Тип материала:</td><td>" . $material_type_name . "</td></tr>";
        $mes .= "<tr><td>Толщина:</td><td>" . $depth . " мм</td></tr>";
        $mes .= "<tr><td>Форма изделия:</td><td>" . $form_name . "</td></tr>";
        switch ($form) {
            case "square":
            case "other":
                $mes .= "<tr><td>Ширина:</td><td>" . $width . " мм</td></tr>";
                $mes .= "<tr><td>Высота:</td><td>" . $height . " мм</td></tr>";
                break;
            case "round":
                $mes .= "<tr><td>Диаметр:</td><td>" . $diametr . " мм</td></tr>";
                break;
        }

        $mes .= "<tr><td>Обработка:</td><td>" . $polirov_name . "</td></tr>";
        $mes .= "<tr><td>Закалка:</td><td>" . $harding_name . "</td></tr>";
        $mes .= "<tr><td>Отверстия:</td><td>" . $otverst_name . "</td></tr>";
        $mes .= "<tr><td>Вырезы:</td><td>" . $vyrez_name . "</td></tr>";
        $mes .= "<tr><td>Скругления:</td><td>" . $rounding_name . "</td></tr>";
        $mes .= "<tr><td>Пленка:</td><td>" . $safety_name . "</td></tr>";
        $mes .= "<tr><td>Бронепленка:</td><td>" . $bron_name . "</td></tr>";
        $mes .= "<tr><td>Доставка:</td><td>" . $dostavka_name . "</td></tr>";
        $mes .= "<tr><td>Дата исполнения:</td><td>" . $date_zakaz . "</td></tr>";
        $mes .= "<tr><td>Количество:</td><td>" . $cnt . "</td></tr>";
        $mes .= "<tr><td>Рассчитанная цена:</td><td>" . $Sum . "</td></tr>";
        $mes .= "<tr><td>Прикрепленные файлы:</td><td>" . $files_name . "</td></tr>";
        $mes .= "</table>";
        $mes .= "</body></html>";

        //отправка в битрикс
        $time = time();

        $comment = "<table cellpadding='0' cellspacing='0'>";
        $comment .= "<tr><th colspan='2'>Данные заказа</th></tr>";
        $comment .= "<tr><td>Дата:</td><td>" . date('Y-m-d H:i', $time) . "</td></tr>";
        $comment .= "<tr><td>Имя:</td><td>" . $user_name . "</td></tr>";
        $comment .= "<tr><td>Тел.:</td><td>" . $user_phone . "</td></tr>";
        $comment .= "<tr><td>Email:</td><td>" . $user_email . "</td></tr>";
        if ($user_inn != "") {
            $comment .= "<tr><td>ИНН:</td><td>" . $user_inn . "</td></tr>";
        }
        $comment .= "<tr><th colspan='2'>Данные заказа</th></tr>";
        $comment .= "<tr><td>№ заказа:</td><td>" . $id_zakaz . "</td></tr>";
        $comment .= "<tr><td>Материал:</td><td>" . $material_name . " " . $material_type_name . " " . $depth . "мм</td></tr>";
        $comment .= "<tr><td>Форма изделия:</td><td>" . $form_name . " ";
        $prod_name = $material_name . " " . $material_type_name . " " . $depth . "мм. ";
        $prod_name .= $form_name . ". ";
        switch ($form) {
            case "square":
            case "other":
                $comment .= $width . " x " . $height . "мм </td></tr>";
                $prod_name .= $width . " x " . $height . "мм. ";
                //$comment .= "<tr><td>Высота:</td><td>".$height." мм</td></tr>";
                break;
            case "round":
                $comment .= $diametr . "мм</td></tr>";
                $prod_name .= $diametr . "мм. ";
                break;
        }
        if ($polirov) {
            $comment .= "<tr><td>Обработка:</td><td>" . $polirov_name . "</td></tr>";
            $prod_name .= $polirov_name . ". ";
        }
        if ($harding) {
            $comment .= "<tr><td>Закалка:</td><td>" . $harding_name . "</td></tr>";
            $prod_name .= $harding_name . ". ";
        }
        if ($otverst) {
            $comment .= "<tr><td>Отверстия:</td><td>" . $otverst_name . "</td></tr>";
            $prod_name .= $otverst_name . ". ";
        }
        if ($vyrez) {
            $comment .= "<tr><td>Вырезы:</td><td>" . $vyrez_name . "</td></tr>";
            $prod_name .= $vyrez_name . ". ";
        }
        if ($rounding) {
            $comment .= "<tr><td>Скругления:</td><td>" . $rounding_name . "</td></tr>";
            $prod_name .= $rounding_name . ". ";
        }
        if ($safety) {
            $comment .= "<tr><td>Пленка:</td><td>" . $safety_name . "</td></tr>";
            $prod_name .= $safety_name . ". ";
        }
        if ($bron) {
            $comment .= "<tr><td>Бронепленка:</td><td>" . $bron_name . "</td></tr>";
            $prod_name .= $bron_name . ". ";
        }
        if ($dostavka) {
            $comment .= "<tr><td>Доставка:</td><td>" . $dostavka_name . "</td></tr>";
        }
        $comment .= "<tr><td>Дата исполнения:</td><td>" . $date_zakaz . "</td></tr>";
        $comment .= "<tr><td>Количество:</td><td>" . $cnt . "</td></tr>";
        $comment .= "<tr><td>Рассчитанная цена:</td><td>" . $Sum . "</td></tr>";
        $comment .= "</table>";

        $prod_name .= "Количество: " . $cnt;
        $comment = "";
        if ($dostavka) {
            $comment = "Доставка: " . $dostavka_name;
        }

        $bitr_data['SOURCE_ID'] = "SELF";
        $bitr_data['TITLE']     = $user_name;
        $bitr_data['NAME']      = $user_name;
        if ($user_email && strpos($user_email, '@') !== false) {
            $bitr_data['EMAIL_HOME'] = $user_email;
        }
        $bitr_data['PHONE_WORK']        = $user_phone;
        $bitr_data['UF_CRM_1463488182'] = $id_zakaz;
        $bitr_data['OPPORTUNITY']       = $Sum;
        $bitr_data['COMMENTS']          = $comment;

        $bitr_data['PRODUCT_ADD']['PRICE'] = $Sum;
        $bitr_data['PRODUCT_ADD']['CNT']   = "1";
        $bitr_data['PRODUCT_ADD']['NAME']  = $prod_name;

        $r = bitrix24_add_lead($bitr_data);
        if ($r) {
            $r       = intval($r);
            $sql_upd = "UPDATE `r_zakaz` SET `bitrix24_lead` = '" . $r . "' WHERE `id` = '" . $id_zakaz . "' LIMIT 1 ";
            $res_upd = $DBH->query($sql_upd);
        }

        foreach ($admin_emails As $email) {
            $email = trim($email);
            notify_admin($email, $subj, $mes, $attach);
        }
        notify_admin($user_email, $subj, $mes, $attach);
        for ($i = 0; $i < count($files_arr); $i++) {
            //$files_name .= "<p><a target='_blank' href='http://".$_SERVER['HTTP_HOST']."/uploads/".$sess_id."/".$files_arr[$i]."'>".urldecode($files_arr[$i])."</a></p><br>";
            @unlink($_SERVER['DOCUMENT_ROOT'] . "/uploads/" . $sess_id . "/" . $files_arr[$i]);
            @rmdir($_SERVER['DOCUMENT_ROOT'] . "/uploads/" . $sess_id);
        }
        $data['is_err']   = 0;
        $data['id_zakaz'] = $id_zakaz;
        echo json_encode($data);
        exit;
        break;



    //вызвать замерщика
    case "action-measure":
        //пользователь
        $user_name     = trim($_REQUEST['user_name--measure']); //имя
        $user_phone    = trim($_REQUEST['user_phone--measure']); //тел
        $user_question = trim($_REQUEST['user_question--measure']); //вопрос (необязательно)

        // turn on for bots with disabled javascript to prevent spambot actions
        if ($user_name == "") {
            $data['is_err'] = 1;
            $data['err']    = "Не указано имя";
            echo json_encode($data);
            exit;
        }

        if ($user_phone == "") {
            $data['is_err'] = 1;
            $data['err']    = "Не указан телефон";
            echo json_encode($data);
            exit;
        }

        $subj = "Сообщение с сайта стекло24. Вызов замерщика";
        $mes  = "";
        $mes .= "<html>
                    <head>
                      <title>Сообщение с сайта стекло24. Вызов замерщика</title>
                    </head>
                  <body>";
        $mes .= "<table>";
        $mes .= "<tr><th colspan='2'>Данные заказчика</th></tr>";
        $mes .= "<tr><td>Имя:</td><td>" . $user_name . "</td></tr>";
        $mes .= "<tr><td>Тел.:</td><td>" . $user_phone . "</td></tr>";
        if ($user_question !== "") {
            $mes .= "<tr><td>Вопрос:</td><td>" . $user_question . "</td></tr>";
        }
        $mes .= "</table>";
        $mes .= "</body></html>";

        foreach ($admin_emails As $email) {
            $email = trim($email);
            notify_admin($email, $subj, $mes);
        }
        $data['is_err'] = 0;
        echo json_encode($data);
        exit;
        break;

    //консультация
    case "action-consult":
        //пользователь
        $user_name     = trim($_REQUEST['user_name--consult']); //имя
        $user_phone    = trim($_REQUEST['user_phone--consult']); //тел
        $user_question = trim($_REQUEST['user_question--consult']); //вопрос (необязательно)

        // turn on for bots with disabled javascript to prevent spambot actions
        if ($user_name == "") {
            $data['is_err'] = 1;
            $data['err']    = "Не указано имя";
            echo json_encode($data);
            exit;
        }

        if ($user_phone == "") {
            $data['is_err'] = 1;
            $data['err']    = "Не указан телефон";
            echo json_encode($data);
            exit;
        }

        $subj = "Сообщение с сайта стекло24. Консультация";
        $mes  = "";
        $mes .= "<html>
                    <head>
                      <title>Сообщение с сайта стекло24. Консультация</title>
                    </head>
                  <body>";
        $mes .= "<table>";
        $mes .= "<tr><th colspan='2'>Данные клиента</th></tr>";
        $mes .= "<tr><td>Имя:</td><td>" . $user_name . "</td></tr>";
        $mes .= "<tr><td>Тел.:</td><td>" . $user_phone . "</td></tr>";
        if ($user_question !== "") {
            $mes .= "<tr><td>Вопрос:</td><td>" . $user_question . "</td></tr>";
        }
        $mes .= "</table>";
        $mes .= "</body></html>";

        foreach ($admin_emails As $email) {
            $email = trim($email);
            notify_admin($email, $subj, $mes);
        }
        $data['is_err'] = 0;
        echo json_encode($data);
        exit;
        break;

    //спец-предложение
    case "action-offer":
        //пользователь
        $user_name     = trim($_REQUEST['user_name--offer']); //имя
        $user_phone    = trim($_REQUEST['user_phone--offer']); //тел
        $user_email = trim($_REQUEST['user_email--offer']); //вопрос (необязательно)
        // $user_question = trim($_REQUEST['user_question--offer']); //вопрос (необязательно)

        // turn on for bots with disabled javascript to prevent spambot actions
        if ($user_name == "") {
            $data['is_err'] = 1;
            $data['err']    = "Не указано имя";
            echo json_encode($data);
            exit;
        }

        if ($user_phone == "") {
            $data['is_err'] = 1;
            $data['err']    = "Не указан телефон";
            echo json_encode($data);
            exit;
        }

        $subj = "Сообщение с сайта стекло24. Консультация";
        $mes  = "";
        $mes .= "<html>
                    <head>
                      <title>Сообщение с сайта стекло24. Спец-предложение - заявка на расчёт</title>
                    </head>
                  <body>";
        $mes .= "<table>";
        $mes .= "<tr><th colspan='2'>Данные клиента</th></tr>";
        $mes .= "<tr><td>Имя:</td><td>" . $user_name . "</td></tr>";
        $mes .= "<tr><td>Тел.:</td><td>" . $user_phone . "</td></tr>";
        if ($user_email !== "") {
            $mes .= "<tr><td>Email:</td><td>" . $user_email . "</td></tr>";
        }
        $mes .= "</table>";
        $mes .= "</body></html>";

        foreach ($admin_emails As $email) {
            $email = trim($email);
            notify_admin($email, $subj, $mes);
        }
        $data['is_err'] = 0;
        echo json_encode($data);
        exit;
        break;


    /************** НАЙТИ ЗАКАЗ *******************/
    case "findOrder":
        $id = intval($_REQUEST['number']);

        $sql_zakaz = "SELECT * FROM `r_zakaz` WHERE `id` = '" . $id . "' LIMIT 1 ";
        $row_zakaz = $DBH->query($sql_zakaz)->fetch();

        if (!$row_zakaz) {
            $data['is_err'] = 1;
            $data['err']    = "Заказ не найден";
            echo json_encode($data);
            exit;
        }
        $row_zakaz['date'] = date('d.m.Y', strtotime($row_zakaz['date']));
        if ($row_zakaz['is_complex'] == 0) {
            $td_txt = '<div class="div_title">' . $row_zakaz['material'] . ' ' . $row_zakaz['type_material'] . '</div>
            <hr>
            <div>
             <table class="info">
              <tr class="short-hr">
               <td class="name">Количество изделий:</td><td>' . $row_zakaz['cnt'] . '</td>
              </tr>
             </table>
            </div>
            <div>
             <table class="info">
              <tr>
               <td class="name">Толщина:</td><td>' . $row_zakaz['width_material'] . ' мм</td>
              </tr>
             </table>
            </div>
            <div>
             <table class="info">
              <tr>
               <td class="name">Размеры:</td>
               <td>';
            if (intval($row_zakaz['d'])) {
                $td_txt .= 'диаметр: ' . $row_zakaz['d'];
            } else {
                $td_txt .= $row_zakaz['w'] . ' x ' . $row_zakaz['h'];
            }
            $td_txt .= ' мм</td>
              </tr>
             </table>
            </div>';
            $td_txt .= '<div>
             <table class="info">
              <tr>
               <td class="name">Дополнительно:</td>
               <td>
                <div>' . $row_zakaz['polirov'] . '</div>';
            $sql_dop = "SELECT * FROM `r_zakaz_dopolnit` WHERE `id_zakaz` = '" . $row_zakaz['id'] . "' ";
            $res_dop = $DBH->query($sql_dop);
            while ($row_dop = $res_dop->fetch()) {
                $td_txt .= '<div>';
                $td_txt .= stripslashes($row_dop['name']);
                if (intval($row_dop['cnt'])) {
                    $td_txt .= ' (' . $row_dop['cnt'] . ' шт.)';
                }
                $td_txt .= '</div>';
            }
            $td_txt .= '</td>
              </tr>
             </table>
            </div>';
        }
        if ($row_zakaz['is_complex'] == 1) {
            $td_txt = '<div class="div_title">Комплексный заказ</div>';
        }
        $sql_files_cnt = "SELECT COUNT(`id`) AS cnt FROM `r_zakaz_files` WHERE `id_zakaz` = '" . $row_zakaz['id'] . "' ";
        $row_files_cnt = $DBH->query($sql_files_cnt)->fetch();

        if ($row_files_cnt['cnt']) {
            $td_txt .= '<div>
             <table class="info">
              <tr>
               <td class="name">Макеты:</td>
               <td>';

            $sql_files = "SELECT * FROM `r_zakaz_files` WHERE `id_zakaz` = '" . $row_zakaz['id'] . "' ORDER BY `id` ";
            $res_files = $DBH->query($sql_files);
            while ($row_file = $res_files->fetch()) {
                $td_txt .= '<div>';
                $td_txt .= stripslashes($row_file['file']);
                $td_txt .= '</div>';
            }

            $td_txt .= '</td>
              </tr>
             </table>
             </div>';
        }
        $td_txt .= '<hr>
            <div>
             <table class="info">
              <tr>
               <td class="name">Доставка:</td><td>' . $row_zakaz['dostavka_addr'] . '</td>
              </tr>
             </table>
            </div>
            <div>
             <table class="info">
              <tr>
               <td class="name">Время готовности заказа:</td><td>' . $row_zakaz['date'] . '</td>
              </tr>
             </table>
            </div>';
        if (strip_tags($row_zakaz['comment']) != "") {
            $comment_text = ($row_zakaz['is_complex'] == 1) ? 'Состав' : 'Комментарий';
            $td_txt .= '<hr>
            <div>
             <table class="info">
              <tr>
               <td class="name">' . $comment_text . ':</td><td>' . $row_zakaz['comment'] . '</td>
              </tr>
             </table>
            </div>';

        }
        $data['zakaz']             = $row_zakaz;
        $data['td_txt']            = $td_txt;
        //shop
        $time                      = time();
        //$row_zakaz['id'] = md5($time);
        $shop['shop_id']           = $SHOP_ID;
        $shop['amount']            = $row_zakaz['sum'] * 100;
        $shop['order_number']      = $row_zakaz['id'];
        $shop['order_description'] = $row_zakaz['material'] . ' ' . $row_zakaz['type_material'];
        $shop['client_name']       = $row_zakaz['name'];
        $shop['client_phone']      = $row_zakaz['phone'];
        $shop['client_email']      = $row_zakaz['email'];
        $shop['signature']         = strtoupper(md5(strtoupper(md5($Shop_sign) . md5($SHOP_ID . $row_zakaz['id'] . $shop['amount']))));
        $data['shop']              = $shop;

        $data['is_err'] = 0;
        echo json_encode($data);
        exit;
        break;

    /************** ВРЕМЕННО ИЛИ НАВСЕГДА НЕАКТУАЛЬНЫЕ таски *******************/
    //задать вопрос
    case "sendQuestion":
        //пользователь
        $user_name  = trim($_REQUEST['name_user']); //имя
        $user_phone = trim($_REQUEST['phone_user']); //тел
        $user_email = trim($_REQUEST['email_user']); //email
        $question   = trim($_REQUEST['question']); //вопрос

        if ($user_name == "") {
            $data['is_err'] = 1;
            $data['err']    = "Не указано имя";
            echo json_encode($data);
            exit;
        }

        if ($user_phone == "") {
            $data['is_err'] = 1;
            $data['err']    = "Не указан телефон";
            echo json_encode($data);
            exit;
        }

        $subj = "Сообщение с сайта стекло24. Вопрос";
        $mes  = "";
        $mes .= "<html>
                    <head>
                      <title>Сообщение с сайта стекло24. Вопрос</title>
                    </head>
                  <body>";
        $mes .= "<table>";
        $mes .= "<tr><th colspan='2'>Данные заказчика</th></tr>";
        $mes .= "<tr><td>Имя:</td><td>" . $user_name . "</td></tr>";
        $mes .= "<tr><td>Тел.:</td><td>" . $user_phone . "</td></tr>";
        $mes .= "<tr><td>Email:</td><td>" . $user_email . "</td></tr>";
        $mes .= "<tr><td>Вопрос:</td><td>" . $question . "</td></tr>";
        $mes .= "</table>";
        $mes .= "</body></html>";

        foreach ($admin_emails As $email) {
            $email = trim($email);
            notify_admin($email, $subj, $mes);
        }
        $data['is_err'] = 0;
        echo json_encode($data);
        exit;
        break;
    //заказать звонок
    case "sendQuickCall":
          //пользователь
          $user_name  = trim($_REQUEST['name_user']); //имя
          $user_phone = trim($_REQUEST['phone_user']); //тел

          if ($user_name == "") {
              $data['is_err'] = 1;
              $data['err']    = "Не указано имя";
              echo json_encode($data);
              exit;
          }

          if ($user_phone == "") {
              $data['is_err'] = 1;
              $data['err']    = "Не указан телефон";
              echo json_encode($data);
              exit;
          }

          $subj = "Сообщение с сайта стекло24. Заявка на звонок";
          $mes  = "";
          $mes .= "<html>
                      <head>
                        <title>Сообщение с сайта стекло24. Заявка на звонок</title>
                      </head>
                    <body>";
          $mes .= "<table>";
          $mes .= "<tr><th colspan='2'>Данные заказчика</th></tr>";
          $mes .= "<tr><td>Имя:</td><td>" . $user_name . "</td></tr>";
          $mes .= "<tr><td>Тел.:</td><td>" . $user_phone . "</td></tr>";
          $mes .= "</table>";
          $mes .= "</body></html>";

          foreach ($admin_emails As $email) {
              $email = trim($email);
              notify_admin($email, $subj, $mes);
          }
          $data['is_err'] = 0;
          echo json_encode($data);
          exit;
          break;

}
exit;

?>
