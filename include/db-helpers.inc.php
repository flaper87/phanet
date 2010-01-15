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

//defined('_MODE_') or die('access denied');


/**
 * db_getField
 *
 * Creates virtual queries.
 *
 * @param $field_struct
 * @param $dbtype
 *
 * @return $fedf
 * @version 0.1
 */
function db_getField($field_struct,$dbtype=''){
	global $stgs;
	
	if(!$dbtype) $dbtype = $stgs->getConf('db_type');
	
	$fdef = "";

	switch($dbtype){
			case 'mysql':
			case 'mysqli':
// 				( "name"=>"id", "type"=>"int unsigned", "null"=>"NOT NULL", "extra"=>"AUTO_INCREMENT");
				$fname  =  $field_struct['name'];
				$ftype  =  explode(" ",$field_struct['type']);
				$null   =  $field_struct['null'];
				$extra  =  $field_struct['extra'];
				$fdef   =  "`$fname` $ftype[0]";
				
				if(count($ftype>1)){
// 					if(floor($ftype[1]))$fdef.="(".floor($ftype[1]).") ";
					if(is_numeric($ftype[1]))$fdef.="(".floor($ftype[1]).") ";
					else $fdef.=" $ftype[1] ";
				}
				for( $i=2; $i<count($ftype); $i++ ) $fdef .= $ftype[$i]." ";
				$fdef .=  "$null ";
				$fdef .=  "$extra ";
				break;
			case 'pgsql':
				break;
			default: // error
	}
	return $fdef;
}

/**
 * db_createTable
 *
 * Creates the query for the creation of the table.
 *
 * @param $table_struct
 * @param $dbtype
 *
 * @return $query The query to create the table.
 * @version 0.1
 */
function db_createTable($table_struct,$dbtype=''){
	global $stgs;
	
	if(!$dbtype) $dbtype = $stgs->getDBInf('db_type');
	$tablename  =  $table_struct['name'];
	$tablekeys  =  $table_struct['keys'];
	$fields     =  array();

	foreach($table_struct['fields'] as $field){
		$fields[]  =  db_getField($field,$dbtype);
	}
	
	if($tablekeys) {
		$key  =  explode(" ",$tablekeys);
		
		switch( $key[0] ){
			case 'primary': $key[0]  =  'primary key'; break;
		}
		$fields[]  =  $key[0]." (".$key[1].")";
	}

	$query  =  "CREATE TABLE IF NOT EXISTS {".$tablename."} (".implode(", ",$fields).")";
	return $query;
}

