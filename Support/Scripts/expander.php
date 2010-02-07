<?php

function getSnippet($filename, $filepath)
{  
  $baseClass = getParentClass($filename);
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
    ,getClassName($filename, $filepath)
    ,$packageName ? $packageName : 'customs'
    ,$baseClass ? sprintf(" extends \${9:%s}", $baseClass) : ''
  );

  return $snippet;
}

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
  }
}

function getParentClass($filename)
{
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