<?php

require_once dirname(__FILE__) . '/../Lib/sfBundle.class.php';

// Getting partial name from inputbox
$partialName = TextMate::getCocoaDialogData('inputbox', array(
  'title' => 'Move HTML into partial',
  'informative-text' => 'Enter partial name (omit _ & .php):',
  'button1' => "Ok",
  'button2' => "Cancel"
));
if (!$partialName)
{
  TextMate::exitDiscard();
}

// Getting partial path by it's name & checking if it exists
$partialPath = sprintf('%s/_%s.php', dirname(TextMate::getEnv('filepath')), $partialName);
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

// Getting content of partial & splitting spaces from start
$content = file_get_contents('php://stdin');
if ($splittableSpacesCount = sfBundle::getSplittableSpacesCount($content))
{
  $content = sfBundle::splitSpacesAtStart($content, $splittableSpacesCount);
}

// Writing partial
file_put_contents($partialPath, $content);

// Echoing snippet
echo sprintf("%s<?php include_partial('%s'\${1:, array(\$2)}) ?>"
  ,str_repeat(' ', $splittableSpacesCount)
  ,$partialName
);

// Rescaning project folder & opening partial in TM
TextMate::rescanProject();
TextMate::open($partialPath);
