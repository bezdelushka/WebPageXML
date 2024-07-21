<?php

$xml = new DOMDocument;
$xml->load('data.xml');


$xsl = new DOMDocument;
$xsl->load('style.xsl');


$proc = new XSLTProcessor;
$proc->importStyleSheet($xsl); 

echo $proc->transformToXML($xml);
?>
