<?php

/*
 * This file is part of the sfSymfony-tmbundle.
 * (c) 2010 Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// Including TextMate helper
require_once dirname(__FILE__) . '/TextMate.class.php';

/**
 * sfBundle does things.
 *
 * @package    sfSymfony-tmbundle
 * @subpackage bundle
 * @author     Konstantin Kudryashov <ever.zet@gmail.com>
 * @version    1.0.0
 */
class sfBundle
{
  public static function getSplittableSpacesCount($text)
  {
    $matches = array();

    if (false === preg_match('/^( *)/', $text, $matches))
    {
      return 0;
    }
    else
    {
      return strlen($matches[1]);
    }
  }

  public static function splitSpacesAtStart($text, $count)
  {
    return preg_replace(sprintf("/(^|\n)%s/", str_repeat(' ', $count)), "$1", $text);
  }

  public static function getSymfonyCLI()
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

  public static function runSymfonyCLICommand($cmd)
  {
    system(self::getSymfonyCLI() . $cmd);
  }

  /**
   * Returns base class for filename
   *
   * @param string $filename file name
   * @return string base class
   * @author Konstantin Kudryashov <ever.zet@gmail.com>
   */
  public static function getBaseClassForCurrentFile()
  {
    $filename = TextMate::getEnv('filename');

    if (false !== strpos($filename, 'actions.class.php'))
    {
      return 'sfActions';
    }
    elseif (false !== strpos($filename, 'Action.class.php'))
    {
      return 'sfAction';
    }
    elseif (false !== strpos($filename, 'components.class.php'))
    {
      return 'sfComponents';
    }
    elseif (false !== strpos($filename, 'Component.class.php'))
    {
      return 'sfComponent';
    }
    elseif (false !== strpos($filename, 'Form.class.php'))
    {
      return 'sfForm';
    }
    elseif (false !== strpos($filename, 'FormDoctrine.class.php'))
    {
      return 'sfFormDoctrine';
    }
    elseif (false !== strpos($filename, 'FormPropel.class.php'))
    {
      return 'sfFormPropel';
    }
    elseif (false !== strpos($filename, 'FormFilter.class.php'))
    {
      return 'sfFormFilter';
    }
    elseif (false !== strpos($filename, 'Filter.class.php'))
    {
      return 'sfFilter';
    }
    elseif (false !== strpos($filename, 'ProjectConfiguration.class.php'))
    {
      return 'sfProjectConfiguration';
    }
    elseif (false !== strpos($filename, 'PluginConfiguration.class.php'))
    {
      return 'sfPluginConfiguration';
    }
    elseif (false !== strpos($filename, 'Configuration.class.php'))
    {
      return 'sfApplicationConfiguration';
    }
    elseif (false !== strpos($filename, 'sfWidgetForm'))
    {
      return 'sfWidgetForm';
    }
  }
}