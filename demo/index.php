<?php
/**
 *
 * @author Andrey Kucherenko <andrey@kucherenko.org>
 * @date   16.12.11
 *
 */
require_once '../vendor/autoload.php';

$startTime = microtime(true);
$times = array();

$xmlWriter = new \XSLTemplate\XML\Writer();
$xmlWriter->init();
$times['init.writer'] = (microtime(true) - $startTime);

//start main document node
$xmlWriter->startElement('page');
//start content node
$xmlWriter->startElement('content');
//added extensions to content
$xmlWriter->assign('extensions', get_loaded_extensions());

$browser = get_browser($_SERVER['HTTP_USER_AGENT'], true);
$xmlWriter->assign('browser', array('name' => $browser['browser'], 'version' => $browser['version']));
$times['generate.xml'] = (microtime(true) - $startTime);

$renderer = new \XSLTemplate\Renderer();
$renderer->addParameters(
    array(
        'templates.url' => 'xsl/',
        'templates.path' => __DIR__ . '/xsl/',
        'only.xml' => $_GET['xml'] == 1
    )
);

$times['init.renderer'] = (microtime(true) - $startTime);

$result = $renderer->render('index.xsl', $xmlWriter);

$times['render'] = (microtime(true) - $startTime);

$result .= '<!-- ';
$result .= var_export($times, true);
$result .= '-->';

header ( "Content-type: " . $renderer->getContentType() );
echo $result;