<?php
session_start();
// A list of permitted file extensions
//$allowed = array('png', 'jpg', 'gif','zip');
function translit($str) {
 $str = trim($str);
 $tr = array(
	            "А"=>"a",
	            "Б"=>"b",
	            "В"=>"v",
	            "Г"=>"g",
	            "Д"=>"d",
              "Е"=>"e",
              "Ё"=>"e",
	            "Ж"=>"j",
	            "З"=>"z",
	            "И"=>"i",
	            "Й"=>"y",
	            "К"=>"k",
	            "Л"=>"l",
	            "М"=>"m",
	            "Н"=>"n",
	            "О"=>"o",
	            "П"=>"p",
	            "Р"=>"r",
	            "С"=>"s",
	            "Т"=>"t",
	            "У"=>"u",
	            "Ф"=>"f",
	            "Х"=>"h",
	            "Ц"=>"ts",
	            "Ч"=>"ch",
	            "Ш"=>"sh",
	            "Щ"=>"sch",
	            "Ъ"=>"",
	            "Ы"=>"i",
	            "Ь"=>"j",
	            "Э"=>"e",
	            "Ю"=>"yu",
	            "Я"=>"ya",
	            "а"=>"a",
	            "б"=>"b",
	            "в"=>"v",
	            "г"=>"g",
	            "д"=>"d",
	            "е"=>"e",
	            "ё"=>"e",
	            "ж"=>"j",
	            "з"=>"z",
	            "и"=>"i",
	            "й"=>"y",
	            "к"=>"k",
	            "л"=>"l",
	            "м"=>"m",
	            "н"=>"n",
	            "о"=>"o",
	            "п"=>"p",
	            "р"=>"r",
	            "с"=>"s",
	            "т"=>"t",
	            "у"=>"u",
	            "ф"=>"f",
	            "х"=>"h",
	            "ц"=>"ts",
	            "ч"=>"ch",
	            "ш"=>"sh",
	            "щ"=>"sch",
	            "ъ"=>"y",
	            "ы"=>"i",
	            "ь"=>"j",
	            "э"=>"e",
	            "ю"=>"yu",
	            "я"=>"ya",
	            " "=> "_",
	            //"."=> "",
	            "/"=> "_",
	            ","=>"_",
	            "-"=>"_",
              "("=>"",
	            ")"=>"",
	            "["=>"",
	            "]"=>"",
	            "="=>"_",
	            "+"=>"_",
	            "*"=>"",
	            "?"=>"",
	            "\""=>"",
	            "'"=>"",
	            "&"=>"",
	            "%"=>"",
	            "#"=>"",
	            "@"=>"",
	            "!"=>"",
	            ";"=>"",
	            "№"=>"",
	            "^"=>"",
	            ":"=>"",
	            "~"=>"",
	            "\\"=>""
	        );
	        return strtr($str,$tr);
}

if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){
	$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);
  $f_name = translit($_FILES['upl']['name']);
  $f_name = urlencode($f_name);
  /*
	if(!in_array(strtolower($extension), $allowed)){
		echo '{"status":"error"}';
		exit;
	}
  */
  $sess_id = session_id();
  //@mkdir("./uploads/". $sess_id);
  @mkdir("./uploads/" . $sess_id);
	if(move_uploaded_file($_FILES['upl']['tmp_name'], 'uploads/' . $sess_id . "/" . $f_name)){
		echo '{"status":"success"}';
		exit;
	}
}

echo '{"status":"error"}';
exit;