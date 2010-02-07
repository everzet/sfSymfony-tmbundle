<?php

require_once dirname(__FILE__) . '/../Lib/sfBundle.class.php';

$args = $_SERVER['argv'];

if (isset($args[1]))
{
  switch ($args[1])
  {
    case 'cmd':
      sfBundle::runCLICommand($args[2]);
      if (false !== strpos($args[2], 'generate') || false !== strpos($args[2], 'build'))
      {
        TextMate::rescanProject();
      }
      break;
  }
}
else
{
  sfBundle::runCLICommand('list --xml');
}
