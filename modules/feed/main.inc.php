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

function feed_actions() {
	return array("feedinfo"=>"doFeed");
}

function showFeed() {
	global $stgs, $srv;
	
	@header('Content-Type: text/xml; charset=UTF-8', true);
	$more = 1;
	
	$output .= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
	
	$output .= "<rss version=\"2.0\"
		xmlns:content=\"http://purl.org/rss/1.0/modules/content/\"
		xmlns:wfw=\"http://wellformedweb.org/CommentAPI/\"
		xmlns:dc=\"http://purl.org/dc/elements/1.1/\"
		xmlns:atom=\"http://www.w3.org/2005/Atom\"	
		>";
		
	$output .= "<channel>";
		$output .= "<atom:link href=\"".$srv->getInstallRadix()."?feed=\" rel=\"self\" type=\"application/rss+xml\" />";
		$output .= "<title>".$stgs->getConf('sitename')."</title>";
		$output .= "<link>".$srv->getInstallRadix()."</link>";
		$output .= "<description>".$stgs->getConf('sitedescription')."</description>";
		
		$posts = getPosts( 10 );
		foreach(  $posts as $post):
		$output .= "<item>";
			$output .= "<title>".html_entity_decode($post->title)."</title>";
			$output .= "<guid isPermaLink=\"false\">".$post->link."</guid>";
			$output .= "<link>".$post->link."</link>";
			$output .= "<description>".$post->text."</description>";
			$output .= "<pubDate>".get_date('r', $post->date)."</pubDate>";
			$author  = ($post->nickname == "anonymous" or !$post->nickname)?$post->owner_nick:$post->nickname;
			$output .= "<dc:creator>".$author."</dc:creator>";	
		$output .= "</item>";
		endforeach;
	$output .= "</channel>";
	$output .= "</rss>";
	echo $output;
}
