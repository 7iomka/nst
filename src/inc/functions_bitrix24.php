<?php
//session_start();
//пользовательские поля
//UF_CRM_1463488182 - id заказа на сайте
/**
 *домен
 */
define('CLIENT_DOMAIN', 'steklo24.bitrix24.ru');

/**
 * client_login/pass
 */
define('CLIENT_LOGIN', 'zakh.erm@gmail.com'); // login of a CRM user able to manage leads
define('CLIENT_PASSWORD', '7A5F92CC'); // password of a CRM user

/**
 * client_id приложения
 */
define('CLIENT_ID', 'local.573196a417a899.77726173');
/**
 * client_secret приложения
 */
define('CLIENT_SECRET', 'a9e85303aff941102baaa65f7d641512');
/**
 * относительный путь приложения на сервере
 */
define('PATH', '/leads/index.php');
/**
 * полный адрес к приложения
 */
//define('REDIRECT_URI', 'http://xn--24-mlcufsri.xn--80adxhks'.PATH);
define('REDIRECT_URI', 'http://стекло24.москва'.PATH);
/**
 * scope приложения
 */
define('SCOPE', 'crm,log,user');

/**
 * протокол, по которому работаем. должен быть https
 */
define('PROTOCOL', "https");

/**
 * Производит перенаправление пользователя на заданный адрес
 *
 * @param string $url адрес
 */
function redirect($url)
{
	Header("HTTP 302 Found");
	Header("Location: ".$url);
	die();
}

/**
 * Совершает запрос с заданными данными по заданному адресу. В ответ ожидается JSON
 *
 * @param string $method GET|POST
 * @param string $url адрес
 * @param array|null $data POST-данные
 *
 * @return array
 */
function auth_query($method, $url, $data = null)
{
	
	$query_data = "";

	$curlOptions = array(
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_COOKIESESSION => true,
		CURLOPT_COOKIEJAR =>  "bitrix24.txt",
		CURLOPT_COOKIEFILE => "bitrix24.txt",
		CURLOPT_FOLLOWLOCATION => true		
	);

	if($method == "POST")
	{
		$curlOptions[CURLOPT_POST] = true;
		$curlOptions[CURLOPT_POSTFIELDS] = http_build_query($data);
	}
	elseif(!empty($data))
	{
		$url .= strpos($url, "?") > 0 ? "&" : "?";
		$url .= http_build_query($data);
	}
    //echo $url;exit;
	
	//var_dump($url);
	
	$curl = curl_init($url);
	curl_setopt_array($curl, $curlOptions);
	$result = curl_exec($curl);
	//var_dump($result);
	return $result;
}


/**
 * Совершает запрос с заданными данными по заданному адресу. В ответ ожидается JSON
 *
 * @param string $method GET|POST
 * @param string $url адрес
 * @param array|null $data POST-данные
 *
 * @return array
 */
function query($method, $url, $data = null)
{
	
	$query_data = "";

	$curlOptions = array(
		CURLOPT_RETURNTRANSFER => true,
		//CURLOPT_COOKIESESSION => true,
		//CURLOPT_COOKIEJAR =>  "bitrix24.txt",
		//CURLOPT_COOKIEFILE => "bitrix24.txt",
		CURLOPT_FOLLOWLOCATION => true		
	);

	if($method == "POST")
	{
		$curlOptions[CURLOPT_POST] = true;
		$curlOptions[CURLOPT_POSTFIELDS] = http_build_query($data);
	}
	elseif(!empty($data))
	{
		$url .= strpos($url, "?") > 0 ? "&" : "?";
		$url .= http_build_query($data);
	}
    //echo $url;exit;
	$curl = curl_init($url);
	curl_setopt_array($curl, $curlOptions);
	$result = curl_exec($curl);    
	return json_decode($result, 1);
}

/**
 * Вызов метода REST.
 *
 * @param string $domain портал
 * @param string $method вызываемый метод
 * @param array $params параметры вызова метода
 *
 * @return array
 */
function call($domain, $method, $params)
{
	return query("POST", PROTOCOL."://".$domain."/rest/".$method, $params);
}

@unlink("bitrix24.txt");
function bitrix24_add_lead($leadData){
 $params = array(
		"AUTH_FORM" => "Y",
		"TYPE" => "AUTH",
		"USER_LOGIN" => CLIENT_LOGIN,
		"USER_PASSWORD" => CLIENT_PASSWORD,
		"backurl" => "/oauth/authorize/?response_type=code&client_id=".CLIENT_ID."&redirect_uri=".REDIRECT_URI
	);
	//$path = "/oauth/authorize/";
	$path = "/auth/";

 $code = auth_query("POST", PROTOCOL."://".CLIENT_DOMAIN . $path, $params);
 //var_dump($code);

 $params = array(
		"grant_type" => "authorization_code",
		"client_id" => CLIENT_ID,
		"client_secret" => CLIENT_SECRET,
		"redirect_uri" => REDIRECT_URI,
		"scope" => SCOPE,
		"code" => $code,
	);
 $path = "/oauth/token/";

 $query_data = query("GET", PROTOCOL."://".CLIENT_DOMAIN.$path, $params);
 $acces_token = $query_data['access_token'];
 //var_dump($acces_token);
 //$data = call(CLIENT_DOMAIN, "crm.lead.fields", array(
 $data = call(CLIENT_DOMAIN, "crm.contact.add", array(
				"auth" => $acces_token,
				"fields" => Array(
							"NAME" => $leadData['NAME'],
							"SOURCE_ID" => $leadData['SOURCE_ID'],
							"HAS_PHONE" => "Y",
							"HAS_EMAIL" => "Y",
							//"PHONE" => "12345",
							//"PHONE_WORK" => "1234",
							"PHONE" => Array(0 => Array("VALUE"=>$leadData['PHONE_WORK'],"VALUE_TYPE"=>"WORK")),
							"EMAIL" => Array(0 => Array("VALUE"=>$leadData['EMAIL_HOME'],"VALUE_TYPE"=>"WORK"))
							)
				)
			);

 $id_contact = intval($data['result']);

 $data = call(CLIENT_DOMAIN, "crm.lead.add", array(
				"auth" => $acces_token,
				"fields" => Array(
							"TITLE" => $leadData['NAME'],
                            "NAME" => $leadData['NAME'],
							"SOURCE_ID" => $leadData['SOURCE_ID'],
							"CONTACT_ID" => $id_contact,
                            "HAS_PHONE" => "Y",
							"HAS_EMAIL" => "Y",
							"PHONE" => Array(0 => Array("VALUE"=>$leadData['PHONE_WORK'],"VALUE_TYPE"=>"WORK")),
							"EMAIL" => Array(0 => Array("VALUE"=>$leadData['EMAIL_HOME'],"VALUE_TYPE"=>"WORK")),
                            'UF_CRM_1463488182' => $leadData['UF_CRM_1463488182'],
                            'OPPORTUNITY' => $leadData['OPPORTUNITY'],
                            'COMMENTS' => $leadData['COMMENTS']
							)
				)
			);
 $id_lead = intval($data['result']);
  $data = call(CLIENT_DOMAIN, "crm.lead.productrows.set", array(
				"auth" => $acces_token,
				"id" => $id_lead,
				"rows" => Array(
                        0 => Array(
                            //"PRODUCT_ID" => 10,
                            "PRODUCT_NAME" => $leadData['PRODUCT_ADD']['NAME'],
                            "PRICE" => $leadData['PRODUCT_ADD']['PRICE']
                        )
                    )				
				)
			);
 return($id_lead);
}
?>