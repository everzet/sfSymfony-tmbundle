<?php

require_once dirname(__FILE__) . '/browser.php';

$config = array();
preg_match('/# .*the symfony website:\n# (.*)\n/', file_get_contents('php://stdin'), $config);

$url = null;
if (isset($config[1]))
{
	$url = $config[1];
}
else
{
	switch(getenv('TM_FILENAME'))
	{
		case 'settings.yml':
			$url = 'http://www.symfony-project.org/reference/1_4/en/04-Settings';
			break;
		case 'factories.yml':
			$url = 'http://www.symfony-project.org/reference/1_4/en/05-Factories';
			break;
		case 'generator.yml':
			$url = 'http://www.symfony-project.org/reference/1_4/en/06-Generator';
			break;
		case 'databases.yml':
			$url = 'http://www.symfony-project.org/reference/1_4/en/07-Databases';
			break;
		case 'security.yml':
			$url = 'http://www.symfony-project.org/reference/1_4/en/08-Security';
			break;
		case 'cache.yml':
			$url = 'http://www.symfony-project.org/reference/1_4/en/09-Cache';
			break;
		case 'routing.yml':
			$url = 'http://www.symfony-project.org/reference/1_4/en/10-Routing';
			break;
		case 'app.yml':
			$url = 'http://www.symfony-project.org/reference/1_4/en/11-App';
			break;
		case 'filters.yml':
			$url = 'http://www.symfony-project.org/reference/1_4/en/12-Filters';
			break;
		case 'view.yml':
			$url = 'http://www.symfony-project.org/reference/1_4/en/13-View';
			break;
	}
}

if ($url)
{
  require_once(getenv('TM_BUNDLE_SUPPORT') . '/Scripts/browser.php');
  echo makePage($url);
}
else
{
  echo "<h3>Couldn't find help page for this config file</h3>";
}