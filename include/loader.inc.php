<?php


/**
 * get_posts
 *
 * Gets the posts from the database
 *
 * Gets all the posts to show from the database with the information of the author, ordered from newest to oldest.
 *
 * @param $start The start point for the limit
 * @param $count The number of posts to get.
 *
 * @return $ptdb->fetchObject The Object with all the data.
 * @version 0.1
 */
function getPosts( $limit = 0 ){
	global $ptdb, $showPage;
	$querySelect	= "SELECT p.*, b.*, a.nickname, a.website, a.email, o.nickname as owner_nick";
	$queryFrom		= " FROM {posts} AS p, {authors} AS a, {blogs} as b, {owners} as o";
	$queryWhere		= " WHERE o.id=b.owner_id AND a.id=p.author AND a.state!='disabled' AND b.state='enabled' AND p.state='enabled' AND b.id=p.blog"; 
	$queryOrder		= " ORDER BY date DESC ";

    $queryWhere .= getQueryWhere();

    $_SESSION["lastQuery"] = $querySelect . $queryFrom . $queryWhere . $queryOrder;

    if ( isset($_GET['page']) ) {
    	$queryLimit	= "LIMIT ".(($_GET['page']-1)*20).",20";
    } elseif ( $limit > 0 ) {
		$queryLimit	= "LIMIT $limit";
	} else {
		$queryLimit = "LIMIT 0,20";
	}
	        
        
	$query = $_SESSION["lastQuery"].$queryLimit;
	$ptdb->query($query);
	return $ptdb->fetchObject();
}

function getQueryWhere() {

	if ( function_exists("checkIfSearch") ) $queryWhere = checkIfSearch();
	
	if ( (isset($_GET["category"]) && ($type = "categories") && ($value = $_GET["category"])) 
	 ||  (isset($_GET["tag"]) && ($type = "tags")  && ( $value = $_GET["tag"]) ) )
	 	$queryWhere .= " AND ".($table=($type=="tags")?"p.tags":"b.categories")." like '%:".getCategOrTagId( decodeUrlPiece($value), $type ).":%'";
	 	
	return $queryWhere;
}

/**
 * getPages
 *
 * Loads the pages to show
 *
 * @return the array with the pages.
 * @version 0.1
 */

function getPages( $id = '') {
	global $ptdb;

	if ($id) $where = " AND p.id=$id ";
	
	$query  = "SELECT p.*, u.nickname FROM {pages} AS p, {users} AS u "; 
	$query .= " WHERE p.state='enabled' AND u.id=p.user_id ORDER BY page_title";
	$ptdb->query($query);

	return $ptdb->fetchObject();
}

/**
 * countPosts
 *
 * Gets the number of saved post in the DB
 *
 * @return the number of post present in the DB
 * @version 0.1
 */
function countPosts() {
	global $ptdb;

	if ( !isset($_GET['showJust']) && !isset($_POST["searchPosts"]) && !isset($_GET["search"]) ) {
		$query = "SELECT * from {posts}";
		$ptdb->query($query);
		return count($ptdb->fetchObject());
	} else {
		return count(getPosts(-1));
	}
}

/**
 * getFeeds
 *
 * Gets the feeds from the database
 *
 * Gets all the feeds to read from the database and the cache from the updates table.
 * 
 * @param $query_where optionl, extrat only blogs that satisfy the query
 *
 * @return $ptdb->fetchArray The array with all the data.
 * @version 0.1
 */
function getFeeds( $order = '' ) {
	global $ptdb;
	
	if (!$order) $order = "name";
	
	$query = "SELECT b.*, o.nickname FROM {blogs} as b, {owners} as o " .
			  "WHERE o.id=b.owner_id AND b.state='enabled' ORDER BY $order";
   
	$ptdb->query( $query );
	return $ptdb->fetchArray();
}

function get_date( $val, $date ) {

	$date = preg_split("%[\/\ ]%", $date);
	$hour = explode(":",$date[3]);

	return date($val, mktime($hour[0],$hour[1],$hour[2],$date[1],$date[2],$date[0]));
}



function getThemes() {
	global $ptdb;
	
	$query = "SELECT name FROM {themes}";
	
	$ptdb->query($query);
	return $ptdb->fetchArray();
}

function getActions() {
	global $ptdb;
	
	$query = "SELECT name FROM {actions}";
	
	$ptdb->query($query);
	
	foreach ($ptdb->fetchArray() as $actionArray) {
		$actions[] = $actionArray['name'];
	}
	
	return $actions;
}

/**
 * getThemePath
 *
 * Gets the path of the requested theme.
 *
 * @param $name The name of the theme to look for
 * 
 * @return Path The path of the theme if found
 * @return false if the theme doesn't exist or it isn't enabled
 * @version 0.1
 */
function getThemePath($name){
	global $ptdb;
	
	$sql="SELECT path FROM {themes} WHERE name='$name' AND enabled=1 LIMIT 1";
	
	$ptdb->query($sql);
	$result=$ptdb->fetchArray();
	
	if(count($result)>0) return $result[0]['path'];
	else return false;
}

function getCategOrTagId( $label, $type ) {
	global $ptdb;

	$sql .=  "SELECT id FROM {".$type."} WHERE label = '$label'";
	$ptdb->query($sql);
	$result = $ptdb->fetchArray();
	return $result[0]['id'];
}

function getCategories() {
	global $ptdb;
	
	$sql = "SELECT * FROM {categories} ORDER BY label";
	
	$ptdb->query($sql);
	return $ptdb->fetchArray();	
}

function getTags( $cloud = false ) {
	global $ptdb;
	
	$sql = "SELECT id,label FROM {tags} ORDER BY label";
	
	$ptdb->query($sql);
	return $ptdb->fetchArray();	
}

function getSettings() {
	global $ptdb;
	
	$ptdb->query('SELECT * FROM {settings}');
		
	return $ptdb->fetchArray();
}

function getActionFunction( $action ) {
	global $ptdb;
	
	$sql="SELECT * FROM {actions} WHERE name = '$action'";
	$ptdb->query($sql);
	$flist	= $ptdb->fetchArray();
	
	foreach($flist as $f) return $flist[0]['fname'];
}
