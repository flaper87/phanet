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


require_once('modules/simplepie/simplepie.module');
include_once('modules/simplepie/idn/idna_convert.class.php');
/**
 * debugReader
 *
 * show on output debug information
 *
 * @version 0.1
 */
function debugReader($str) {
	global $stgs;
	if ( $stgs->getConf("reader_debug") == "enabled") {
		echo $str."<br>";
	}
}


function reader_actions(){
	return array("read"=>"reader_read");
}

/**
 * add_author
 *
 * create a new author from given data
 *
 * @return The new author ID
 * @version 0.1
 */
function add_author($author_name,$author_email,$author_link) {
	global $ptdb;
	
	$query = "INSERT INTO {authors} (nickname,email,website,state) VALUES ('".fixApostrofe($author_name)."','".fixApostrofe($author_email)."','".fixApostrofe($author_link)."','enabled')";
	$ptdb->query($query);
	
	// this time we will find it for sure !
	return findOrCreateNewAuthor($author_name,$author_email,$author_link);
}

/**
 * findOrCreateNewAuthor
 *
 * search in the authors table eany recourrence of an existing author with given fields
 * if none found, it creates a new one
 *
 * @return The author ID
 * @version 0.1
 */
function findOrCreateNewAuthor($author_name,$author_email,$author_link) {
	global $ptdb;

	$query = "SELECT * FROM {authors} where nickname='".fixApostrofe($author_name)."'";
			
	$ptdb->query($query);
	$list=$ptdb->fetchArray();

	if (count($list)>0) {
		// found one
		$foundOne=$list[0];
		return $foundOne['id'];
	}

	// none found
	// we create a new one
	return add_author($author_name,$author_email,$author_link);

}

function findOrCreateNewTags( $label ) {
	global $ptdb;

	$query = "SELECT id FROM {tags} where label='".fixApostrofe($label)."'";
			
	$ptdb->query($query);
	$list = $ptdb->fetchArray();

	if (count($list) == 0) {
		$query = "INSERT INTO {tags} (label) VALUES ('".fixApostrofe($label)."')";		
		$ptdb->query($query);		
		return findOrCreateNewTags($label); // this time, I will find it !
	}
	
	return $list[0]['id'];
}

function creaDataOraDb($dataOra) {
	return date("Y",$dataOra)."/".date("m",$dataOra)."/".date("d",$dataOra)." ".date("H",$dataOra).".".date("i",$dataOra).".".date("s",$dataOra);
}

function creaDataOraDaDB($x) {
	return mktime (substr($x,11,2),substr($x,14,2),substr($x,17,2),substr($x,5,2),substr($x,8,2),substr($x,0,4));
}


function getPostIdByLink($link) {
	global $ptdb;
	$query ="SELECT id FROM {posts} WHERE link='".fixApostrofe($link)."';";
	$ptdb->query($query);
	$rows=$ptdb->fetchArray();

	if (count($rows)>0) {
		return $rows[0]['id'];
	}

	return 0;
}

function checkFeed( $new_feed ) {
	global $stgs;
	//SimplePie Library, The base of reader

	$feed = new SimplePie();
	$feed->set_feed_url($new_feed);
	$feed->enable_cache(false);
	$feed->init();
	$feed->set_timeout($stgs->getConf('feed_timeout'));// seconds		
	$feed->handle_content_type();

	if ($feed->error()) 
		return false;
		
	return true;

}


function delOldPosts() {
	global $ptdb, $stgs;
	
	$sql = "DELETE FROM {posts} WHERE date < '" . date('Y/m/d h:i:s', strtotime("-". $stgs->getConf("delete_posts") ." days")) . "'";
	
	$ptdb->query($sql);
	
}

function reader_read(){
	global $ptdb,$stgs;

	// WHAT TIME IS IT ?
	$now_year=date("Y");
	$now_month=date("m");
	$now_day=date("d");
	$now_hour=date("H");
	$now_minute=date("i");
	$now_second=date("s");
	
	$now_time=$now_year."/".$now_month."/".$now_day." ".$now_hour.".".$now_minute.".".$now_second;
	$now_time_sec=creaDataOraDaDB($now_time);
	
	// WHAT IS THE TIMEOUT TO CHECK IN SECONDS ?
	$timeout_check_seconds  =  $stgs->getConf('feed_refresh');

	debugReader("NOW=".$now_time);
	debugReader("SEC=".$now_time_sec);
	debugReader("TIMEOUT IS=".$timeout_check_seconds." seconds");




	// the list of all feeds.
	$feedsTocheck = getFeeds();

	for ($i=0;$i<count($feedsTocheck);$i++) {
		$feedTocheck=$feedsTocheck[$i];

		$blog_id = $feedTocheck['id'];
		$feed_url = $feedTocheck['feed_url'];

		$last_update = $feedTocheck['last_update'];
		$last_update_secs=creaDataOraDaDB($last_update);

		$last_post_id = $feedTocheck['last_post_id'];
		
		
		// WE NEED TO REFRESH ONLY IF LAST UPDATE WAS MORE THAN ONE HOUR AGO !

		if ( $last_update_secs+$timeout_check_seconds<$now_time_sec   ) {
			// THIS FEED IS OUTDATED, CHECK IT NOW !
			debugReader("checking feed:	".$feed_url." last check was:".$last_update." (".$last_update_secs.")");

			$feed = new SimplePie();
			$feed->set_feed_url($feed_url);
			$feed->enable_cache(false);
			$feed->init();
			$feed->set_timeout($stgs->getConf('feed_timeout'));// seconds		
			$feed->handle_content_type();
	
	
			if (! $feed->error()) {
				debugReader($feed->get_title());
				
				$lastInsertedPostID=0;
				foreach ($feed->get_items() as $item) {
	
	
	
					$url = $item->get_permalink();
					$title = $item->get_title();
	
					// DATE
					$year   = @$item->get_date('Y');
					$month  = @$item->get_date('m');
					$day    = @$item->get_date('d');
					$hour   = @$item->get_date('H');
					$minute = @$item->get_date('i');
					$second = @$item->get_date('s');
					$date   = @$year."/".$month."/".$day." ".$hour.":".$minute.":".$second;
	
					// AUTHOR
					$dbAuthorID=1;//default, anonymous
					if ( $authors = @$item->get_authors() ) { 
						foreach($authors as $author) {
							$author_name  = @$author->get_name();// strtolower() ?
							$author_email = @$author->get_email();
							$author_link  = @$author->get_link();
		
							$dbAuthorID = findOrCreateNewAuthor(
								$author_name,
								$author_email,
								$author_link
							);
						}
					}
                                         
                                        //TAGS
					$postTags = "";
					if ( $tags = @$item->get_categories() ) {
						foreach ( $tags as $tag) {
							$tagLabel = $tag->get_label();
							
							$tagID = findOrCreateNewTags( strtolower($tagLabel) );
							$postTags .= ":".$tagID.":";
						}
					}
	
					
					$content = @$item->get_content();
	

					// ADD IT ONLY IF NOT PRESENT !
					$checkID=getPostIdByLink($url);
					if ($checkID==0) {
						matchDivs($content)?$state='enabled':$state='buggy';
						$query = "INSERT INTO {posts} (title, text, date, author, blog, link, tags, state) " .
							"VALUES ( '".fixApostrofe($title)."', '".fixApostrofe($content)."', '".fixApostrofe($date)."', '".$dbAuthorID."', '".$blog_id."', '".fixApostrofe($url)."', '".fixApostrofe($postTags)."', '". $state ."')";					
							
						$ptdb->query($query);
	
						// GET NEW ID
						$lastInsertedPostID=getPostIdByLink($url);
						debugReader("Added new post:$url with new id=".$lastInsertedPostID);
					} else {
						debugReader("Skipping post :$url, already present with id=".$checkID);
					}
				}	

				// WE HAVE PARSED ALL ITEMS
				// LET'S REFRESH BLOGS TABLE

				if ($lastInsertedPostID>$last_post_id) {
					$last_post_id=$lastInsertedPostID;
				}

				$query ="UPDATE {blogs} SET last_update='".$now_time."',last_post_id='".$last_post_id."' WHERE id='".$blog_id."' ;";
				$ptdb->query($query);

			} else {
				// TO DO
				debugReader($feed->error());
			}			
		} else {
			// THIS FEED IS QUITE FRESH :-)
			debugReader("skipping feed:	$feed_url    (last check:".( $now_time_sec-$last_update_secs)."seconds ago.)");
		}
		
	}
	
	if ( $stgs->getConf("delete_posts") > 0 )
		delOldPosts();
}
