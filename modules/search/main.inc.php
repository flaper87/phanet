<?php

function showSearchEngine() {
	global $srv, $stgs;
	
	$output  = "<?xml version=\"1.0\"?>";
	$output .= "<OpenSearchDescription xmlns=\"http://a9.com/-/spec/opensearch/1.1/\">";
	$output .= "<ShortName>".$stgs->getConf('sitename')."&#8217;s Search</ShortName>";
	$output .= "<Description>";
	$output .= $stgs->getConf('sitename')."&#8217;s Search Engine";
	$output .= "</Description>";
	$output .= "<Image width=\"16\" height=\"16\">".$srv->getPath("media/phaneticon.png")."</Image>";
	$output .= "<Url type=\"text/html\" method=\"get\" template=\"".$srv->buildUrl("?search={searchTerms}", True)."\"/>";
	$output .= "<Url type=\"application/x-suggestions+json\" method=\"GET\" template=\"".$srv->buildUrl("?search={searchTerms}", True)."\"/>";
	$output .= "</OpenSearchDescription>";
	
	echo $output;
}

function checkIfSearch() {
	global $srv;
	
	//if ( isset($_POST["searchPosts"]) ) $_GET['search'] = $_POST["searchQuery"];

	if ( isset($_GET["search"])) {
		$searchArray = parseSearch($_GET["search"]);
		
		foreach ($searchArray as $type => $query) {
			if ($query{0} == " ") $query = substr($query, 1);

			switch($type) {
				case "title":
					$queryWhere .= " AND p.title like '%".fixApostrofe($query)."%'";
					break;
				case "date":
					$queryWhere .= " AND p.date like '%".fixApostrofe($query)."%'";
					break;
				case "author":
					$queryWhere .= " AND a.nickname like '%".fixApostrofe($query)."%'";
					break;
				default:
					$queryWhere .= " AND p.text like '%".fixApostrofe($query)."%'";	
					break;	
			}
		}
	} elseif (isset($_POST['advanceSearch'])) {
		if ($_POST['titleSearch']) 
			$queryWhere .= " AND p.title like '%".fixApostrofe($_POST['titleSearch'])."%'";
		elseif ($_POST['dateSearch'])
			$queryWhere .= " AND p.date like '%".fixApostrofe($_POST['dateSearch'])."%'";
		elseif ($_POST['authorSearch'])
			$queryWhere .= " AND a.nickname like '%".fixApostrofe($_POST['authorSearch'])."%'";
		elseif ($_POST['contentSearch'])
			$queryWhere .= " AND p.text like '%".fixApostrofe($_POST['contentSearch'])."%'";			
	}
	
	if(isset($queryWhere)) : return $queryWhere; endif;
}
