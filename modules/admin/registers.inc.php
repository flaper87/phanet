<?php

function blogsTemplate() {
		global $srv, $admldr;
		
		$output[]  = "<div id=\"content\">";		
		
		if (!$_GET['edit']) {
			$output[] = "<form id=\"blogsList\" method=\"post\" action=\"".$srv->buildUrl('?admin=register-blogs&change=blogs', 1)."\">";
			
			$output[] = "<div id=\"navPanel\">";
				$output[] = "<div id=\"panelTitle\">";
					$output[] = "Blogs List";
				$output[] = "</div>";
			
				$output[] = "<div id=\"navBar\">";
					$output[] = "<div id=\"navButton\"><a href=\"".$srv->buildUrl('?admin=register-blogs&edit=new', 1)."\">Add</a></div>";
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
						$output[] = "<th scope=\"col\"><strong>Name</strong></th>";
						$output[] = "<th scope=\"col\"><strong>Url</strong></th>";
						$output[] = "<th scope=\"col\"><strong>Feed Url</strong></th>";
						$output[] = "<th scope=\"col\"><strong>Owner</strong></th>";
						$output[] = "<th scope=\"col\"><strong>State</strong></th>";
						
					$output[] = "</tr>";
				$output[] = "</thead>";
				
				$output[] = "<tbody>";
				
			foreach( $admldr->getAdminBlogs() as $blog):
				
				$link = $srv->buildUrl('?admin=blogs&edit='.$blog['id'], 1);
				
				$output[] = "<tr>";
				$output[] = "<th scope=\"row\" class=\"checkCol\"><input name=\"".$blog['id']."\" type=\"checkbox\" value=\"".$blog['id']."\"/></th>";
				$output[] = "<td class=\"numCol\"><p><a href=\"$link\">".$blog['id']."</a></p></td>";
				$output[] = "<td><p><a href=\"$link\">".$blog['name']."</a></p></td>";
				$output[] = "<td><p><a href=\"$link\">".$blog['url']."</a></p></td>";
				$output[] = "<td><p><a href=\"$link\">".$blog['feed_url']."</a></p></td>";
				$output[] = "<td><p><a href=\"$link\">".$blog['nickname']."</a></p></td>";
				$output[] = "<td><p>".ucwords($blog['state'])."</p></td>";
				$output[] = "</tr>";
							
			endforeach; 
				$output[] = "</tbody>";
			$output[] = "</table>";
			
			$output[] = "</form>";
	
		} else {
			if ((int) $_GET['edit']) $activeBlog = $admldr->getAdminBlogs( $_GET['edit'] );

			$output[] = "<form name=\"save\" action=\"".$srv->buildUrl('?admin=register-blogs&update=blogs', 1)."\" method=\"post\" id=\"save\">";
			
			$output[] = "<div id=\"navPanel\">";
				$output[] = "<div id=\"panelTitle\">";
					$output[] = "Add/Edit Blog";
				$output[] = "</div>";
			
				$output[] = "<div id=\"navBar\" class=\"addEditBlog\">";
					$output[] = "<input type=\"submit\" id=\"navButton\" value=\"Cancel\" name=\"cancel\" tabindex=\"12\" accesskey=\"c\">";
					$output[] = "<input type=\"submit\" id=\"navButton\" value=\"Save/Update\" name=\"save\" tabindex=\"11\" accesskey=\"s\">";
				$output[] = "</div>";
			$output[] = "</div>";
			
			$output[] = "<fieldset id=\"simpleFieldset\">";
			$output[] = "<legend id=\"simpleLegend\">Bolg related information</legend>";
	
			$output[] = "<input type=\"hidden\" name=\"blogId\" value=\"".$activeBlog[0]['id']."\">";
			$output[] = "<input type=\"hidden\" name=\"blogState\" value=\"".$activeBlog[0]['state']."\">";
			$output[] = "<input type=\"hidden\" name=\"blogOwnerId\" value=\"".$activeBlog[0]['owner_id']."\">";
			
			$output[] = "<table id=\"modifTable\">";
			$output[] = "<tr><td><p><b>Title:</b></p></td>";
			$output[] = "<td><p><input type=\"text\" class=\"expand\" name=\"blogName\" tabindex=\"1\" id=\"name\" value=\"".$activeBlog[0]['name']."\"></p></td></tr>";
			$output[] = "<tr><td><p><b>Description:</b></p></td>";
			$output[] = "<td><p><input type=\"text\" class=\"expand\" name=\"blogDescription\" tabindex=\"2\" id=\"description\" value=\"".$activeBlog[0]['description']."\"></p></td></tr>";
			$output[] = "<tr><td><p><b>URL:</b></p></td>";
			$output[] = "<td><p><input type=\"text\" class=\"expand\" name=\"blogUrl\" tabindex=\"3\" id=\"url\" value=\"".$activeBlog[0]['url']."\"></p></td></tr>";
			$output[] = "<tr><td><p><b>Feed:</b></p></td>";
			$output[] = "<td><p><input type=\"text\" class=\"expand\" name=\"blogFeed\" tabindex=\"4\" id=\"feed_url\" value=\"".$activeBlog[0]['feed_url']."\"></p></td></tr>";
			$output[] = "<tr><td><p><b>Last Update:</b></p></td>";
			$output[] = "<td><p><input type=\"text\"  class=\"expand\" name=\"last_update\" tabindex=\"5\" id=\"blogLastUpdate\" value=\"".$activeBlog[0]['last_update']."\"></p></td></tr>";
			$output[] = "</table>";
	
			$output[] = "</fieldset>";
	
			$output[] = "<fieldset style=\"vertical-align: top;\" id=\"simpleFieldset\">";
			$output[] = "<legend id=\"simpleLegend\">Owner related information</legend>";
			
			$output[] = "<table id=\"modifTable\">";
			$output[] = "<tr><td><p><b>Owner Nick:</b></p></td>";
			$output[] = "<td><p><input type=\"text\" name=\"blogOwnerNickname\" tabindex=\"6\" id=\"ownerNickname\" value=\"".$activeBlog[0]['nickname']."\"></p></td></tr>";
			$output[] = "<tr><td><p><b>Owner Name:</b></p></td>";
			$output[] = "<td><p><input type=\"text\" name=\"blogOwnerName\" tabindex=\"7\" id=\"ownerName\" value=\"".$activeBlog[0]['fullname']."\"></p></td></tr>";
			$output[] = "<tr><td><p><b>Owner Email:</b></p></td>";
			$output[] = "<td><p><input type=\"text\" name=\"blogOwnerEmail\" tabindex=\"8\" id=\"ownerEmail\" value=\"".$activeBlog[0]['email']."\"></p></td></tr>";
			$output[] = "<tr><td><p><b>Existing:</b></p></td>";
			$output[] = "<td><p>";
			
			$output[] = "<label for='existingOwner'>";
			$output[] = "<input id='existingOwner' name='existingOwner' tabindex=\"9\" type='checkbox'  value='True' / >";
			$output[] = "Use existing Owner";
			$output[] = "</label><br>";
			$output[] = "<select name=\"selectedOwner\" tabindex=\"10\" style=\"width:250px; height: 80px !important;\" size=4>";
	
			foreach ($admldr->getAdminOwners() as $owner) {
				$output[] = "<option value=\"".$owner['id']."\" title=\"".$owner['nickname']." - ".$owner['email']."\">".$owner['fullname']."</option>";
			}
			
			$output[] = "</select></p></td></tr>";
			$output[] = "</table>";
			$output[] = "</fieldset><br class=\"clear\"><br>";
			
			$output[] = "</form>";
			
		}
		$output[] = "</div>";
		echo join("\n", $output);
}

function authorsTemplate() {
		global $srv, $admldr;
 
		$output[] = "<div id=\"content\">";
				
		if (!$_GET['edit']) {
		$output[] = "<form id=\"blogsList\" method=\"post\" action=\"".$srv->buildUrl('?admin=register-authors&change=authors', 1)."\">";
	
		$output[] = "<div id=\"navPanel\">";
			$output[] = "<div id=\"panelTitle\">";
				$output[] = "Authors List";
			$output[] = "</div>";
				
				$output[] = "<div id=\"navBar\">";
					$output[] = "<div id=\"navButton\"><a href=\"".$srv->buildUrl('?admin=register-authors&edit=new', 1)."\">Add</a></div>";
					$output[] = "<span class=\"navBarText\"> | </span>";
					$output[] = "<input type=\"submit\" id=\"navButton\" value=\"Disable\" name=\"newState\">";
					$output[] = "<input type=\"submit\" id=\"navButton\" value=\"Enable\" name=\"newState\">";
				$output[] = "</div>";
			$output[] = "</div>";
			
			$output[] = "<table id=\"simpleTable\">";
				$output[] = "<thead>";
					$output[] = "<tr>";
						
						$output[] = "<th scope=\"col\" class=\"checkCol\"><input type=\"checkbox\" onclick=\"checkAll(document.getElementById('blogsList'));\" /></th>";
						$output[] = "<th scope=\"col\" class=\"numCol\"><strong>Id</strong></th>";
						$output[] = "<th scope=\"col\"><strong>Name</strong></th>";
						$output[] = "<th scope=\"col\"><strong>Email</strong></th>";
						$output[] = "<th scope=\"col\"><strong>Website</strong></th>";
						$output[] = "<th scope=\"col\"><strong>State</strong></th>";
						
					$output[] = "</tr>";
				$output[] = "</thead>";
				
				$output[] = "<tbody>";
		
		foreach( $admldr->getAdminAuthors() as $author):
			$link = $srv->buildUrl('?admin=authors&edit='.$author[id], 1);
			$output[] = "<tr>";
			$output[] = "<th scope=\"row\" class=\"checkCol\"><input name=\"".$author[id]."\" type=\"checkbox\" value=\"".$author[id]."\"/></th>";
			$output[] = "<td class=\"numCol\"><p><a href=\"$link\">".$author[id]."</a></p></td>";
			$output[] = "<td><p><a href=\"$link\">".$author[nickname]."</a></p></td>";
			$output[] = "<td><p><a href=\"$link\">".$author[email]."</a></p></td>";
			$output[] = "<td><p><a href=\"$link\">".$author[website]."</a></p></td>";
			$output[] = "<td><p>".ucwords($author[state])."</p></td>";
						
			endforeach; 
	
				$output[] = "</tbody>";
			$output[] = "</table>";
			
			$output[] = "</form>";
	
		} else {
			if ((int) $_GET['edit']) $activeAuthor = $admldr->getAdminAuthors( $_GET['edit'] );
			
			$output[] = "<form name=\"save\" action=\"".$srv->buildUrl('?admin=register-authors&update=authors', 1)."\" method=\"post\" id=\"save\">";
			
			$output[] = "<div id=\"navPanel\">";
				$output[] = "<div id=\"panelTitle\">";
					$output[] = "Add/Edit Author";
				$output[] = "</div>";
				
				$output[] = "<div id=\"navBar\" class=\"addEditAuthor\">";
					$output[] = "<input type=\"submit\" id=\"navButton\" value=\"Cancel\" name=\"cancel\" tabindex=\"5\" accesskey=\"c\">";
					$output[] = "<input type=\"submit\" id=\"navButton\" value=\"Save/Update\" name=\"save\" tabindex=\"4\" accesskey=\"s\">";
				$output[] = "</div>";
			$output[] = "</div>";
		
			$output[] = "<fieldset id=\"simpleFieldset\" class=\"authorsFieldset\">";
			$output[] = "<legend id=\"simpleLegend\">Author Related Information</legend>";
			
			$output[] = "<input type=\"hidden\" name=\"authorId\" value=\"".$activeAuthor[0][id]."\">";
			
			$output[] = "<table id=\"modifTable\">";
			$output[] = "<tr><td><p><b>Nickname:</b></p></td>";
			$output[] = "<td><p><input type=\"text\" name=\"authorNickname\" tabindex=\"1\" id=\"nickname\" value=\"".$activeAuthor[0][nickname]."\"></p></td></tr>";
			$output[] = "<tr><td><p><b>Email:</b></p></td>";
			$output[] = "<td><p><input type=\"text\" name=\"authorEmail\" tabindex=\"2\" id=\"email\" value=\"".$activeAuthor[0][email]."\"></p></td></tr>";
			$output[] = "<tr><td><p><b>Website:</b></p></td>";
			$output[] = "<td><p><input type=\"text\" name=\"authorWebsite\" tabindex=\"3\" id=\"url\" value=\"".$activeAuthor[0][website]."\"></p></td></tr>";
			$output[] = "</table>";
	
			$output[] = "</fieldset>";
			
			$output[] = "</form>";
			
		}
		$output[] = "</div>";
		echo join("\n", $output);
}

function usersTemplate() {
		global $srv, $admldr;
 
		$output[] = "<div id=\"content\">";
				
		if (!$_GET['edit']) {
		$output[] = "<form id=\"blogsList\" method=\"post\" action=\"".$srv->buildUrl('?admin=register-users&change=users', 1)."\">";
	
		$output[] = "<div id=\"navPanel\">";
			$output[] = "<div id=\"panelTitle\">";
				$output[] = "Users List";
			$output[] = "</div>";
				
				$output[] = "<div id=\"navBar\">";
					$output[] = "<div id=\"navButton\"><a href=\"".$srv->buildUrl('?admin=register-users&edit=new', 1)."\">Add</a></div>";
					$output[] = "<span class=\"navBarText\"> | </span>";
					$output[] = "<input type=\"submit\" id=\"navButton\" value=\"Delete\" name=\"remove\">";
					$output[] = "<span class=\"navBarText\"> | </span>";
					$output[] = "<input type=\"submit\" id=\"navButton\" value=\"Disable\" name=\"newState\">";
					$output[] = "<input type=\"submit\" id=\"navButton\" value=\"Enable\" name=\"newState\">";
				$output[] = "</div>";
			$output[] = "</div>";
			
			$output[] = "<table id=\"simpleTable\">";
				$output[] = "<thead>";
					$output[] = "<tr>";
						
						$output[] = "<th scope=\"col\" class=\"checkCol\"><input type=\"checkbox\" onclick=\"checkAll(document.getElementById('blogsList'));\" /></th>";
						$output[] = "<th scope=\"col\" class=\"numCol\"><strong>Id</strong></th>";
						$output[] = "<th scope=\"col\"><strong>Nickname</strong></th>";
						$output[] = "<th scope=\"col\"><strong>Fullname</strong></th>";
						$output[] = "<th scope=\"col\"><strong>Email</strong></th>";
						$output[] = "<th scope=\"col\"><strong>Website</strong></th>";
						$output[] = "<th scope=\"col\"><strong>Status</strong></th>";
						$output[] = "<th scope=\"col\"><strong>Permissions</strong></th>";
						
					$output[] = "</tr>";
				$output[] = "</thead>";
				
				$output[] = "<tbody>";
		
		$status_type = array(
						"E" => "Enabled",
						"D" => "Disabled",
						"M" => "Mail Confirmation",
						"A" => "Admin",
						"U" => "Normal User"
						);
						
		foreach( $admldr->getAdminUsers() as $user):
			$link = $srv->buildUrl('?admin=users&edit='.$user[id], 1);
			$output[] = "<tr>";
			$output[] = "<th scope=\"row\" class=\"checkCol\"><input name=\"".$user[id]."\" type=\"checkbox\" value=\"".$user[id]."\"/></th>";
			$output[] = "<td class=\"numCol\"><p><a href=\"$link\">".$user[id]."</a></p></td>";
			$output[] = "<td><p><a href=\"$link\">".$user[nickname]."</a></p></td>";
			$output[] = "<td><p><a href=\"$link\">".$user[fullname]."</a></p></td>";
			$output[] = "<td><p><a href=\"$link\">".$user[email]."</a></p></td>";
			$output[] = "<td><p><a href=\"$link\">".$user[website]."</a></p></td>";
			$output[] = "<td><p>".$status_type[$user[status]]."</p></td>";
			$output[] = "<td><p>".$status_type[$user[usertype]]."</p></td>";
						
			endforeach; 
	
				$output[] = "</tbody>";
			$output[] = "</table>";
			
			$output[] = "</form>";
	
		} else {
			if ((int) $_GET['edit']) $activeUser = $admldr->getAdminUsers( $_GET['edit'] );

			$output[] = "<form name=\"save\" action=\"".$srv->buildUrl('?admin=register-users&update=users', 1)."\" method=\"post\" id=\"save\">";
			
			$output[] = "<div id=\"navPanel\">";
				$output[] = "<div id=\"panelTitle\">";
					$output[] = "Add/Edit User";
				$output[] = "</div>";
			
				$output[] = "<div id=\"navBar\" class=\"addEditBlog\">";
					$output[] = "<input type=\"submit\" id=\"navButton\" value=\"Cancel\" name=\"cancel\" tabindex=\"12\" accesskey=\"c\">";
					$output[] = "<input type=\"submit\" id=\"navButton\" value=\"Save/Update\" name=\"save\" tabindex=\"11\" accesskey=\"s\">";
				$output[] = "</div>";
			$output[] = "</div>";
			
			$output[] = "<fieldset id=\"simpleFieldset\">";
			$output[] = "<legend id=\"simpleLegend\">Bolg related information</legend>";
	
			$output[] = "<input type=\"hidden\" name=\"userId\" value=\"".$activeUser[0]['id']."\">";
			
			$output[] = "<table id=\"modifTable\">";
			$output[] = "<tr><td><p><b>Nickname:</b></p></td>";
			$output[] = "<td><p><input type=\"text\" class=\"expand\" name=\"userNick\" tabindex=\"1\" id=\"name\" value=\"".$activeUser[0]['nickname']."\"></p></td></tr>";
			$output[] = "<tr><td><p><b>Password:</b></p></td>";
			$output[] = "<td><p><input type=\"password\" class=\"expand\" name=\"userPass\" tabindex=\"1\" id=\"name\"></p></td></tr>";
			$output[] = "<tr><td><p><b>Fullname:</b></p></td>";
			$output[] = "<td><p><input type=\"text\" class=\"expand\" name=\"userName\" tabindex=\"2\" id=\"description\" value=\"".$activeUser[0]['fullname']."\"></p></td></tr>";
			$output[] = "<tr><td><p><b>Website:</b></p></td>";
			$output[] = "<td><p><input type=\"text\" class=\"expand\" name=\"userUrl\" tabindex=\"3\" id=\"url\" value=\"".$activeUser[0]['website']."\"></p></td></tr>";
			$output[] = "<tr><td><p><b>Email:</b></p></td>";
			$output[] = "<td><p><input type=\"text\" class=\"expand\" name=\"userEmail\" tabindex=\"4\" id=\"feed_url\" value=\"".$activeUser[0]['email']."\"></p></td></tr>";
			$output[] = "</table>";
	
			$output[] = "</fieldset>";
	
			$output[] = "<fieldset style=\"vertical-align: top;\" id=\"simpleFieldset\">";
			$output[] = "<legend id=\"simpleLegend\">Owner related information</legend>";
			
			$output[] = "<table id=\"modifTable\">";
			$output[] = "<tr><td><p><b>User State</b></p></td>";
			$output[] = "<td><p>";

			$output[] = "<select name=\"userStatus\" tabindex=\"5\" style=\"width:180px;\" >";
	
			foreach (array( "E" => "Enabled", "D" => "Disabled") as $key => $state) {
				$selected = "";
				if ($activeUser[0]['status'] == $key ) $selected = 'selected="selected"';
				$output[] = "<option value=\"".$key."\" title=\"".$key." - ".$state."\" $selected >".$state."</option>";
			}
			$output[] = "</select></p></td></tr>";
			$output[] = "<tr><td><p><b>User Permissions:</b></p></td>";
			$output[] = "<td><p>";
			
			$output[] = "<select name=\"userType\" tabindex=\"6\" style=\"width:180px;\" >";
	
			foreach (array( "U" => "Normal User", "A" => "Admin") as $key => $state) {
				$selected = "";
				if ($activeUser[0]['usertype'] == $key ) $selected = 'selected="selected"';
				$output[] = "<option value=\"".$key."\" title=\"".$key." - ".$state."\" $selected >".$state."</option>";
			}
			$output[] = "</select></p></td></tr>";
			
			$output[] = "<tr><td><p><b>User Author Nick:</b></p></td>";
			$output[] = "<td><p>";
			
			$output[] = "<select name=\"userAId\" tabindex=\"7\" style=\"width:180px;\" >";
			$output[] = "<option value=\"0\" title=\"No Author Related\">No Author Related</option>";
			foreach ( $admldr->getAdminAuthors() as $author ) {
				$selected = "";
				if ($activeUser[0]['author_id'] == $author["id"] ) $selected = 'selected="selected"';
				$output[] = "<option value=\"".$author[id]."\" title=\"".$author[nickname]." - ".$author[website]."\" $selected >".$author[nickname]."</option>";
			}
			
			$output[] = "</select></p></td></tr>";

			$output[] = "</table>";
			$output[] = "</fieldset><br class=\"clear\"><br>";
			
			$output[] = "</form>";
		}
		$output[] = "</div>";
		echo join("\n", $output);
}
