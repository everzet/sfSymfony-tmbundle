<?php

require_once dirname(__FILE__) . '/../Lib/sfBundle.class.php';

// Getting partial name from inputbox
$partialName = TextMate::getCocoaDialogData('inputbox', array(
  'title' => 'Move HTML into partial',
  'informative-text' => 'Enter partial name (without \'_\' and \'.php\'):',
  'button1' => "Ok",
  'button2' => "Cancel"
));
if (!$partialName)
{
  TextMate::exitDiscard();
}

// Partial name is global or relative?
if (count($nameParts = explode('/', $partialName)) > 1)
{
  $path = sprintf('%s/%s/templates',
    dirname(dirname(dirname(TextMate::getEnv('filepath')))), $nameParts[0]
  );
  $renderedPartialName = $nameParts[1];
}
else
{
  $path = dirname(TextMate::getEnv('filepath'));
  $renderedPartialName = $partialName;
}

// Getting partial path by it's name & checking if it exists
$partialPath = sprintf('%s/_%s.php', $path, $renderedPartialName);
if (file_exists($partialPath))
{
  TextMate::drawCocoaDialog('msgbox', array(
    'title' => 'Partial already exists',
    'text' => 'Partial already exists',
    'informative-text' => $partialPath,
    'button1' => "Ok"
  ));
  TextMate::exitDiscard();
}

// Path exists ? If not - create one
if (!is_dir($path))
{
  mkdir($path, 0755, true);
}

// Getting content of partial & splitting spaces from start
$content = file_get_contents('php://stdin');
if ($splittableSpacesCount = sfBundle::getSplittableSpacesCount($content))
{
  $content = sfBundle::splitSpacesAtStart($content, $splittableSpacesCount);
}

// Echoing snippet
echo sprintf("%s<?php include_partial('%s'\${1:, array(\$0)}) ?>"
  ,str_repeat(' ', $splittableSpacesCount)
  ,$partialName
);

// Writing partial
file_put_contents($partialPath, $content);

// Rescaning project folder & opening partial in TM
TextMate::rescanProject();
TextMate::open($partialPath);
