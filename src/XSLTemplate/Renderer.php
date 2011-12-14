<?php
/**
 *
 * @author Andrey Kucherenko <andrey@kucherenko.org>
 * @date   02.12.11
 *
 */
namespace XSLTemplate;

use XSLTemplate\Renderer;

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
     * Array of parameters for rendering
     * @var array
     */
    private $_parameters = array(
        'render.types' => array('Browser', 'XslCache', 'LibXml', 'Xml'),
        'render.browsers' => array(
            'Opera'    => 9.0,
            'Firefox'  => 3.0,
            'Safari'   => 3.0,
            'Chrome'   => 1.0,
            'IE'       => 7.0,
            'Safari'   => 3.0,
            'Chromium' => 10.0,
        )
    );

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
        $currentParameters = array_merge($this->getParameters(), $parameters);

        if (empty($currentParameters['render.types'])) {
            throw new \DomainException('render.types is not defined for renderer');
        }


    }

    /**
     * Check is user client support for xslt
     *
     * @param string $userAgent
     * @param array  $supportedBrowsers
     * @return bool
     */
    public function isBrowserSupport($userAgent, array $supportedBrowsers)
    {
        $browserInfo = get_browser($userAgent);
        foreach ($supportedBrowsers as $name => $version) {
            if ($browserInfo->browser == $name && $browserInfo->version >= $version ){
                return true;
            }
        }
        return false;
    }

    /**
     * Set parameters
     * @param array $parameters
     */
    public function setParameters($parameters) {
        $this->_parameters = $parameters;
    }

    /**
     * Add parameters
     * @param array $parameters
     */
    public function addParameters($parameters) {
        $this->_parameters = array_merge($this->_parameters, $parameters);
    }

    /**
     * Return parameters of renderer
     * @return array
     */
    public function getParameters() {
        return $this->_parameters;
    }
}
