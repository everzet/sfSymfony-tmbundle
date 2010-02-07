<?php

require_once dirname(__FILE__) . '/browser.php';

$config = array();
preg_match('/class.*extends *(.*)[ \n]/', file_get_contents('php://stdin'), $config);

if (isset($config[1]))
{
	require_once(getenv('TM_BUNDLE_SUPPORT') . '/Scripts/browser.php');
	echo makePage('http://www.symfony-project.org/api/search/1_4?search=' . $config[1]);
}
else
{
	echo "<h3>Couldn't find base class</h3>";
}