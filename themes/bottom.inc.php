<?php

function showThemeBottom() {
	global $activetheme;
	$output[] = require($activetheme.'/footer.php');
}
