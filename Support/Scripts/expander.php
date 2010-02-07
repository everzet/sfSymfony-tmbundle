<?php

require_once dirname(__FILE__) . '/../Lib/sfBundle.class.php';

/**
 * Returns snippet for Class of the current file
 *
 * @param string $filename returns file name
 * @param string $filepath returns file path
 * @return string snippet
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
function getSnippet()
{  
  $baseClass = sfBundle::getCurrentFileType();
  $packageName = getPackageName($baseClass);

  $snippet = sprintf(<<<SNIPPET
/*
 * This file is part of the \$1.
 * (c) \${2:%s} \${3:\${TM_ORGANIZATION_NAME}}
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * \${4:%s} \${5:does things}.
 *
 * @package    \${6:\$1}
 * @subpackage \${7:%s}
 * @author     \$3
 * @version    \${8:1.0.0}
 */
class \$4%s
{
  \$0
}
SNIPPET
    ,date('Y', time())
    ,getClassName(TextMate::getEnv('filename'), TextMate::getEnv('filepath'))
    ,$packageName ? $packageName : 'custom'
    ,$baseClass ? sprintf(" extends \${9:%s}", $baseClass) : ''
  );

  return $snippet;
}

/**
 * Returns class name by filename & filepath
 *
 * @param string $filename file name
 * @param string $filepath file path
 * @return string class name
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
function getClassName($filename, $filepath)
{
  switch ($filename)
  {
    case 'components.class.php';
      return basename(dirname(dirname($filepath))) . 'Components';
      break;
    case 'actions.class.php':
      return basename(dirname(dirname($filepath))) . 'Actions';
      break;
    default:
      return str_replace('.class.php', '', $filename);
  }
}

/**
 * Returns package name by base class
 *
 * @param string $baseClass base class
 * @return string package name
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
function getPackageName($baseClass)
{
  switch ($baseClass)
  {
    case 'sfAction':
    case 'sfActions':
      return 'actions';
      break;
    case 'sfComponent':
    case 'sfComponents':
      return 'components';
      break;
    case 'sfForm':
    case 'sfFormFilter':
    case 'sfFormDoctrine':
    case 'sfFormPropel':
      return 'forms';
      break;
    case 'sfFilter':
      return 'filters';
      break;
    case 'sfProjectConfiguration':
    case 'sfPluginConfiguration':
    case 'sfApplicationConfiguration':
      return 'configurations';
      break;
    case 'sfWidgetForm':
      return 'widgets';
      break;
    default:
      return '';
      break;
  }
}
