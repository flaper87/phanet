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


/**
* htmlToPlain
* 
* Parses all the html text to a plain text.
*
* Gets a text with html tags en parse all the content to
* a plain text. It doesn't erase the url o src from the <a>
* or <img> tags. 
*
* @param $text The given text to parse.
*
* @return $text The text already parsed.
* 
* @version 0.1
*/
function htmlToPlain($text) {
	$tags   =  "%(<$tag.*?>)(.*?)(<\/$tag.*?>)%is";
	$tagimg =  "%<img.*?src=[\"\'](.*?)[\'\"].*?>%is";
	$taga   = "%<a.*?href=[\"\'](.*?)[\'\"].*?>(.*?)<\/a.*?>%is";
	
	if (preg_match($taga, $text)) {
		$text = preg_replace($taga, '$2 [$1]',$text);
	}

	if (preg_match($tagimg, $text)) {
		$text = preg_replace($tagimg, '[IMAGE: $1]',$text);
	}	
	
	$text = preg_replace($tags, '$2', $text);
	return $text;
}

function parseSearch( $text ) {

	$text = urldecode( $text );

	if ( preg_match("%.*search/([^/]+).*%is", $text))
		$text = preg_replace("%.*search/([^/]+).*%is", "$1", $text);
	
	$_GET['search'] = $text;

	if (preg_match("%(\w+:)%i", $text) ) {
		$preg = preg_replace("%(\w+:)%i", '[${1}', $text);
		$blocks = explode("[", $preg);

		foreach ($blocks as $block) {
			if ($block == "") continue;

			$type = explode(":", $block);
			
			foreach ( explode(" ", $type[1]) as $query) {
				if ( $query == "") continue;
				
				$querySearch[$type[0]] .= " ".$query;
			}
		}
	} else {

		$querySearch["search"] = $text;
	}
	
	return $querySearch;
}

/**
 * addSubarray()
 *
 * adds the $value to $path(=$name) in $array
 *
 * @param &$array
 *   the array
 * @param $name
 *   the path
 * @param $value
 *   the value
 *
 */
function addSubarray( &$array, $name, $value){

	$path = explode('.',$name);
	$p = array_shift($path);
	if (count($path)>1){
		$npath=implode('.',$path);
		addSubarray($array[$p],$npath,$value);
		return;
	}else{
		$array[$p]=$value;
		return;
	}
}

/**
 * onlyAlphaNum_()
 *   "say it out loud: only-alpha-num-underscore!"
 *
 * @param $string -> string to sanitize
 * @return string with only alphanumeric or _ characters
 */
function onlyAlphaNum($string) {
  return preg_replace('/[^A-Za-z0-9_]+/', '', $string);
}

function encodeUrlPiece( $part ) {
	if (preg_match("#\/#", $part)) $part = preg_replace("#\/#", '`', $part);
	return urlencode($part);
}

function decodeUrlPiece( $part ) {
	$part = urldecode($part);
	
	if (preg_match("#\`#", $part)) $part = preg_replace("#\`#", '/', $part);
	
	return $part;
	
}


/**
 * matchDivs()
 *  Count the opened and closed divs to prevent from buggy posts.
 *
 * @param $text The text to parse
 * @return True if the opened posts are equal the closed posts. Except False.
 */
function matchDivs( $text ) {
	
    preg_match_all( "%(<div.*?>)%is", $text, $opened);    
    preg_match_all( "%(</div>)%is", $text, $closed);   
   
    if ( count($opened[0]) != count($closed[0]) ) {
        return False;
    }
    
    return True;
}

function parseVideos( $text ) {
	$embed   =  "%<object.*<embed.*?src=[\'\"](.*?)[\"\'].*object>%is";
	
	if (preg_match($embed, $text) ) return preg_replace($embed, '$1', $text);
}
