<?php	

@session_start();

require_once ("panel.inc.php");
require_once ("registers.inc.php");
require_once ("contents.inc.php");
require_once ("options.inc.php");

class tmpTer {

	var $admldr;
	
	var $menu = array(
					'panel' => array( 'mainlink' => 'panel', 'submenu' => array ( 'panel' => array('name' => 'panel', 'link' => 'panel'))), 
					'registers' => array( 'mainlink' => 'register-blogs', 'submenu' => array( 
										  'blogs'   => array('name' => 'blogs',   'link' => 'register-blogs'), 
										  'users'   => array('name' => 'users',   'link' => 'register-users'),
										  'authors' => array('name' => 'authors',  'link' => 'register-authors') ) ),
					'contents'   => array( 'mainlink' => 'contents-pages', 'submenu' => array( 
										'pages'   => array('name' => 'pages',   'link' => 'contents-pages'), 
										'posts' => array( 'name' => 'posts', 'link' => 'contents-posts' ) ) ),
					'options' => array( 'mainlink' => 'options-general', 'submenu' => array( 'general'   => array('name' => 'general', 'link' => 'options-general'), 
										'reader'    => array('name' => 'reader',  'link' => 'options-reader'), 
										'smtp'    => array('name' => 'smtp',  'link' => 'options-smtp'), 
										'widgets'    => array('name' => 'widgets',  'link' => 'options-widgets'))),
					);

	function tmpTer() {
		global $admldr;
		
		$this->admldr = $admldr;
	}
	
	function loadTemplate($page) {
		global $subMenu;
		
		$page = preg_replace("#.*?\-(.*?)#", "$1", $_GET['admin']);

		if (!$page || $page == 1) $page = "panel";
		$loader = $page."Template";
		load_header( $this->menu, $page );
		$loader();
		$this->adminFooter();
	}
	
	function adminFooter() {
		global $srv;
		$output[] = "<div id=\"footer\">";
			$output[] = "<img src=\"".$srv->getPath('media/phanetGrey-inverted.png')."\">";
			$output[] = "<div class=\"footMessage\">";
				$output[] = "<a href=\"http://www.panet.net\">Phanet</a>";
			$output[] = "</div>";
		$output[] = "</div>"; 
		
		$output[] = "</body>";
		$output[] = "</html>";
		
		echo join("\n", $output);
	}

}
