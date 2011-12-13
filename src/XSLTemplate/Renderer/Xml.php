<?php

namespace XSLTemplate\Renderer;

class Xml implements RendererInterface
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
        return $source->saveXML();
    }
}
