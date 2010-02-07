<?php

$args = $_SERVER['argv'];

function getSymfonyRunner()
{
  $projectPath = getenv('TM_PROJECT_DIRECTORY');
  $symfonyPath = getenv('SF_SCRIPT_PATH');

  if ($projectPath && is_file($projectPath . '/symfony'))
  {
    return $projectPath . '/symfony ';
  }

  if ($symfonyPath)
  {
    return $symfonyPath . ' ';
  }

  return 'symfony ';
}

if (isset($args[1]))
{
  switch ($args[1])
  {
    case 'cmd':
      system(getSymfonyRunner() . $args[2]);
      break;
  }
}
else
{
  system(getSymfonyRunner() . 'list --xml');
}
