<?php
/**
 *
 * @author Andrey Kucherenko <andrey@kucherenko.org>
 * @date   02.12.11
 *
 */
namespace XSLTemplate;

/**
 *
 */ class Renderer {

    public function run($template, XSLTemplate\XML\Writer $xml) {



//        $settings = CompleXml_Config::readComponentSettings(__CLASS__);
//        $ControllerObject->View->setLocalePath($settings['locales']);
//        $file = $settings['templates'] . DIRECTORY_SEPARATOR . $ControllerObject->View->getTemplate() . '.xsl';
//        if (!file_exists($file)) {
//            throw new CompleXml_Output_Exception('Templates file ' . $file . ' not found');
//        }
//        $ControllerObject->View->setLocalePath($settings['locales']);
//        $xmlString = $ControllerObject->View->getXml();
//
//        $xml = new DomDocument ();
//        $xml->loadXML($xmlString);
//        @$xml->xinclude();
//
//        if (extension_loaded('xslcache')) {
//            $xslt = new xsltCache;
//            $xslt->importStyleSheet($file);
//            $newDom = $xslt->transformToDoc($xml);
//        } else {
//            $xsl = new DomDocument ();
//            $xsl->load($file);
//
//            $proc = new XsltProcessor ();
//            $xsl  = $proc->importStylesheet($xsl);
//
//            $newDom = $proc->transformToDoc($xml);
//        }
//        $str = $newDom->saveHTML();
//        $ControllerObject->Response->nocache();
//        echo $str;
//        return true;
    }
}
