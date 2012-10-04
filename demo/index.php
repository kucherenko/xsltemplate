<?php
/**
 *
 * @author Andrey Kucherenko <andrey@kucherenko.org>
 * @date   16.12.11
 *
 */
require_once '../vendor/autoload.php';

//start timer
$startTime = microtime(true);

//make XMLWriter object
$xmlWriter = new \XSLTemplate\XML\Writer();
$xmlWriter->init();


//start main document node
$xmlWriter->startElement('page');
//start content node
$xmlWriter->startElement('content');

$xmlWriter->startElement('docs');
$xmlWriter->includeXML('docs.xml');
$xmlWriter->endElement();
$xmlWriter->endElement();
$xmlWriter->endElement();

$renderer = new \XSLTemplate\Renderer();
$renderer->addParameters(array('templates.url'  => 'xsl/', 'templates.path' => __DIR__ . '/xsl/',));

if (isset($_GET['xml']) && $_GET['xml']==1){
    $renderer->addParameters(array('only.xml'=>true));
}

$result = $renderer->render('index.xsl', $xmlWriter);

// echo execute time
$result .= '<!--';
$result .= 'Execute time: ';
$result .= (microtime(true) - $startTime);
$result .= ', renderer: ' . $renderer->getCurrentRenderer();
$result .= '-->';

header("Content-type: " . $renderer->getContentType());
echo $result;