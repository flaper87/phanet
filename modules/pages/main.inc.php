<?php
/**
* Written by Flavio Percoco Premoli, started January 2008.
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


function back_actions(){
    return array("back"=>"go_back");
}

function createPaging() {
    global $srv, $ptdb;
    
     ($_GET["page"])?$pos = $_GET["page"]:$pos = 1;
    
    $total = round(countPosts()/20);

    if ($total == 0) return $total+1;
	
    if ( ($ini = $pos - 2) <= 1) $ini = 1;
    else $output .= "<a href='".$srv->buildUrl("?page=1")."'>First Page</a>...";

    if ( $total >= ( $lim = $pos+2 ) ) $lim = $pos+2;

    for ( $t=$ini; $t<=$lim; $t++ ) {
        if (($t) != $pos) {
            $output  .= "<a href='".$srv->buildUrl("?page=".$t)."'>".$t."</a> ";                
        } else {
            $output  .= $t." ";                
        }
        if ($t == $total) break;
    }
    
    if ( $total >= ($pos+2) ) $output .= "...<a href='".$srv->buildUrl("?page=".$total, True)."'>Last Page</a> ";
    
    echo $output;
    
}
