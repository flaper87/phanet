<?php

function loadThemeHeader() {
	global $srv,$stgs;
	
	/* $output[]  = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
	
	$output[] = '<html xmlns="http://www.w3.org/1999/xhtml">';
	$output[] = '<head>';
	$output[] = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
	$output[] = '<title>'.$stgs->getConf("sitename").'</title>';
	
	$output[] = '<link rel="stylesheet" type="text/css" href="'.$srv->getPath('themes/phanet_dark/styles/style.css').'" />';
	$output[] = '<link rel="stylesheet" type="text/css" href="'.$srv->getPath('media/js/thickbox/ThickBox.css').'" />';
	$output[] = '<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="'.$srv->buildUrl('?feed=').'"  />';
	$output[] = '<link rel="search" type="application/opensearchdescription+xml" href="'.$srv->buildUrl('?openSearch=').'" title="'.$stgs->getConf("sitename").'" />';
	$output[] = '<link rel="icon" type="image/png" title="favicon" href="'.$srv->getPath('media/phaneticon.png').'"  />';
	
	$output[] = "<script src=\"".$srv->getPath('media/js/jquery/jquery.js')."\" type=\"text/javascript\"></script>";
	$output[] = "<script src=\"".$srv->getPath('media/js/jquery/ui/ui.base.js')."\" type=\"text/javascript\"></script>";
	$output[] = "<script src=\"".$srv->getPath('media/js/jquery/ui/ui.sortable.js')."\" type=\"text/javascript\"></script>";
	$output[] = "<script src=\"".$srv->getPath('themes/phanet_dark/styles/collapsible.js')."\" type=\"text/javascript\"></script>";
	$output[] = "<script src=\"".$srv->getPath('media/js/thickbox/thickbox.js')."\" type=\"text/javascript\"></script>";
	$output[] = '</head>';
	
	$output[] = '<body baseurl="'.$srv->getInstallRadix().'">'; */
	
	$output[] = require('child_theme/header.php');
}
