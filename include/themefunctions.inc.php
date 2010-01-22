<?php /**
* A helpful list of functions to be used in the theme.
*/

global $ptdb;

/**
* Set the active theme name for URL building
*/
$ptdb->query("SELECT * FROM {settings} WHERE `keyid` = 'active_theme'");
$row = $ptdb->fetchArray();
$row2 = $row[0];
$activetheme = $row2[1];

/*
* Tests if the current page is...a page.
* @returns true
*/
function isPage() {
	if(isset($_GET['static']) && !empty($_GET['static'])):
		return true;
	else:
		return false;
	endif;
}

/**
* Returns site info based on input, like Wordpress' bloginfo()
*/
function siteInfo($arg) {
	global $srv, $stgs, $activetheme;
	switch($arg) {
		case 'name':
		default:
			echo $stgs->getConf("sitename");
			break;
		case 'url':
			echo $srv->getInstallRadix();
			break;
		case 'description':
			echo $stgs->getConf("sitedescription");
			break;
		case 'feed_url':
			echo $srv->buildUrl('?feed=');
			break;
		case 'admin_url':
			echo $srv->buildUrl('?admin=');
			break;
		case 'theme_path':
			echo 'themes/'.$activetheme;
			break;
	}
}

/*
* Returns the footnote: "posted by admin on blah blah blah"
* Can't really see much of a use for this one.
*/
function footnote() {
	global $footnote; echo $footnote;
}

/*
* Creates an unordered list of pages. More options to come.
*/
function listPages($args = array('class' => '', 'icon' => 'false')) {
	global $pages, $page, $activetheme, $srv;
	if($args['icon'] == 'true') { ?>
	<img alt="pageicon" src=<?php echo $srv->getPath("themes/phanet_dark/styles/images/page.gif"); ?> />
	<?php } ?>
  <li><a class="pagelink<?php echo ' ' . $args['class']; ?>" href="<?php echo $srv->getInstallRadix(); ?>">Home</a></li>
	<?php
	foreach ( $pages as $page ) {
		if($args['icon'] == 'true') { ?>
		<img alt="pageicon" src=<?php echo $srv->getPath("themes/phanet_dark/styles/images/page.gif"); ?> /> <?php } ?>
		 <li><a class="pagelink<?php echo ' ' . $args['class']; ?>" href="<?php echo $srv->buildUrl("?static=".$page->id); ?>"><?php echo $page->page_title; ?></a></li>
	<?php }
}

/*
* Builds URL to the admin panel based on whether rewrite is 
* on or not.
*/
function adminLink() {
	global $srv; ?>
		<li class="admin_link"><a style="text-align:right;" href="<?php echo $srv->buildUrl('?admin='); ?>"><span class="footnote">Admin Panel</span></a></li>
	<?php
}

/*
* Echoes post/page title.
*/
function postTitle() {
	global $post;
	if(isPage()) :
		echo $post->page_title;
	else :
		echo $post->title;
	endif;
}

/*
* Echoes the URL of the blog from which the current post came.
*/
function blogURL() {
	global $post;
	echo $post->url;
}

/*
* Echoes the permalink to the current post.
*/
function postPermalink() {
	global $post;
	if(isset($post->link)) :
		echo $post->link;
	endif;
}

/*
* Like PHP's date() function, but grabs the post date rather than
* the current one.
*/
function postDate($arg) {
	global $post;
	if(isPage()):
		echo get_date($arg,$post->page_date);
	else:
		echo get_date($arg,$post->date);
	endif;
}

/*
* Echoes the name of the blog from which the current post came.
*/
function blogName() {
	global $post;
	echo $post->name;
}

/*
* Echoes the post content.
*/
function postContent() {
	global $post;
	if(isPage()):
		echo html_entity_decode($post->page_content);
	else:
		echo html_entity_decode($post->text);
	endif;
}

/*
* Lists all blogs to which Phanet is subscribed.
*/
function blogList() {
	$blogs = getFeeds();
	foreach($blogs as $blog) { ?>
	<li>
		<a style="padding-left:5px;" href="<?php echo $blog['url']; ?>" title="<?php echo $blog['description']; ?>">
			<?php echo $blog['name']; ?>
		</a>
	</li>                                  
<?php }
}

/*
* Tests if widgets are enabled.
* @returns true
*/
function widgetized() {
	global $wgts, $stgs;
	if(is_object($wgts) && $stgs->getConf('widgetizer') == "enabled") {
		return true;
	}
}

/*
* Echoes sidebar messages for the current user.
*/
function sidebarMessages() {
	if (!empty($_SESSION['logMessage'])) { ?>
	<div class="block">
		<div class="title"><h2><span style="color:#f67106 !important;" class="dark">Message For You</span></h2></div>
		<div class="text">
		<?php echo $_SESSION['logMessage']; ?>
		</div>
		<div class="close"></div>
	</div>

	<?php $_SESSION['logMessage'] = ''; }
}

/*
* Grabs loop.php in the current theme folder.
*/
function getLoop() {
	global $activetheme, $post, $page;
	if(isPage()) {
		$posts = getPages();
	} else {
		$posts = getPosts(-1);
	}

	if (!$posts) {
	 	include('themes/'.$activetheme.'/404.php');
	}

	$i = 0;
	
	if(!isPage()) {		 
	foreach( $posts as $post){
		if ( $i == 20 ) break;
		require('themes/'.$activetheme.'/loop.php');
	}
} else {
	foreach($posts as $post) {
	require('themes/'.$activetheme.'/loop.php');
}
}
	$i++;
}

/*
* Shows the generated sidebar. Use on sidebar.php
*/
function loadSidebar() {
	global $wgts;
	echo $wgts->showSidebar();
}

/*
* Grabs header.php in the current theme folder.
*/
function getHeader() {
	global $activetheme, $stgs, $srv;
	require('themes/'.$activetheme.'/header.php');
}

/*
* Grabs footer.php in the current theme folder.
*/
function getFooter() {
	global $activetheme, $stgs, $srv;
	require('themes/'.$activetheme.'/footer.php');
}

/*
* Grabs sidebar.php in the current theme folder.
*/
function getSidebar() {
	global $activetheme, $stgs, $srv;
	require('themes/'.$activetheme.'/sidebar.php');
}

/*
* Loads any of a number of predefined scripts.
*/
function loadScript($name) {
	global $srv;
switch($name):
	case 'jquery':
		echo '<script src="'.$srv->getPath('media/js/jquery/jquery.js').'" type="text/javascript"></script>';
		break;
	case 'jqueryUIbase':
		echo '<script src="'.$srv->getPath('media/js/jquery/ui/ui.base.js').'" type="text/javascript"></script>';
		break;
	case 'jqueryUIaccordion':
		echo '<script src="'.$srv->getPath('media/js/jquery/ui/ui.accordion.js').'" type="text/javascript"></script>';
		break;
	case 'jqueryUIdialog':
		echo '<script src="'.$srv->getPath('media/js/jquery/ui/ui.dialog.js').'" type="text/javascript"></script>';
		break;
	case 'jqueryUIdraggable':
		echo '<script src="'.$srv->getPath('media/js/jquery/ui/ui.draggable.js').'" type="text/javascript"></script>';
		break;
	case 'jqueryUIdroppable':
		echo '<script src="'.$srv->getPath('media/js/jquery/ui/ui.droppable.js').'" type="text/javascript"></script>';
		break;
	case 'jqueryUIresizable':
		echo '<script src="'.$srv->getPath('media/js/jquery/ui/ui.resizable.js').'" type="text/javascript"></script>';
		break;
	case 'jqueryUIselectable':
		echo '<script src="'.$srv->getPath('media/js/jquery/ui/ui.selectable.js').'" type="text/javascript"></script>';
		break;
	case 'jqueryUIslider':
		echo '<script src="'.$srv->getPath('media/js/jquery/ui/ui.slider.js').'" type="text/javascript"></script>';
		break;
	case 'jqueryUIsortable':
		echo '<script src="'.$srv->getPath('media/js/jquery/ui/ui.sortable.js').'" type="text/javascript"></script>';
		break;
	case 'jqueryUItabs':
		echo '<script src="'.$srv->getPath('media/js/jquery/ui/ui.tabs.js').'" type="text/javascript"></script>';
		break;
	case 'thickbox':
		echo '<script src="'.$srv->getPath('media/js/thickbox/thickbox.js').'" type="text/javascript"></script>';
		echo '<link rel="stylesheet" type="text/css" href="'.$srv->getPath('media/js/thickbox/ThickBox.css').'" />';
		break;
endswitch;
}

function feedURL() {
	global $srv; echo $srv->buildUrl('?feed=');
}

function is404() {
$posts = getPosts(-1);
  if(isset($_GET['static'])) {
    $pagenumber = $_GET['static'];
    $pages = getPages($pagenumber);
  }
  if(!$posts || (isset($pages) && !$pages) || !getQueryWhere()):
    return true;
  else:
	return false;
  endif;
}