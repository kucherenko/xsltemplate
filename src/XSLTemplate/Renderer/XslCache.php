<?php

namespace XSLTemplate\Renderer;

class XslCache implements RendererInterface
{
    /**
     * Execute xsl transformation process with xslcache (http://code.nytimes.com/projects/xslcache) library.
     * @param string $templatePath
     * @param \DOMDocument $source
     * @param array $parameters
     * @return string
     */
    public function execute($templatePath, \DOMDocument $source, array $parameters = array())
    {
        if (!extension_loaded('xslcache')) {
            throw new \RuntimeException('xslcache extension is not found, see http://code.nytimes.com/projects/xslcache');
        }
        $xslt = new \xsltCache();
        $xslt->importStyleSheet($templatePath);
        $outputDom = $xslt->transformToDoc($source);

        if ($parameters['output.xml']) {
            return $outputDom->saveXML();
        }
        return $outputDom->saveHTML();
    }
}
