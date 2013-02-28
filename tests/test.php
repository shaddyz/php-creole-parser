<?php

include '../vendor/autoload.php';

if (isset($argv[1])) {
    $testFile = strtolower($argv[1]) . '.txt';
} else {
    $textFile = 'creole1.0test.txt';
}

$wikiString = file_get_contents($testFile);
$wikiText = new \Creole\Page($wikiString);
$htmlHead = '<!DOCTYPE html>
<html>
    <head>
        <title>Creole Parser Test</title>
    </head>
    <body>
';
$htmlTail = '    </body>
</html>';

$outFile = fopen('test.html', 'wb');
fwrite($outFile, $htmlHead);
fwrite($outFile, $wikiText->toHtml());
fwrite($outFile, $htmlTail);
fclose($outFile);

print 'generated test.html' . "\n";
