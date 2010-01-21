<?php

$stgs = new stgsManager();

class stgsManager {
	private $dbStgs;
	private $settings;
	
	var $actions;
	
	/**
	 * Get's the settings from the settings.inc.php file.
	 *
	 */
	private function loadDbConf(){
		global $SETTINGS;
		
		$this->dbStgs = $SETTINGS;
		
		if(!isset($this->dbStgs['db_port'])) {
			$this->dbStgs['db_port'] = 1433;
		}

		$this->dbStgs['url'] = $this->dbStgs['db_type']."://".$this->dbStgs['db_user'].":".
							   $this->dbStgs['db_password']."@".$this->dbStgs['db_server'].
							":".$this->dbStgs['db_port']."/".$this->dbStgs['db_database'];
		unset($SETTINGS);
	}
	
	/**
	 * Load the settings from the database table.
	 *
	 */
	function loadSettings() {
		global $mTpr;
		
		foreach( getSettings() as $s ) {
			addSubarray($this->settings, $s['keyid'], $s['value']);
		}
		
		$this->actions = getActions();
		$mTpr->loadTheme();
	}
	
	function isAction( $action ) {
		if ( in_array($action, $this->actions) ) return True;
	}
	
	function getConf( $key ) {
		return $this->settings[$key];
	}
	
	function getDBInf( $item ) {
		return $this->dbStgs[$item];
	}
	
	function stgsManager() {
		$this->loadDBConf();
	}
}
