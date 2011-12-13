<?php
/**
 *
 * @author Andrey Kucherenko <andrey@kucherenko.org>
 * @date   02.12.11
 *
 */
namespace XSLTemplate;

/**
 * Declaration of Renderer class, this class is facade for renderer classes.
 * Main target of this class is get and analyze input parameters and start renderer process.
 *
 * @example
 * <code>
 *
 * $xmlWriter = new \XSLTemplate\XML\Writer();
 *
 * $xmlWriter->init();
 * $xmlWriter->assign(array('page'=>'main'));
 *
 * $renderer = new Renderer();
 * $renderer->render('path/to/template.xsl',$xmlWriter, array())
 *
 * </code>
 */
class Renderer {

    /**
     * Static method, wrapper for render() method
     * @static
     * @param $template
     * @param XML\Writer $xmlWriter
     * @param array $parameters
     */
    public static function run($template, \XSLTemplate\XML\Writer $xmlWriter, array $parameters = array()) {
        $renderer = new Renderer();
        return $renderer->render($template, $xmlWriter, $parameters);
    }

    public function render($template, \XSLTemplate\XML\Writer $xmlWriter, array $parameters = array())
    {

    }
}
