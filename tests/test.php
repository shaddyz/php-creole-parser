<!DOCTYPE html>
<?php

include '../vendor/autoload.php';

$parser = new \Creole\Parser();
$wikitext = $parser->parse('creole1.0test.txt');

?>
<html>
    <head>
        <title>Creole Parser Test</title>
    </head>
    <body>
        <?php print $wikitext->toHtml() ?>
    </body>
</html>
