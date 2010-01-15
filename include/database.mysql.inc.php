<?php

/**
* Class ptdb
* 
* Creates the object to handle the db connection.
*
* @version 0.1
*/


class ptdb
{

	var $query;
	var $error;
	var $result;
	var $execution;
	
	/**
	* ptdb
	* 
	* Calls the creation of the connection.
	*
	* @param $url The url with the database params. Example: pgsql://username:password@localhost/databasename
	* 
	* @version 0.1
	*/
	function ptdb($url){
		$this->_create($url);
	}
	
	/**
	* _create
	* 
	* Creates the DB connection.
	*
	* @param $url The url with the database params. Example: pgsql://username:password@localhost/databasename
	* 
	* @version 0.1
	*/
	function _create($url) {
		$url = parse_url($url);
		
		$dbuser = urldecode($url['user']);
		// Test if database url has a password.
		if (isset($url['pass'])) {
			$dbpassword = urldecode($url['pass']);
		} else {
			$dbpassword = '';
		}
		
		$dbhost = urldecode($url['host']);
		$dbname = urldecode($url['path']);
                 
                /*if (substr($dbname,0,1)=="/") {
                    $dbname=substr($dbname ,1);
                }*/
		
		if (isset($url['port'])) {
			$dbhost = $dbhost . ':' . $url['port'];
		}
		
		if ( defined('dbcharset') )
			$this->charset = dbcharset;

		$this->dbcon = @mysql_connect( $dbhost, $dbuser, $dbpassword);
		
		if (!$this->dbcon){
			manage_error(101);
			return false;
		}
		
		if ( !empty($this->charset) && version_compare(mysql_get_server_info(), '4.1.0', '>=') ){
			@mysql_query("SET NAMES '$this->charset'", $this->dbcon);
 			@mysql_set_charset($this->charset);
		}
 			
		$this->select_db($dbname);
	}
	
	/**
	* select_db
	* 
	* Selects the database to work with.
	*
	* @param $dbname The database name
	* 
	* @version 0.1
	*/
	function select_db($dbname) {
		if (!@mysql_select_db(substr(urldecode($dbname),1))){
			manage_error(102);
		}
	}
	
	/**
	* db_query
	* 
	* Executes a query.
	*
	* @param $query The query to execute
	* @return none
	* 
	* @version 0.1
	*/
	function query($new_query) {
		if(is_array($new_query)){
			if($new_query['mysql']){
				$query=$new_query['mysql'];
			}else{
				$query=$new_query['default'];
			}
		}else{
			$query=$new_query;
		}
		$this->flushVars();
		if(function_exists("rewrite_query")){
			$query=rewrite_query($query);
		}
		$this->execution = @mysql_query( $query, $this->dbcon);
		
		if ( @mysql_error($this->dbcon)){
			manage_error(103);
			return false;
		}

		return true;
	}

	/**
	* fetchObject
	* 
	* @return $tmp An array with the fetched object.
	*
	* @version 0.1
	*/
	function fetchObject(){
		$tmp=array();
		while ( $row = @mysql_fetch_object($this->execution) ) {
			$tmp[]=$row;
		}
		return $tmp;
	}

	/**
	* fetchRows
	* 
	* @return $tmp An array with the array fetched from the database
	*
	* @version 0.1
	*/
	function fetchArray(){
		$tmp=array();
		while ( $row = @mysql_fetch_array($this->execution) ) {
			$tmp[]=$row;
		}
		return $tmp;
	}

	/**
	* fetchRows
	* 
	* @return $tmp An array with the fetched rows
	*
	* @version 0.1
	*/
	function fetchRows(){
		$tmp=array();
		while ( $row = @mysql_fetch_row($this->execution) ) {
			$tmp[]=$row;
		}
		return $tmp;
	}
	
	
	/**
	* affectedRows
	* 
	* @return AffectedRows the number of affected rows
	*
	* @version 0.1
	*/
	function affectedRows(){
		return @mysql_affected_rows();
	}

	/**
	* numRows
	* 
	* @return NumRows the number of rows
	*
	* @version 0.1
	*/
	function numRows(){
		return @mysql_num_rows($this->execution);
	}
	
	/**
	* flushvars
	* 
	* Flushes the vars of the module.
	*
	* @version 0.1
	*/
	function flushVars() {
		$this->query = null;
		$this->error = null;
		$this->result = null;
		$this->execution = null;
	}
	
	/**
	* is_alive
	* 
	* Check if the db connection is alive.
	* 
	* @return true Return tru if the connection is alive
	*
	* @version 0.1
	*/
	function is_alive() {
		if (db_query("SELECT 1"))
			return True;
	}
	
	/**
	* db_version
	* 
	* Gets the version of the db server.
	*
	* @return version The database version.
	*
	* @version 0.1
	*/
	function db_version() {
  		list($version) = explode('-', mysql_get_server_info());
  		return $version;
	}

}

/**
 * Returns a properly formatted Binary Large OBject value.
 *
 * @param $data
 *   Data to encode.
 * @return
 *  Encoded data.
 */
function db_encode_blob($data) {
  global $active_db;
  return "'" . mysql_real_escape_string($data, $active_db) . "'";
}

/**
 * Returns text from a Binary Large Object value.
 *
 * @param $data
 *   Data to decode.
 * @return
 *  Decoded data.
 */
function db_decode_blob($data) {
  return $data;
}

/**
 * Prepare user input for use in a database query, preventing SQL injection attacks.
 */
function fixApostrofe($str) {
	return htmlspecialchars(html_entity_decode($str), ENT_QUOTES);
}
