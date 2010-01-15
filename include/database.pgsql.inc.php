<?php
/**
* Written by Flavio Percoco Premoli, started January 2008.
*            Samuele Santi
*            Francesco Angelo Brisa
*
* Copyright (C) 2008 Flavio Percoco Premoli - http://www.flaper87.org
*
* This file is part of Phanet.
*
* Phanet is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 2 of the License, or
* (at your option) any later version.
*
* Foobar is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
*/
?><?php

/** ### UNTESTED TODO test it! ### **/

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
	function ptdb($url) {
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
		$conn_string = '';
		
		if (isset($url['user'])) {
			$conn_string .= ' user='. urldecode($url['user']);
		}
		if (isset($url['pass'])) {
			$conn_string .= ' password='. urldecode($url['pass']);
		}
		if (isset($url['host'])) {
			$conn_string .= ' host='. urldecode($url['host']);
		}
	  	if (isset($url['path'])) {
	    	$conn_string .= ' dbname='. substr(urldecode($url['path']), 1);
		}
	 	if (isset($url['port'])) {
		    $conn_string .= ' port='. urldecode($url['port']);
		}
		
		if ( defined('dbcharset') ){
			$this->charset = dbcharset;
		}
		
		$this->dbcon = @pg_connect($conn_string);
		
		if (!$this->dbcon){
			
			db_error("There were problems with the database connection, please check the information of your <code>pt_settings.php</code> file. 
			<ul>
				<li>Make sure your username and your password are right.</li>
				<li>Make sure your hostname is right. The hostname i attempted to contact is <code>$dbhost</code></li>
				<li>Make sure your database server is running
			</ul>");
			return false;
			
		}
		
		if ( !empty($this->charset) && version_compare(mysql_get_server_info(), '4.1.0', '>=') ){
			@pg_query($this->dbcon, "SET NAMES '$this->charset'");
 			@pg_set_client_encoding($this->charset);
		}
 			
	}
	
	/**
	* db_query
	* 
	* Executes a query.
	*
	* @param $query The query to execute
	* @param $fetch The type of fetch wished. Example: db_query($query, array); 
	* 
	* @version 0.1
	*/
	function db_query($query)
	{
		if(is_array($new_query)){
			if($new_query['pgsql']){
				$query=$new_query['pgsql'];
			}else{
				$query=$new_query['default'];
			}
		}else{
			$query=$new_query;
		}
		$this->flushVars();
		
		$this->execution = @pg_query($this->dbcon, $query);
		
		if (!$this->execution){
			db_error("There was an error while executing the query: ", $query, pg_last_error($this->dbcon));
		}
		
		if ( preg_match("/^\\s*(create|insert|delete|update|replace|.*lock) /i",$query) ) {
			$this->affected_rows = pg_affected_rows($this->execution);
		} else {
			switch ($fetch) {
				case 'array':
					$i=0;
					while ($row = @pg_fetch_assoc($this->execution)) {
						$this->row[$i] = $row;
						$i++;
					}
					break;
				
				case 'row':
					while ($row = @pg_fetch_row($this->execution))
						$this->row = $row;
					break;
					
				case 'field':
					$i=0;
					$this->affected_fields = @mysql_num_fields($this->execution);
				
					while ($i < $this->affected_fields) {
						$this->col = $this->_pg_fetch_field($this->result, $i);
						$i++;
					}
					break;
				
				case 'alive':
					return true;
					
				default:
					$i = 0;
					while ( $row = @pg_fetch_object($this->execution) ) {
						$this->row[$i] = $row;
						$i++;
					}
					
					$this->affected_rows = $i;
					break;
			}
		}
	}
	
	function _pg_fetch_field($result, $i) {
		$meta['name']  = @pg_field_name($result, $i);
		$met['type']   = @pg_field_type($result, $i);
		$meta['table'] = @pg_field_table($result, $i);
		return $meta;
	}
	
	/**
	* flushvars
	* 
	* Flushes the vars of the module.
	*
	* @version 0.1
	*/
	function flushVars()
	{
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
 		 if (pg_ping($this->dbcon))
 		 	return true;
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
 		 return pg_parameter_status($this->dbcon, server_version);
	}
}





/**
 * Returns a properly formatted Binary Large OBject value.
 * In case of PostgreSQL encodes data for insert into bytea field.
 *
 * @param $data
 *   Data to encode.
 * @return
 *  Encoded data.
 */
function db_encode_blob($data) {
  return "'". pg_escape_bytea($data) ."'";
}

/**
 * Returns text from a Binary Large OBject value.
 * In case of PostgreSQL decodes data after select from bytea field.
 *
 * @param $data
 *   Data to decode.
 * @return
 *  Decoded data.
 */
function db_decode_blob($data) {
  return pg_unescape_bytea($data);
}

/**
 * Prepare user input for use in a database query, preventing SQL injection attacks.
 * Note: This function requires PostgreSQL 7.2 or later.
 */
function db_escape_string($text) {
  return pg_escape_string($text);
}