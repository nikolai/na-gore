<?php
$xml = 'archieve.xml';
$xsl = 'test.xsl';
$schema = 'schema.xsd';

//Make sure the XML is well formed.
$dom = new DOMDocument;

if (!$dom->load($xml)) {
    $error = libxml_get_last_error();
    die('Sorry, but the XML file "' . $xml . '" is not well formed. The error occured on line ' . $error->line . ' and the exact message was "' . $error->message . '". Please correct the error and try again.');
}

$root = $dom->getElementsByTagName("title");
$dom->createAttribute("ddd");

echo 'ttt:'.$dom->name;



/* $dom now contains a DOMDocument object that's fine.
Do whatever you were going to do with it from this line on.
The line below is given for example only. */
echo '<pre>', htmlspecialchars($dom->saveXML()), '</pre>';
?>
