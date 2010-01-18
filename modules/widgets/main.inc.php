<?php

# DB widget string format
# {[widget_name: options]}

// The modules are included from inside the core object, 
// so their classes container have to be stored in globals
$GLOBALS["wgts"] = new widgetsHandler();

class widgetsHandler {
	
	var $isWidgets;
	var $loadedModules;
	var $loaded = array();
	
	private function loadWidgets() {
		global $ptdb, $stgs, $core;

		preg_match_all("%\[(?<widget>.*?):\s{(?<pos>.*?)}{(?<path>.*?)}{(?<deps>.*?)}{(?<args>.*?)}\]%is", $stgs->getConf("sidebar_widgets"), $widgets);
		
		foreach( $widgets['pos'] as $key => $pos) {
			
			$widget = $widgets['widget'][$key];
			
			if (!$this->checkDeps( $widget, $widgets['deps'][$key])) continue;
			
			$file = dirname(__FILE__)."/included/".$widgets['widget'][$key].".widget";
				
			if ( file_exists($file) ) {
				require_once($file);
				$this->loaded[$pos] = $widgets['widget'][$key];
			}
		}
	}
	
	private function checkDeps( $widget, $deps ) {
		global $LOADEDMODULES, $whdg;

		if ( $deps ) {
			foreach (explode(',', $deps) as $dep) {
				if ( !in_array($dep, $LOADEDMODULES)) {
					$whdg->writeLog('widgets', 'Can&#8217;t load the '.$widget.
						' unsatisfied dependencie '.$dep, '5', 'checkDeps', 'widgets/main');
					return false;
				}
			}
		}
		
		return true;
	}

	function showSidebar() {
		
		for ($i=0; $i<count($this->loaded); $i++) {
			if ($this->loaded[$i]) $func = $this->loaded[$i]."Widget";
			else continue;
			
			$items[] = $func();
		}
		
		if ( !$items )
			return "No Widgets enabled yet";
			
		echo join("\n", $items);
	}
	
	function widgetsHandler() {;
		$this->loadWidgets();
	}
}