<?php

function postsTemplate() {
    global $srv, $admldr;
    
    if ( $_POST["remove"] ) {
    }
    
    $output[]  = "<div id=\"content\">";		
    
        $output[] = "<form id=\"blogsList\" method=\"post\" action=\"".$srv->buildUrl('?admin=posts&update=posts', 1)."\">";
        
        $output[] = "<div id=\"navPanel\">";
            $output[] = "<div id=\"panelTitle\">";
                $output[] = "Posts List";
            $output[] = "</div>";
        
            $output[] = "<div id=\"navBar\">";
                //$output[] = "<input type=\"submit\" id=\"navButton\" value=\"Delete\" name=\"remove\">";
                //$output[] = "<span class=\"navBarText\"> | </span>";
                $output[] = "<input type=\"submit\" id=\"navButton\" value=\"Disable\" name=\"newState\">";
                $output[] = "<input type=\"submit\" id=\"navButton\" value=\"Enable\" name=\"newState\">";
            $output[] = "</div>";
        $output[] = "</div>";
        
        $output[] = "<table id=\"simpleTable\" class=\"blogsTable\">";
            $output[] = "<thead>";
                $output[] = "<tr>";
                    
                    $output[] = "<th scope=\"col\" class=\"checkCol\"><input type=\"checkbox\" onclick=\"checkAll(document.getElementById('blogsList'));\" /></th>";
                    $output[] = "<th scope=\"col\" class=\"numCol\"><strong>Id</strong></th>";
                    $output[] = "<th scope=\"col\"><strong>Title</strong></th>";
                    $output[] = "<th scope=\"col\"><strong>Date</strong></th>";
                    $output[] = "<th scope=\"col\"><strong>Author</strong></th>";
                    $output[] = "<th scope=\"col\"><strong>Blog</strong></th>";
                    $output[] = "<th scope=\"col\"><strong>State</strong></th>";
                    
                $output[] = "</tr>";
            $output[] = "</thead>";
            
            $output[] = "<tbody>";
            
        foreach( $admldr->getAdminPosts() as $post):
            
            $output[] = "<tr>";
            $output[] = "<th scope=\"row\" class=\"checkCol\"><input name=\"".$post['id']."\" type=\"checkbox\" value=\"".$post['id']."\"/></th>";
            $output[] = "<td class=\"numCol\"><p><a href=\"$link\">".$post['id']."</a></p></td>";
            $output[] = "<td><p><a href=\"".$post['link']."\">".$post['title']."</a></p></td>";
            $output[] = "<td><p>".$post['date']."</p></td>";
            $output[] = "<td><p>".$post['nickname']."</p></td>";
            $output[] = "<td><p><a href=\"".$post['url']."\">".$post['name']."</a></p></td>";
            $output[] = "<td><p>".ucwords($post['state'])."</p></td>";
            
            $output[] = "</tr>";
                        
        endforeach; 
            $output[] = "</tbody>";
        $output[] = "</table>";
        
        $output[] = "</form>";

    $output[] = "</div>";
    echo join("\n", $output);
}

function pagesTemplate() {
    global $srv, $admldr;

    $output[]  = "<div id=\"content\">";
    
    if (!$_GET['edit']) {
        
            $output[] = "<form id=\"blogsList\" method=\"post\" action=\"".$srv->buildUrl('?admin=pages&change=pages', 1)."\">";
            
            $output[] = "<div id=\"navPanel\">";
                $output[] = "<div id=\"panelTitle\">";
                    $output[] = "Pages List";
                $output[] = "</div>";
            
                $output[] = "<div id=\"navBar\">";
                    $output[] = "<div id=\"navButton\"><a href=\"".$srv->buildUrl('?admin=contents-pages&edit=new', 1)."\">Add</a></div>";
                    $output[] = "<span class=\"navBarText\"> | </span>";
                    $output[] = "<input type=\"submit\" id=\"navButton\" value=\"Delete\" name=\"remove\">";
                    $output[] = "<span class=\"navBarText\"> | </span>";
                    $output[] = "<input type=\"submit\" id=\"navButton\" value=\"Disable\" name=\"newState\">";
                    $output[] = "<input type=\"submit\" id=\"navButton\" value=\"Enable\" name=\"newState\">";
                $output[] = "</div>";
            $output[] = "</div>";
            
            $output[] = "<table id=\"simpleTable\" class=\"blogsTable\">";
                $output[] = "<thead>";
                    $output[] = "<tr>";
                        
                        $output[] = "<th scope=\"col\" class=\"checkCol\"><input type=\"checkbox\" onclick=\"checkAll(document.getElementById('blogsList'));\" /></th>";
                        $output[] = "<th scope=\"col\" class=\"numCol\"><strong>Id</strong></th>";
                        $output[] = "<th scope=\"col\"><strong>Title</strong></th>";
                        $output[] = "<th scope=\"col\"><strong>Date</strong></th>";
                        $output[] = "<th scope=\"col\"><strong>State</strong></th>";
                        
                    $output[] = "</tr>";
                $output[] = "</thead>";
                
                $output[] = "<tbody>";
                
            foreach( $admldr->getAdminPages() as $page):
                
                $link = $srv->buildUrl('?admin=pages&edit='.$page['id'], 1);
                
                $output[] = "<tr>";
                $output[] = "<th scope=\"row\" class=\"checkCol\"><input name=\"".$page['id']."\" type=\"checkbox\" value=\"".$page['id']."\"/></th>";
                $output[] = "<td class=\"numCol\"><p><a href=\"$link\">".$page['id']."</a></p></td>";
                $output[] = "<td><p><a href=\"$link\">".$page['page_title']."</a></p></td>";
                $output[] = "<td><p>".$page['page_date']."</p></td>";
                $output[] = "<td><p>".ucwords($page['state'])."</p></td>";
                
                $output[] = "</tr>";
                            
            endforeach; 
                $output[] = "</tbody>";
            $output[] = "</table>";
            
            $output[] = "</form>";
        
    } else {
            if ((int) $_GET['edit']) $activePage = $admldr->getAdminPages( $_GET['edit'] );

			$output[] = "<form name=\"save\" action=\"".$srv->buildUrl('?admin=contents-pages&update=pages', 1)."\" method=\"post\" id=\"save\">";
			
			$output[] = "<div id=\"navPanel\">";
				$output[] = "<div id=\"panelTitle\">";
					$output[] = "Add/Edit Page";
				$output[] = "</div>";
			
				$output[] = "<div id=\"navBar\" class=\"addEditBlog\">";
					$output[] = "<input type=\"submit\" id=\"navButton\" value=\"Cancel\" name=\"cancel\" tabindex=\"12\" accesskey=\"c\">";
					$output[] = "<input type=\"submit\" id=\"navButton\" value=\"Save/Update\" name=\"save\" tabindex=\"11\" accesskey=\"s\">";
				$output[] = "</div>";
			$output[] = "</div>";
			
			$output[] = "<fieldset style=\"width: 850px; !important; \" id=\"simpleFieldset\">";
			$output[] = "<legend id=\"simpleLegend\">Bolg related information</legend>";
	
			$output[] = "<input type=\"hidden\" name=\"pageId\" value=\"".$activePage[0]['id']."\">";
			$output[] = "<input type=\"hidden\" name=\"pageState\" value=\"".$activePage[0]['state']."\">";
			
			$output[] = "<table id=\"modifTable\">";
			$output[] = "<tr><td><p><b>Title:</b></p></td>";
			$output[] = "<td><p><input type=\"text\" size=\"80\" name=\"pageTitle\" tabindex=\"1\" id=\"name\" value=\"".$activePage[0]['page_title']."\"></p></td></tr>";
			$output[] = "<tr><td><p><b>Content:</b></p></td>";
            $output[] = "<td><p><TEXTAREA name=\"pageContent\" rows=\"15\" cols=\"90\" tabindex=\"2\">";
            if ($activePage[0]['page_content']) {
                $output[] = $activePage[0]['page_content'];
            }
            $output[] = "</TEXTAREA></p></td></tr>";
			
			$output[] = "</table>";
	
			$output[] = "</fieldset>";
			
			$output[] = "</form>";
			
    }
    
        $output[] = "</div>";
        
    echo join("\n", $output);
}
