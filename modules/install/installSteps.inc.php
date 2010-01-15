<?php

@session_start();

function showInstallWellcome() {
	$output = "This is the installer of phanet, you will be asked for database connection info and other parameters.";
	$output .= "<input type=\"submit\" value=\"Start Install\" name=\"installButton\">";                        
	
	installTemplate( $output, 1 );
}

function showDataForm() {

	$output  = "<div class=\"installBlock\">";
	$output .= "Database connection info:  ";                                          
		$output .= "<select name='db_type'>";
			$output .= "<option value='mysql'>MySQL</option>";
	//$output .= "<option value='mysqli'>MySQLi</option>";
	//$output .= "<option value='pgsql'>PostgreSQL</option>";
		$output .= "</select><br/><br/>";
	
		$output .= "Database Host: <input type='text' name='db_host' value=''><br/>";
		$output .= "Database Name: <input type='text' name='db_name' value=''><br/>";
		$output .= "Database User: <input type='text' name='db_user' value=''><br/>";
		$output .= "Database Pass: <input type='password' name='db_pass' value=''><br/>";
		$output .= "Table Prefix: <input type='text' name='db_prefix' value='ph1_'><br/>";
		$output .= "<br/>";
	$output .= "</div>";
	
/*
	$output .= "<div class=\"installBlock\">";
		$output .= "<br/>";
		$output .= "Smtp Host: <input type='text' name='smtp_host' value=''><br/>";
		$output .= "Smtp User: <input type='text' name='smtp_user' value=''><br/>";
		$output .= "Smtp Pass: <input type='password' name='smtp_pass' value=''><br/>";
		$output .= "Smtp Sender email: <input type='text' name='smtp_sender' value=''><br/>";
		$output .= "<label for='smtp_auth'>";
		$output .= "<input id='smtp_auth' name='smtp_auth' type='checkbox' value='enabled'/>";
		$output .= "Use smtp auth";
		$output .= "</label><br/>";
	$output .= "</div>";
*/
	
	$output .= "<div class=\"installBlock\">";
		$output .= "<br/>";
		$output .= "Administrator User: <input type='text' name='admin_user' value=''><br/>";
		$output .= "Administrator Pass: <input type='password' name='admin_pass' value=''><br/>";
		$output .= "Administrator Email: <input type='text' name='admin_email' value=''><br/>";
		$output .= "Language: <input type='text' name='language' value=''><br/>";
		$output .= "<label for='mod_rewrite'>";
		$output .= "<input id='mod_rewrite' name='mod_rewrite' type='checkbox'  value='enabled'/ >";
		$output .= "Use mod_rewrite";
		$output .= "</label><br/>";
		$output .= "<br/>";
		$output .= "<br/>";
		$output .= "<input type=\"submit\" value=\"Save Settings\" name=\"installButton\">";  
	$output .= "</div>";
            
	installTemplate( $output, 2 );   
}

function saveSettings() {

	// retreive values from post env
	$db['server']	= addslashes($_POST['db_host']);
	$db['user']		= addslashes($_POST['db_user']);
	$db['password']	= addslashes($_POST['db_pass']);
	$db['type']		= addslashes($_POST['db_type']);
	$db['database']	= addslashes($_POST['db_name']);
	$db['prefix']	= addslashes($_POST['db_prefix']);

	// put the admin username and password in session, to be retreived later
	$_SESSION['admin_user']	 = $_POST['admin_user'];
	$_SESSION['admin_pass']	 = $_POST['admin_pass'];
	$_SESSION['admin_email'] = $_POST['admin_email'];


	$_SESSION['mod_rewrite'] = $_POST['mod_rewrite'];
	
	$_SESSION['language']	= $_POST['language'];

	$_SESSION['smtp_auth'] = $_POST['smtp_auth'];
	
	$_SESSION['smtp_host'] = $_POST['smtp_host'];
	$_SESSION['smtp_sender'] = $_POST['smtp_sender'];
	$_SESSION['smtp_user'] = $_POST['smtp_user'];
	$_SESSION['smtp_pass'] = $_POST['smtp_pass'];
	$_SESSION['smtp_port'] = $_POST['smtp_port'];
	
	/**
	*initializing text of setting.inc.php file
	*/
	$settingsfile="<?php\n".
			"\$SETTINGS['db_type'] 		= '$db[type]';\n".
			"\$SETTINGS['db_server'] 	= '$db[server]';\n".
			"\$SETTINGS['db_user']		= '$db[user]';\n".
			"\$SETTINGS['db_password']	= '$db[password]';\n".
			"\$SETTINGS['db_database']	= '$db[database]';\n".
			"\$SETTINGS['db_prefix']	= '$db[prefix]';\n";
	/**
	*we try opening the file for write
	*/
	
	$fp	= @fopen("settings.inc.php",'w');

	if(!$fp) {
		/**
		*ouch ! we can't write this file, we show the user what he should do.
		*/
		$output	 = "******** WARNING ********<br>";
		$output	.= "unable to create new settings file! Please check write permissions and repeat installation.<br>";
		$output	.= "------- or -------<br>";
		$output	.= "before you press the next button add the following text to a file called: settings.inc.php in your site root directory:<br><br>";      
		$output	.= str_replace("\n", "<br>", str_replace("<", "&lt;", $settingsfile));
	} else {
		$output	 = "Settings file created sucessfully.";
		fwrite($fp,$settingsfile);
		fclose($fp);
	}
	
	$output .= "<input type=\"submit\" value=\"Create Tables\" name=\"installButton\">";
	installTemplate( $output, 3 ); 
}

function createTables(){
	global $TABLES, $stgs;	
	global $srv, $active_db, $ptdb;

	$create = True;

	/**
	*Checking existance of settings.inc.php file
	*without it I have no chance to connect to DB
	*/
	if (! file_exists("settings.inc.php")) {
		/**
		*inform the user we cannot proceed
		*/
		$output  = "***** ERROR *****<br>File settings.inc.php not found !<br>You have to repeat install process and read carefully !";
		$output .= "<a href=\"".$srv->getInstallRadix()."\">Restart Install Process</a>";
		installTemplate( $output, 4 );
		return False;
	} 
	
	$report = "";
	/**
	*cycle in $TABLES array wich contains a list of tables to create.
	*/
	foreach ( $TABLES as $k => $TABLE ){
             
		$drop="";
                // if a mysql db, I drop it first.
		if( $stgs->getConf('db_type') == "mysql" || $stgs->getConf('db_type') == "mysqli") {
			$report .= addQueryExecution(
				rewrite_query("DROP TABLE IF EXISTS {".$TABLE[name]."};"),
				"-- cleaning $k (".rewrite_query("{".$TABLE[name]."}").") ... ");
		}
                 
		$report .= addQueryExecution(
			rewrite_query(db_createTable($TABLE)),
			"<br><span style='color: #990a00;'>-- Creating table $k (".rewrite_query("{".$TABLE[name]."}").") ... </span>");

		/**
		*adding default data for this tables
		*/
		$fields=array();                 
		if($TABLE['rows']){	
						
			foreach($TABLE['rows'] as $row){
				
				$fields=array();
				
				foreach($row as $field){
					$fields[]=$field;
				}

				$res = addQueryExecution(
					rewrite_query("INSERT INTO {".$TABLE[name]."} VALUES (".implode(", ",$fields).");"),
							"-- adding data ... ");

				$report .= $res;
			}
		}
	}

	return $report;
}

function addQueryExecution( $sql, $reportToAdd ){
	global  $ptdb, $errorState;
         
        $preOkTxt="";
        $postOkTxt="OK !<br>";
        
        $preNotOkTxt="";
        $postNotOkTxt="NOT OK !<br>";
		
	
        if ( $ptdb->query($sql) && ($ptdb->dbcon)) {
                $reportToAdd = $preOkTxt.$reportToAdd.$postOkTxt;
        } else {
                $reportToAdd = $preNotOkTxt.$reportToAdd.$postNotOkTxt;
                $errorState=1;
        }

	return $reportToAdd;

}


function createAdmin(){
	global $TABLES;	
	global $ptdb;

	$create = True;


	$report = addQueryExecution(
		rewrite_query("INSERT INTO {users} ( `id` ,`nickname` ,`password` ,`fullname` ,`email` ,`website` ,`author_id` ,`status`,`usertype` ) VALUES (NULL,'".addslashes($_SESSION['admin_user'])."','".md5($_SESSION['admin_pass'])."','','".addslashes($_SESSION['admin_email'])."','',0,'E','A');"),
		"-- Creating admin ".$_SESSION['admin_user']." ... "
	);

	if (!$_SESSION['mod_rewrite'] == "enabled") $_SESSION['mod_rewrite'] = "disabled";
	
	$report .= addQueryExecution(
		rewrite_query("UPDATE {settings} SET value='".$_SESSION['mod_rewrite']."' WHERE keyid='rewrite_url';"),
		"-- Setting mod_rewrite abilitation ... "
	);

	$report .= addQueryExecution(
		rewrite_query("INSERT INTO {settings} ( `keyid` ,`value` ) VALUES ('language','".addslashes($_SESSION['language'])."');"),
		"-- Setting language ".$_SESSION['language']." ... "
	);

    // SMTP SETTINGS
    $report .= addQueryExecution(
		rewrite_query("INSERT INTO {settings} ( `keyid` ,`value` ) VALUES ('smtp_host','".addslashes($_SESSION['smtp_host'])."');"),
		"-- Setting smtp host ".$_SESSION['smtp_host']." ... "
	);
	
	$report .= addQueryExecution(
		rewrite_query("INSERT INTO {settings} ( `keyid` ,`value` ) VALUES ('smtp_user','".addslashes($_SESSION['smtp_user'])."');"),
		"-- Setting smtp username ".$_SESSION['smtp_user']." ... "
	);
	
	$report .= addQueryExecution(
		rewrite_query("INSERT INTO {settings} ( `keyid` ,`value` ) VALUES ('smtp_pass','".addslashes($_SESSION['smtp_pass'])."');"),
		"-- Setting smtp password ******** ... "
	);
	
	$report .= addQueryExecution(
		rewrite_query("INSERT INTO {settings} ( `keyid` ,`value` ) VALUES ('smtp_port','".addslashes($_SESSION['smtp_port'])."');"),
		"-- Setting smtp port ... "
	);
	
	$report .= addQueryExecution(
		rewrite_query("INSERT INTO {settings} ( `keyid` ,`value` ) VALUES ('smtp_sender','".addslashes($_SESSION['smtp_sender'])."');"),
		"-- Setting sender ".$_SESSION['smtp_sender']." ... "
	);
    
	if (!$_SESSION['smtp_auth'] == "enabled") $_SESSION['smtp_auth'] = "disabled";
	
	$report .= addQueryExecution(
		rewrite_query("INSERT INTO {settings} ( `keyid` ,`value` ) VALUES ('smtp_auth','".addslashes($_SESSION['smtp_auth'])."');"),
		"-- Setting smtp_auth abilitation ... "
	);

	return $report;
}

function showCreation() {
	global $srv;
	
	if ( ($tablesReport = createTables()) && ( $adminReport = createAdmin() ) ) {
		$output  = "Perfect!! The tables have been created. Now go to "; 
		$output .= "<a href=\"".$srv->buildUrl("?admin=")."\">Admin</a> and start feeding<br><br>";
		$output .= $tablesReport.$adminReport;
		installTemplate( $output, 4 );
	} else {
		$output = "There were errors during the installation.... Please try again!!";
		installTemplate( $output, 4);
	}
}
