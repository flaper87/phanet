<?php

@session_start();

require_once ("login.inc.php");
require_once ("header.inc.php");
require_once ("adminLoader.inc.php");
require_once ("adminTemplates.inc.php");

class adminCore {

	/**
	 * @var string The requested page (template)
	 */
	private $reqPage;
	
	/**
	 * @var string The requested admin action
	 */
	private $reqAction;
	
	/**
	 * @var string The requested id to handle
	 */
	private $reqId;
	
	private $tmpTer;
	
	function adminCore() {
		global $admldr;
		
		$this->tmpTer = new tmpTer();
		
		$this->admldr = $admldr;
	}
	
	function loadAdmin() {
		global $srv;
		//Let's be sure there's not a 404...
		if ($srv->isRewrite && preg_match("%admin/".$_GET['admin']."/(\w)%is",$srv->reqPath)) manage_error(404);

		$this->callAction();
		
		$this->loadTemplate();
	}
	
	private function loadTemplate() {
		$this->tmpTer->loadTemplate( $this->reqPage = $_GET['admin']);
	}
	
	private function callAction() {
		//if (!$this->reqAction = $_GET['action']) return;

		if (isset($_GET['update'])) $function = "update".ucwords($_GET['update']);
		if (isset($_GET['change'])) $function = "change".ucwords($_GET['change']);
		if (isset($_GET['add']))	$function = "add".ucwords($_GET['add']);
		if (isset($_GET['check']))	$function = "check".ucwords($_GET['check']);
		if (isset($_GET['remove']))	$function = "remove".ucwords($_GET['remove']);
		
		if ($function) $this->$function();
	}
	
	private function updateWidget() {
		global $ptdb;
		
		$enWidgets = $this->admldr->getEnWidgets();
		
		for ($i=0;$i<count($_GET['itArr']);$i++) {
			foreach ($enWidgets as $widget) {
				if ( $widget['name'] == $_GET['itArr'][$i]) {
					$tmp[$i]['name'] = $widget['name'];
					$tmp[$i]['path'] = $widget['path'];
				}
			}
		}
		
		foreach ( $tmp as $key => $widget ) {
			$toString[] = "[".$widget['name'].": {".$key."}{".$widget['path']."}{}{}]";
		}
		
		$query = "UPDATE {settings} SET value='{".join('',$toString)."}' WHERE keyid='sidebar_widgets'";
		$ptdb->query($query);
	}
	
	private function removeWidget() {
		global $srv, $ptdb;
		
		$enWidgets = $this->admldr->getEnWidgets();
		
		$j=100;
		foreach ($enWidgets as $pos => $widget ) {
			if ( $widget['name'] == $_GET['wName']) {
				$j = $pos;
				unset($enWidgets[$pos]);
			} else if ( $pos > $j ) {
				$enWidgets[$pos-1] = $enWidgets[$pos];
				unset($enWidgets[$pos]);
			}		
		}
		
		foreach ( $enWidgets as $key => $widget ) {
			$tmp[] = "[".$widget['name'].": {".$key."}{".$widget['path']."}{}{}]";
		}
		

		$query = "UPDATE {settings} SET value='{".join('',$tmp)."}' WHERE keyid='sidebar_widgets'";
		$ptdb->query($query);
		$srv->init();
	}
	
	private function addWidget() {
		global $ptdb, $srv;
		
		$enWidgets = $this->admldr->getEnWidgets();
		
		if ( $_GET['wPos']) {
			foreach ( $enWidgets as $key => $value ) {
				if ( $key < $_GET['wPos'] ) {
					$head[$key] = $value;
				} else {
					$tail[$key] = $value;
				}
			}
			
			$enWidgets[$_GET['wPos']]['name'] = $_GET['wName'];
			$enWidgets[$_GET['wPos']]['path'] = $_GET['wPath'];
			
			if ($tail) {
				foreach ( $tail as $key => $value ) {
					$enWidgets[$key+1] = $value;	
				}
			}
		} else {
			$pos = count($enWidgets);
			$enWidgets[$pos]['name'] = $_GET['wName'];
			$enWidgets[$pos]['path'] = $_GET['wPath'];
		}

		foreach ( $enWidgets as $key => $widget ) {
			$tmp[] = "[".$widget['name'].": {".$key."}{".$widget['path']."}{}{}]";
		}

		$query = "UPDATE {settings} SET value='{".join('',$tmp)."}' WHERE keyid='sidebar_widgets'";
		$ptdb->query($query);
		$srv->init();
	} 
	
	private function updateWidgets() {
		
		( $_POST['widgetCheck'] == "on")?$widgetizer = "enabled":$widgetizer = "disabled";

		$this->updateOptions( array(
				'widgetizer'   => $widgetizer
				) );	
	}
	
	private function updateAuthors(){
		global $srv, $ptdb;
		
		if (isset($_POST['cancel'])) return;
		
		if ( $_POST[authorId] != NULL ) {
			$query = "UPDATE {authors}". 
					" SET nickname='".fixApostrofe($_POST['authorNickname'])."',". 
					" email='".fixApostrofe($_POST['authorEmail'])."', website='".fixApostrofe($_POST['authorWebsite'])."'". 
					" WHERE id= $_POST[authorId]";
		} else {
			$query = "INSERT INTO {authors} (nickname, email, website, state) 
					VALUES ('$_POST[authorNickname]',
					'$_POST[authorEmail]', '$_POST[authorWebsite]', 'enabled')";
		}			
		
		$ptdb->query($query);
		
		header("Location: ".$srv->buildUrl("?admin=authors"));
	}
	
	private function updateBlogs(){
		global $srv, $ptdb;
		
		if (isset($_POST['cancel'])) return;
		
		if (isset($_POST['existingOwner'])) {
			$ptdb->query("SELECT * FROM {owners} WHERE id=".$_POST['selectedOwner']);
			$owner = $ptdb->fetchArray();
			$ownerID = $owner[0]['id'];
			$ownerNick = $owner[0]['nickname'];
			$ownerName = $owner[0]['fullname'];
			$ownerEmail = $owner[0]['email'];
		} else {
			$ownerID = $_POST['blogOwnerId'];
			$ownerNick = $_POST['blogOwnerNickname'];
			$ownerName = $_POST['blogOwnerName'];
			$ownerEmail = $_POST['blogOwnerEmail'];
		}
		
		if ( $ownerID ) {
			$query = "UPDATE {owners} SET nickname='".fixApostrofe($ownerNick)."', fullname='".fixApostrofe($ownerName)."', 
							email='$ownerEmail' WHERE id='$ownerID'";
			$ptdb->query($query);
		} else {
			$query = "INSERT INTO {owners} (nickname, fullname, email) 
							VALUES ('".fixApostrofe($ownerNick)."', '".fixApostrofe($ownerName)."', '".fixApostrofe($ownerEmail)."')";	
			$ptdb->query($query);
			
			if (count($ptdb->affectedRows()) != 0) $ownerID = mysql_insert_id();
		}
		
		if ( $_POST[blogId] != NULL && $ownerID) {
			$query = "UPDATE {blogs}
					SET name='".fixApostrofe($_POST[blogName])."',description='".fixApostrofe($_POST[blogDescription])."', 
					url='".$_POST[blogUrl]."', feed_url='".$_POST[blogFeed]."', owner_id=".fixApostrofe($ownerID).",
					last_update='".$_POST[blogLastUpdate]."',state='".$_POST[blogState]."'
					WHERE id='".$_POST[blogId]."'";
			
			$ptdb->query($query);
		} else {
			
			$query = "INSERT INTO {blogs} (name,description,url, feed_url, state, owner_id) 
							VALUES ('".fixApostrofe($_POST[blogName])."','".fixApostrofe($_POST[blogDescription])."',
							'".$_POST[blogUrl]."', '".$_POST[blogFeed]."', 'enabled', '".fixApostrofe($ownerID)."')";
			
			$ptdb->query($query);
		}
		
		header("Location: ".$srv->buildUrl("?admin=blogs"));
		
	}
	
	function updateUsers() {
		global $ptdb;
		
		if (isset($_POST['cancel'])) return;
		
		if ($_POST[userPass]) $password = "password='".md5($_POST[userPass])."', ";
		if ($_POST["userId"]) {
			$query = "UPDATE {users}  SET " .
			         "nickname='".fixApostrofe($_POST[userNick])."', " .
			         				$password.
			         "fullname='".fixApostrofe($_POST[userName])."', " .
			         "website='".fixApostrofe($_POST[userUrl])."', " .
			         "email='".fixApostrofe($_POST[userEmail])."', " .
			         "author_id='".fixApostrofe($_POST[userAId])."', " .
			         "status='".fixApostrofe($_POST[userStatus])."', " .
			         "usertype='".fixApostrofe($_POST[userType])."' " .
			         "WHERE id=" . $_POST[userId];
		} else {
			$query = "INSERT INTO {users} ( nickname, password, fullname, website, email, author_id, status, usertype) " .
					 "VALUES ( '".fixApostrofe($_POST[userNick])."',
					 		   '".md5($_POST[userPass])."',
					 		   '".fixApostrofe($_POST[userName])."',
					 		   '".fixApostrofe($_POST[userUrl])."',
					 		   '".fixApostrofe($_POST[userEmail])."',
					 		   '".fixApostrofe($_POST[userAId])."',
					 		   '".fixApostrofe($_POST[userStatus])."',
					 		   '".fixApostrofe($_POST[userType])."'
					 		    )";
		}
		
		$ptdb->query($query);
	}
	
	private function removeUsers() {
		global $ptdb;
		
		unset($_POST['remove']);
		
		foreach ($_POST as $id) {
		
			$query = "DELETE FROM {users} WHERE id='$id'";
			$ptdb->query($query);

		}
	}
	
	private function changeUsers() {
		global $ptdb;
		
		if ($_POST['remove']) {
			$this->removeUsers();
			return true;
		}
		
		$newState = ($_POST['newState'] == "Enable")?"E":"D";
		
		unset($_POST['newState']);
		
		foreach ($_POST as $id) {
		
			$query = "UPDATE {users} SET status='$newState' WHERE id='$id'";
			
			$ptdb->query($query);
		}
	}
	
	private function updatePages(){
		global $srv, $ptdb;
		
		if (isset($_POST['cancel'])) return;
		
		$date = date('Y')."/".date('m')."/".date('d')." ".date('H').":".date('i').":".date('s');
		
		if ($_POST[pageId]) {
			$query = "UPDATE {pages}
					SET page_title='".fixApostrofe($_POST[pageTitle])."', page_content='".fixApostrofe($_POST[pageContent])."', 
					page_date='".$date."', user_id='".$_SESSION["adminLogged"]."',state='".$_POST[pageState]."'
					WHERE id='".$_POST[pageId]."'";
			
			$ptdb->query($query);
		} else {
			
			$query = "INSERT INTO {pages} (page_title,page_content,page_date, user_id, state) 
							VALUES ('".fixApostrofe($_POST[pageTitle])."','".fixApostrofe($_POST[pageContent])."',
							'".$date."', '".$_SESSION["adminLogged"]."', 'enabled')";
			
			$ptdb->query($query);
		}
		
		header("Location: ".$srv->buildUrl("?admin=pages"));
		
	}
	
	private function changePages() {
		global $ptdb;
		
		if ($_POST['remove']) {
			$this->removePages();
			return true;
		}
		
		$newState = ($_POST['newState'] == "Enable")?"enabled":"disabled";
		
		unset($_POST['newState']);
		
		foreach ($_POST as $id) {
		
			$query = "UPDATE {pages} SET state='$newState' WHERE id='$id'";
			
			$ptdb->query($query);
		}
	}
	
	private function removePages() {
		global $ptdb;
		
		unset($_POST['remove']);
		
		foreach ($_POST as $id) {
		
			$query = "DELETE FROM {pages} WHERE id='$id'";
			$ptdb->query($query);

		}
		
	}
	
	private function changeBlogs() {
		global $ptdb, $mailer, $stgs, $admldr;
		
		if ($_POST['remove']) {
			$this->removeBlogs();
			return true;
		}
		
		$newState = ($_POST['newState'] == "Enable")?"enabled":"disabled";

		foreach ($_POST as $id ) {
			$blog  = $admldr->getSingleInf("blogs", "id", $id);
			
			$query = "UPDATE {blogs} SET state='$newState' WHERE id='$id'";
			
			$ptdb->query($query);

			if ( $blog[0]["state"] == "pending" ) {

				$owner = $admldr->getSingleInf("owners", "id", $blog[0]["owner_id"]);
				
				$mailer->send( array (
						'From' 		=> $stgs->getConf("smtp_sender"),
						'To' 		=> $owner[0]["email"],
						'Subject' 	=> "Your request for Blog Registration is confirmed!",
						'body'		=> "\nDear " . $owner[0]["fullname"] .
									   "\n\nCongratulations!  ". $blog[0]["url"] ." has been approved for inclusion in ".$stgs->getConf("sitename")."'s " .
									   "aggregator.  Feeds are refreshed every ".($stgs->getConf("feed_refresh")/60)." minutes.  If you have any " .
									   "entries at ". $blog[0]["url"] .", they will begin shortly." .
									   "\n\nThank you and welcome to " . $stgs->getConf("sitename") .
									   "\nThe ".$stgs->getConf("sitename")." Team"
 ,
						) 
				);
			}
		}
	}
	
	private function removeBlogs() {
		global $ptdb;
		
		unset($_POST['remove']);
		
		foreach ($_POST as $id) {
		
			$query = "DELETE FROM {blogs} WHERE id='$id'";
			$ptdb->query($query);
			
			$query = "DELETE FROM {posts} WHERE blog='$id'";
			$ptdb->query($query);
		}
		
	}
	
	private function changeAuthors() {
		global $ptdb;
		
		$newState = ($_POST['newState'] == "Enable")?"enabled":"disabled";
		
		unset($_POST['newState']);
		
		foreach ($_POST as $id) {
		
			$query = "UPDATE {authors} SET state='$newState' WHERE id='$id'";
			
			$ptdb->query($query);
		}
	}
	
	private function updateSmtp() {
		
		$smtpAuth = ($_POST[smtpAuth] == "on" )?"enabled":"disabled";
		
		$this->updateOptions( array(
				'smtp_host'   => $_POST[smtpHost],
				'smtp_user'   => $_POST[smtpUser],
				'smtp_pass'   => $_POST[smtpPassword],
				'smtp_sender' => $_POST[smtpSender],
				'smtp_port' => $_POST[smtpPort],
				'smtp_auth'   => $smtpAuth
				) );	
	}
	
	private function checkSmtp() {
		global $mailer, $stgs;
		
		$mailer->send( array (
				'From' 		=> $stgs->getConf("smtp_sender"),
				'To' 		=> $_SESSION["userEmail"],
				'Subject' 	=> $stgs->getConf("sitename") . " Smtp Test",
				'body'		=> " This is a test message sent from " . $stgs->getConf("sitename"),
				) 
		);		
		
		die();
	}
	
	private function updateReader() {
		
		$readerDebug = ($_POST[readerDebug] == "on" )?"enabled":"disabled";
		
		$this->updateOptions( array(
				'feed_refresh' => $_POST[cacheRefresh],
				'feed_timeout' => $_POST[feedTimeOut],
				'reader_debug' => $readerDebug
				) );
	}
	
	private function updateGeneral() {
		
		$webUpdate  = ($_POST[webUpdate] == "on")?"enabled":"disabled";
		$rewriteUrl = ($_POST[rewriteUrl] == "on" )?"enabled":"disabled";
		
		$this->updateOptions( array(
				'sitename' => $_POST[siteName],
				'sitedescription' => $_POST[siteDescription],
				'language' => $_POST[siteLang],
				'delete_posts' => $_POST[delPosts]?$_POST[delPosts]:0,
				'default_theme' => $_POST[siteTheme],
				'web_update' => $webUpdate,
				'rewrite_url' => $rewriteUrl,
				) );
	}
	
	private function updatePosts() {
		global $ptdb;
		
		$newState = ($_POST['newState'] == "Enable")?"enabled":"disabled";
		
		unset($_POST['newState']);
		
		foreach ($_POST as $id) {

			$query = "UPDATE {posts} SET state='$newState' WHERE id='$id'";
			
			$ptdb->query($query);
		}
	}
	
	
	private function updateOptions( $tmp ){
		global $ptdb, $srv;	

		foreach($tmp as $field => $value) {
			$query = "UPDATE {settings} SET
					value='".$value."'
					WHERE keyid='".$field."'";
	
			$ptdb->query($query);
		}
		
		$srv->init();
	}
	
}

$GLOBALS['adminCore'] = new adminCore();
