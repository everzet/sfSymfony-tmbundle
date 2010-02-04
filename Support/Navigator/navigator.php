<?php

$projectPath = $_ENV['TM_PROJECT_DIRECTORY'];
$args = $_SERVER['argv'];

if (isset($args[1]))
{
  switch ($args[1])
  {
    case 'cmd':
      system($projectPath . '/symfony ' . $args[2]);
      break;
  }
}
else
{
  system($projectPath . '/symfony list --xml');
}
