<?php

$GLOBALS['admldr'] = new adminLoader();

class adminLoader {
	
	var $ptdb;
	
	function adminLoader() {
		global $ptdb;
		
		$this->ptdb = $ptdb;
	}

	function getAdminCategories( $id = '' ) {
		global $ptdb;
		
		if ( $id ) $where = " WHERE id='$id'";
		
		$query = "SELECT * FROM {categories} $where";
		$ptdb->query($query);
		
		return $ptdb->fetchArray();
	}
		
	function getAdminUsers( $id = '' ) {
		global $ptdb;
		
		if ($id) $where = " WHERE id=$id";
		
		$query = "SELECT * FROM {users} $where ORDER BY ID";
		$ptdb->query($query);
		
		return $ptdb->fetchArray();
	}
	
	function getSingleInf( $table, $by, $value ) {
		$query = "SELECT * FROM {".$table."} WHERE $by='$value'";
	
		$this->ptdb->query($query);
		return $this->ptdb->fetchArray();
	}
	
	function getAdminAuthors( $id = '') {
		
		if ($id) $queryWhere = " WHERE id=$id";
		$query = "SELECT * FROM {authors} $queryWhere";
	
		$this->ptdb->query($query);
		return $this->ptdb->fetchArray();
	}
	
	function getAdminBlogs( $id = '' ) {

		if ( $id ) $idParam = "and b.id=".$id;
		
		$query = "SELECT b.*, o.nickname, o.fullname, o.email
					FROM {blogs} b 
					INNER JOIN {owners} o
					ON b.owner_id=o.id $idParam";
	
		$this->ptdb->query($query);
		return $this->ptdb->fetchArray();
	}
	
	function getAdmins() {
		$query = "SELECT * FROM {users} WHERE usertype='A'";
	
		$this->ptdb->query($query);
		return $this->ptdb->fetchArray();
	}
	
	function getAdminPosts( $limit = 0){
		global $ptdb, $showPage;
		
		$query	= "SELECT p.*, b.name, b.url, a.nickname, a.website, a.email" .
					" FROM {posts} AS p, {authors} AS a, {blogs} as b" . 
					" WHERE a.id=p.author AND a.state!='disabled' AND b.id=p.blog" . 
					" ORDER BY date DESC ";
		
		$this->ptdb->query($query);
		return $this->ptdb->fetchArray();

	}
	
	function getAdminPages( $id = '' ){
		global $ptdb, $showPage;
		
		if ($id) $where = " WHERE id=$id";
		
		$query	= "SELECT * FROM {pages} $where";
		
		$this->ptdb->query($query);
		return $this->ptdb->fetchArray();

	}
	
	function getAdminOwners() {
		
		$this->ptdb->query("SELECT * FROM {owners}");
		return $this->ptdb->fetchArray();
	}
	
	function getEnWidgets() {
		global $stgs;
		
		preg_match_all("%\[(?<widget>.*?):\s{(?<pos>.*?)}{(?<path>.*?)}{(?<deps>.*?)}{(?<args>.*?)}\]%is", $stgs->getConf("sidebar_widgets"), $widgets);
		
		foreach( $widgets['pos'] as $key => $pos) {
			$enable[$pos]['name'] = $widgets['widget'][$key];
			$enable[$pos]['path'] = $widgets['path'][$key];
		}
		return $enable;
	}
	
	function recDirScan($directory, $filter=FALSE) {
		// if the path has a slash at the end we remove it here
		if(substr($directory,-1) == '/')
		{
			$directory = substr($directory,0,-1);
		}
	
		// if the path is not valid or is not a directory ...
		if (!file_exists($directory) || !is_dir($directory)) {
			// ... we return false and exit the function
			return FALSE;
	
		// ... else if the path is readable
		} elseif (is_readable($directory)) {
			// we open the directory
			$directory_list = opendir($directory);
	
			// and scan through the items inside
			while (FALSE !== ($file = readdir($directory_list))) {
				// if the filepointer is not the current directory
				// or the parent directory
				if ($file != '.' && $file != '..' && $file != ".svn") {
					// we build the new path to scan
					$path = $directory.'/'.$file;
	
					// if the path is readable
					if (is_readable($path)) {
						// we split the new path by directories
						$subdirectories = explode('/',$path);
	
						// if the new path is a directory
						if (is_dir($path)) {
							// add the directory details to the file list
							$directory_tree[] = array(
								'path'    => $path,
								'name'    => end($subdirectories),
								'kind'    => 'directory',
	
								// we scan the new path by calling this function
								'content' => $this->recDirScan($path, $filter));
	
						// if the new path is a file
						} elseif (is_file($path)) {
							// get the file extension by taking everything after the last dot
							$extension = end(explode('.',end($subdirectories)));
	
							// if there is no filter set or the filter is set and matches
							if ($filter === FALSE || $filter == $extension) {
								// add the file details to the file list
								$name = explode('.',end($subdirectories));
								$path = str_replace( end($subdirectories), "", $path );
								
								$directory_tree[] = array(
									'path'      => $path,
									'name'      => $name[0],
									'extension' => $extension,
									'size'      => filesize($path),
									'kind'      => 'file');
							}
						}
					}
				}
			}
			// close the directory
			closedir($directory_list); 
	
			// return file list
			return $directory_tree;
	
		// if the path is not readable ...
		}else{
			// ... we return false
			return FALSE;	
		}
	}
}
