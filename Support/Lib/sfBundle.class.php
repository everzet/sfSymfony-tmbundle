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
}