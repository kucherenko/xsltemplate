<?php
/**
 * File contain interface for renderer objects
 *
 * @author Andrey Kucherenko <andrey@kucherenko.org>
 */
namespace XSLTemplate\Renderer;

/**
 * RendererInterface declaration
 */
interface RendererInterface
{
    /**
     * Execute render process
     * @abstract
     * @param string $templatePath
     * @param \DOMDocument $source
     * @param array $parameters
     * @return string
     */
    public function execute($templatePath, \DOMDocument $source, array $parameters = array());
}
