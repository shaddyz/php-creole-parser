<?php

include '../vendor/autoload.php';

$wikiString = file_get_contents('creole1.0test.txt');
$wikiText = new \Creole\Page($wikiString);
$htmlHead = '<!DOCTYPE html>
<html>
    <head>
        <title>Creole Parser Test</title>
    </head>
    <body>';
$htmlTail = '</body>
</html>';

$outFile = fopen('test.html', 'wb');
fwrite($outFile, $htmlHead);
fwrite($outFile, $wikiText->toHtml());
fwrite($outFile, $htmlTail);
fclose($outFile);

print 'generated test.html' . "\n";
