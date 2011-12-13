<?php

namespace XSLTemplate\Renderer;


class Browser implements RendererInterface
{

    /**
     * Execute render process, return xml string with instructions for xsl transformation in client browser
     * @param string $templatePath
     * @param \DOMDocument $source
     * @param array $parameters
     * @return string
     */
    public function execute($templatePath, \DOMDocument $source, array $parameters = array())
    {
        $outputXml = $source->saveXML();
        $outputXml = str_replace('?>', '?><?xml-stylesheet type="text/xsl" href="' . $templatePath . '"?>', $outputXml);
        return $outputXml;
    }
}
