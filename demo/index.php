<?php
/**
 *
 * @author Andrey Kucherenko <andrey@kucherenko.org>
 * @date   16.12.11
 *
 */
require_once '../autoload.php';

$startTime = microtime(true);

$xmlWriter = new \XSLTemplate\XML\Writer();
$xmlWriter->init();

//start main document node
$xmlWriter->startElement('page');
//start content node
$xmlWriter->startElement('content');
//added extensions to content
$xmlWriter->assign('extensions', get_loaded_extensions());
print '<pre>';
var_dump(get_browser($_SERVER['HTTP_USER_AGENT'], true));
//$xmlWriter->assign('browser', get_browser($_SERVER['HTTP_USER_AGENT'], true));

$xmlWriter->endElement();
$xmlWriter->endElement();

$renderer = new \XSLTemplate\Renderer();
$renderer->addParameters(
    array(
        'templates.url' => 'xsl/',
        'templates.path' => __DIR__ . '/xsl/',
    )
);
$result = $renderer->render('index.xsl', $xmlWriter);

$result .= '<!--';
$result .= (microtime(true) - $startTime);
$result .= '-->';

header ( "Content-type: " . $renderer->getContentType() );
echo $result;