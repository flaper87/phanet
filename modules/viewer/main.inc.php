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

function loader_actions() {
	return array("loadinfo"=>"loader_read");
}


/**
 * viewer_dispaly
 *
 * Main Viewer function
 *
 * This function loads everything need to create a view, posts, theme and data.
 *
 * @param $params Set for compatibility.
 *
 * @version 0.1
 */
function viewer_display($params){
	global $ptdb, $core, $stgs, $mTpr;
	
	if ( $stgs->getConf('web_update') == "enabled" ) {
		$core->callAction('read');
	}
	
	$mTpr->launchTheme();
}
