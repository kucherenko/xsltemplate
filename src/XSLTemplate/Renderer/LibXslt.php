<?php

namespace XSLTemplate\Renderer;

class LibXslt implements RendererInterface
{

    /**
     * Execute render process
     * @param string $templatePath
     * @param \DOMDocument $source
     * @param array $parameters
     * @return string
     */
    public function execute($templatePath, \DOMDocument $source, array $parameters = array())
    {
        $xsl = new \DomDocument();
        $xsl->load($templatePath);

        $processor = new \XsltProcessor ();
        $processor->importStylesheet($xsl);
        $outputDom = $processor->transformToDoc($source);

        if ($parameters['output.type'] && $parameters['output.type'] == 'xml') {
            $result = $outputDom->saveXML();
        } else {
            $result = $outputDom->saveHTML();
        }
        return $result;
    }
}
