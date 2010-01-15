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

require_once('include/database.'.$stgs->getDBInf('db_type').'.inc.php');

if (! isset($ptdb) ){
	$ptdb = new ptdb( $stgs->getDBInf('url') );
}else{
	// e' strano.. hum hum.. warning!
}

/**
* db_error
*
* Get's the database errors and calls
* the phanet killer function.
*
* @param $message The message to show;
*
* @version 0.1
*/
function db_error($message, $type="", $error="") {
	$message = t($message);
	$message .= "";
	$message .= $type;
	$message .= "";
	$message .= "<p>$error</p>";
	//pt_kill($message, 'database');
}

/**
* lock_table
*
* Locks a table.
*
* @param $table The table to lock
* @param $locktpy The type of lock that should be used.
*
* @version 0.1
*/
function lock_table($table, $locktype) {
	$ptdb->query("LOCK TABLES $table $locktype");
}

/**
* unlock_tables
*
* Unlocks all the locked tables.
*
* @version 0.1
*/
function unlock_tables() {
	$ptdb->query("UNLOCK TABLES");
}

/**
* is_locked
*
* Checks if a table is locked
*
* @param $dbname The name of the database.
* @param $table the table to check.
*
* @return 0 if open >0 if locked.
* @version 0.1
*/
function is_locked($dbname, $table) { /// TODO improve lock management
	global $ptdb;
	$ptdb->query("SHOW OPEN TABLES FROM $dbname");
	$OpenTables = $ptdb->fetchArray();
	
	foreach( $OpenTables as $SingleTable) {
		if ($SingleTable['Table'] == $table)
			return $SingleTable['In_use'];
	}
}

/**
* rewrite_query
*
* Rewrites a query deleting the {}.
*
* @param $query The query to rewrite.
*
* @return $query The query rewrited.
* @version 0.1
*/
function rewrite_query($query) {
	global $stgs;
	$param = "#\{([a-zA-Z]+)\}#";
	$prefix = $stgs->getDBInf('db_prefix');
	$query = preg_replace($param, $prefix."$1", $query);
	return $query;
}

/**
 * Helper function for db_query().
 */
function _db_query_callback($match, $init = FALSE) {
  static $args = NULL;
  if ($init) {
    $args = $match;
    return;
  }
// takes db_escape_string and db_encode_blob from the right db module
  switch ($match[1]) {
    case '%d': // We must use type casting to int to convert FALSE/NULL/(TRUE?)
      return (int) array_shift($args); // We don't need db_escape_string as numbers are db-safe
    case '%s':
      return db_escape_string(array_shift($args));
    case '%%':
      return '%';
    case '%f':
      return (float) array_shift($args);
    case '%b': // binary data
      return db_encode_blob(array_shift($args));
  }
}

/**
 * Indicates the place holders that should be replaced in _db_query_callback().
 */
define('DB_QUERY_REGEXP', '/(%d|%s|%%|%f|%b)/');

/**
 * Runs a basic query in the active database.
 *
 * User-supplied arguments to the query should be passed in as separate
 * parameters so that they can be properly escaped to avoid SQL injection
 * attacks.
 *
 * @param $query
 *   A string containing an SQL query.
 * @param ...
 *   A variable number of arguments which are substituted into the query
 *   using printf() syntax. Instead of a variable number of query arguments,
 *   you may also pass a single array containing the query arguments.
 *
 *   Valid %-modifiers are: %s, %d, %f, %b (binary data, do not enclose
 *   in '') and %%.
 *
 *   NOTE: using this syntax will cast NULL and FALSE values to decimal 0,
 *   and TRUE values to decimal 1.
 *
 * @return
 *   A database query result resource, or FALSE if the query was not
 *   executed correctly.
 */
function make_query($query) {
  $args = func_get_args();
  array_shift($args);
//   $query = db_prefix_tables($query);
  if (isset($args[0]) and is_array($args[0])) { // 'All arguments in one array' syntax
    $args = $args[0];
  }
  _db_query_callback($args, TRUE);
  $query = preg_replace_callback(DB_QUERY_REGEXP, '_db_query_callback', $query);
  return $query;
}


