<?php

//  METHODS IN THIS CLASS:
//    se_admin()
//    admin_login()
//    admin_setcookies()
//    admin_clear()
//    admin_logout()
//    admin_create()


class se_admin {

	// INITIALIZE VARIABLES
	var $is_error;			// DETERMINES WHETHER THERE IS AN ERROR OR NOT
	var $error_message;		// CONTAINS RELEVANT ERROR MESSAGE
	var $admin_exists;		// DETERMINES WHETHER WE ARE EDITING AN EXISTING admin OR NOT

	var $admin_info;			// CONTAINS admin'S INFORMATION FROM SE_adminS TABLE
	
	// OUTPUT:
	function se_admin($admin_unique = Array('0', '')) {
	  global $DBH,$class_admin;

	  // SET VARS
	  $this->is_error = 0;
	  $this->error_message = "";
	  $this->admin_exists = 0;
	  $this->admin_info['admin_id'] = 0;

	  // VERIFY admin_ID/admin_adminNAME/admin_EMAIL IS VALID AND SET APPROPRIATE OBJECT VARIABLES
	  if(@$admin_unique[0] != 0 | @$admin_unique[1] != "") {

	    // SET adminNAME AND EMAIL TO LOWERCASE
	    $admin_login = mysql_real_escape_string(strtolower(@$admin_unique[1]));
	    // SELECT admin USING SPECIFIED SELECTION PARAMETER
	    //$sql = "SELECT * FROM `admin` WHERE `id`='".intval($admin_unique[0])."' OR `login` = '".$admin_login."' LIMIT 1";
	    //echo $sql;
	    //$admin = $database->database_query($sql);
      /*
      if($database->database_num_rows($admin) == 1) {
	      $this->admin_exists = 1;
	      $this->admin_info = $database->database_fetch_assoc($admin);
      }
      */	  
      $sql = "SELECT * FROM `admins` WHERE `id`='".intval($admin_unique[0])."' OR `login` = '".$admin_login."' LIMIT 1";
      //echo $sql;
      $admin = $DBH->query($sql);

      if($admin->rowCount() == 1){
       $this->admin_exists = 1;
       //$this->admin_info['admin_id'] = 1;
       //$this->admin_info['password'] = 'yapass';
       $this->admin_info = $admin->fetch();
	     //$this->admin_info = $database->database_fetch_assoc($admin);
      }
    }

	} // END se_admin() METHOD


	// THIS METHOD TRIES TO LOG A admin IN IF THERE IS NO ERROR
	// INPUT: $email REPRESENTING THE LOGIN EMAIL
	//	  $password REPRESENTING THE LOGIN PASSWORD
	// OUTPUT:
	function admin_login($login, $password) {
	  global $class_admin;

    $this->se_admin(Array(0, $login));

	  $login_result = 0;
   
   if($this->admin_exists == 0) {
	    $this->is_error = 1;
	    $this->error_message = "Пользователь с таким логином не зарегистрирован";

	  // VALIDATE PASSWORD
	  } elseif((str_replace(" ", "", $password) == "" | $password != $this->admin_info['password'])) {
	    $this->is_error = 1;
	    $this->error_message = "Неверный пароль";

	  } else {

	    // SET LOGIN RESULT VAR
	    $login_result = 1;

	    // LOG admin IN
	    $this->admin_setcookies();

	  }

	} // END admin_login() METHOD

	// THIS METHOD SETS admin LOGIN COOKIES
	// INPUT: $persistent (OPTIONAL) REPRESENTING WHETHER THE COOKIES SHOULD BE PERSISTENT OR NOT
	// OUTPUT:
	function admin_setcookies($logout=0) {

    global $class_admin;
    if($logout == 0){
	   //setcookie("user_id", $this->user_info[id], time() + 60*60*24*365, "/");
	    $_SESSION['admin_id'] = $this->admin_info['id'];   
      $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
	  }
	  else{
	    //session_start();  
      //session_destroy();
      //session_unregister('admin_id');
      unset($_SESSION['admin_id']);
    }
	  
	} // END admin_setcookies() METHOD

  function admin_checkCookies() {
	  if(isset($_SESSION['admin_id']) && intval($_SESSION['admin_id'])) {

	    // GET admin ROW IF AVAILABLE
	    $admin_id = $_SESSION['admin_id'];
	    $this->se_admin(Array($admin_id));
	    // VERIFY admin EXISTS, LOGIN COOKIE VALUES ARE CORRECT, AND EMAIL HAS BEEN VERIFIED - ELSE RESET admin CLASS
	    if($this->admin_exists == 0 ) {
	      $this->admin_clear();
	    }
	  }

} // END admin_checkCookies() METHOD



	// THIS METHOD CLEARS ALL THE CURRENT OBJECT VARIABLES
	// INPUT:
	// OUTPUT:
	function admin_clear() {
	  $this->is_error = 0;
	  $this->error_message = "";
	  $this->admin_exists = 0;

	  $this->admin_info = "";
	  
	} // END admin_clear() METHOD








	// THIS METHOD LOGS A admin OUT
	// INPUT:
	// OUTPUT:
	function admin_logout() {
    $logout = 1;
	  
    $this->admin_clear();
	  $this->admin_setcookies($logout);
	} // END admin_logout() METHOD

 }
?>
