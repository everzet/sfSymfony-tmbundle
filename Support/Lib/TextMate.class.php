<?php

/*
 * This file is part of the sfSymfony-tmbundle.
 * (c) 2010 Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * TextMate implements wrapper to TM actions.
 *
 * @package    sfSymfony-tmbundle
 * @subpackage bundle
 * @author     Konstantin Kudryashov <ever.zet@gmail.com>
 * @version    1.0.0
 */
class TextMate
{
  public static function exitDiscard()
  {
    die(200);
  }

  public static function exitReplaceText()
  {
    die(201);
  }

  public static function exitReplaceDocument()
  {
    die(202);
  }

  public static function exitInsertText()
  {
    die(203);
  }

  public static function exitInsertSnippet()
  {
    die(204);
  }

  public static function exitShowHtml()
  {
    die(205);
  }

  public static function exitShowTooltip()
  {
    die(206);
  }

  public static function exitCreateNewDocument()
  {
    die(207);
  }

  public static function openUrl($url)
  {
    exec(sprintf('open "%s"', $url));
  }

  public static function open($filename, $line = null, $column = null)
  {
    $options = array();
    $options[] = sprintf('url=file://%s', $filename);
    if ($line) $options[] = sprintf('line=%s', $line + 1);
    if ($column) $options[] = sprintf('column=%s', $column + 1);

    self::openUrl(sprintf('txmt://open?%s', implode('&', $options)));
  }

  public static function getEnv($var)
  {
    return getenv('TM_' . strtoupper($var));
  }

  public static function getSelectedText()
  {
    return self::getEnv('selected_text');
  }

  public static function getProjectDirectory()
  {
    return self::getEnv('project_directory');
  }

  public static function rescanProject()
  {
    exec("osascript &>/dev/null -e 'tell app \"SystemUIServer\" to activate'; osascript &>/dev/null -e 'tell app \"TextMate\" to activate' &");
  }

  public function __get($var)
  {
    return self::getEnv($var);
  }

  public static function getCocoaDialogCommand()
  {
    return sprintf(
      '%s/bin/CocoaDialog.app/Contents/MacOS/CocoaDialog', self::getEnv('support_path')
    );
  }

  public static function drawCocoaDialog($command, $options = array())
  {
    $optionsList = array();
    foreach ($options as $key => $value)
    {
      $optionsList[] = sprintf('--%s "%s"', $key, $value);
    }

    $dialogCommand = sprintf('%s %s %s'
      ,self::getCocoaDialogCommand()
      ,$command
      ,implode(' ', $optionsList)
    );
    $output = array();

    exec($dialogCommand, $output);

    return $output;
  }

  public static function getCocoaDialogData($command, $options = array())
  {
    $output = self::drawCocoaDialog($command, $options);

    if (2 == $output[0])
    {
      return false;
    }
    else
    {
      return $output[1];
    }
  }
}