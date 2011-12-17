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
     * Constant for browser render type.
     */
    const RENDER_BROWSER = 'Browser';
    /**
     * Constant for xslcache render type.
     */
    const RENDER_XSL_CACHE = 'XslCache';
    /**
     * Constant for libxslt render type.
     */
    const RENDER_LIB_XSLT = 'LibXslt';
    /**
     * Constant for xml render type.
     */
    const RENDER_XML = 'Xml';

    /**
     * Current renderer
     * @var string
     */
    private $_currentRenderer = false;

    /**
     * Array of parameters for current render process
     * @var array
     */
    private $_currentParameters = array();

    /**
     * Array of parameters for rendering
     *
     * @var array
     */
    private $_parameters = array(
        //type of renders
        'render.types'    => array(Renderer::RENDER_BROWSER, Renderer::RENDER_LIB_XSLT, Renderer::RENDER_XML),
        // supported browsers
        'render.browsers' => array(
            //name => version
            'Opera'    => 9.0,
            'Firefox'  => 3.0,
            'Safari'   => 3.0,
            'Chrome'   => 1.0,
            'IE'       => 7.0,
            'Safari'   => 3.0,
            'Chromium' => 10.0,
        ),
        // path to templates, using for render on browser side
        'templates.url'   => '/',
        //output type, using at libxslt and xslcahce renderers
        'output.type' => 'html'
    );

    /**
     * Static method, wrapper for render() method
     *
     * @static
     *
     * @param            $template
     * @param XML\Writer $xmlWriter
     * @param array      $parameters
     *
     * @return string
     */
    public static function run($template, \XSLTemplate\XML\Writer $xmlWriter, array $parameters = array()) {
        $renderer = new Renderer();
        return $renderer->render($template, $xmlWriter, $parameters);
    }

    /**
     * Generate string from $xmlWriter use $template for this.
     *
     * @param string     $template
     * @param XML\Writer $xmlWriter
     * @param array      $parameters
     *
     * @throws \DomainException
     * @throws \LogicException
     * @return string
     */
    public function render($template, \XSLTemplate\XML\Writer $xmlWriter, array $parameters = array()) {
        $this->_currentParameters = $currentParameters = array_merge($this->getParameters(), $parameters);

        if (empty($currentParameters['render.types'])) {
            throw new \DomainException('render.types is not defined in renderer parameters');
        }

        if (in_array(Renderer::RENDER_XML, $currentParameters['render.types']) && isset($currentParameters['only.xml']) && $currentParameters['only.xml'] == true) {
            return $this->renderXml($xmlWriter, $parameters);
        }

        $userAgent = isset($currentParameters['userAgent']) ? $currentParameters['userAgent'] : $_SERVER['HTTP_USER_AGENT'];
        if (in_array(Renderer::RENDER_BROWSER, $currentParameters['render.types']) && $this->isBrowserSupport($userAgent, $currentParameters['render.browsers'])) {
            if (!isset($currentParameters['templates.url'])) {
                throw new \DomainException('templates.url is not defined in renderer parameters, need for render on browser side');
            }
            return $this->renderBrowser($currentParameters['templates.url'] . $template, $xmlWriter, $currentParameters);
        }

        if (!isset($currentParameters['templates.path'])) {
            throw new \DomainException('templates.path is not defined in renderer parameters, need for render on server side with libxslt or xslcache');
        }

        if (in_array(Renderer::RENDER_XSL_CACHE, $currentParameters['render.types'])) {
            return $this->renderXslCache($currentParameters['templates.path'] . $template, $xmlWriter, $currentParameters);
        }

        if (in_array(Renderer::RENDER_LIB_XSLT, $currentParameters['render.types'])) {
            return $this->renderLibXslt($currentParameters['templates.path'] . $template, $xmlWriter, $currentParameters);
        }
        throw new \LogicException("Renderers for xsl transformation is not found");
    }

    /**
     * Render xsl+xml with xslcache extension
     * @param $template
     * @param XML\Writer $xmlWriter
     * @param array $parameters
     * @return string
     */
    public function renderXslCache($template, \XSLTemplate\XML\Writer $xmlWriter, array $parameters = array()) {
        $renderer = new \XSLTemplate\Renderer\XslCache();
        $result = $renderer->execute($template, $xmlWriter->getDom(), $parameters);
        $this->setCurrentRenderer(Renderer::RENDER_XSL_CACHE);
        return $result;
    }

    /**
     * Render xsl+xml with libxslt extension
     * @param $template
     * @param XML\Writer $xmlWriter
     * @param array $parameters
     * @return string
     */
    public function renderLibXslt($template, \XSLTemplate\XML\Writer $xmlWriter, array $parameters = array()) {
        $renderer = new \XSLTemplate\Renderer\LibXslt();
        $result = $renderer->execute($template, $xmlWriter->getDom(), $parameters);
        $this->setCurrentRenderer(Renderer::RENDER_LIB_XSLT);
        return $result;
    }

    /**
     * Output xml string
     * @param XML\Writer $xmlWriter
     * @param $parameters
     * @return string
     */
    public function renderXml(\XSLTemplate\XML\Writer $xmlWriter, array $parameters = array()) {
        $renderer = new \XSLTemplate\Renderer\Xml();
        $this->setCurrentRenderer(Renderer::RENDER_XML);
        return $renderer->execute(null, $xmlWriter->getDom(), $parameters);
    }
    /**
     * Return xml with instructions for render on browser side
     * @param $template
     * @param XML\Writer $xmlWriter
     * @param array $parameters
     * @return string
     */
    public function renderBrowser($template, \XSLTemplate\XML\Writer $xmlWriter, array $parameters = array()) {
        $renderer = new \XSLTemplate\Renderer\Browser();
        $this->setCurrentRenderer(Renderer::RENDER_BROWSER);
        return $renderer->execute($template, $xmlWriter->getDom(), $parameters);
    }

    /**
     * Check is user client support for xslt
     *
     * @param string $userAgent
     * @param array  $supportedBrowsers
     *
     * @return bool
     */
    public function isBrowserSupport($userAgent, array $supportedBrowsers) {
        $browserInfo = get_browser($userAgent);
        foreach ($supportedBrowsers as $name => $version) {
            if ($browserInfo->browser == $name && $browserInfo->version >= $version) {
                return true;
            }
        }
        return false;
    }

    /**
     * Set parameters
     *
     * @param array $parameters
     */
    public function setParameters($parameters) {
        $this->_parameters = $parameters;
    }

    /**
     * Add parameters
     *
     * @param array $parameters
     */
    public function addParameters($parameters) {
        $this->_parameters = array_merge($this->_parameters, $parameters);
    }

    /**
     * Return parameters of renderer
     *
     * @return array
     */
    public function getParameters() {
        return $this->_parameters;
    }

    /**
     * Set current renderer
     * @param string $currentRenderer
     */
    public function setCurrentRenderer($currentRenderer) {
        $this->_currentRenderer = $currentRenderer;
    }

    /**
     * Get information about current renderer
     * @return string
     */
    public function getCurrentRenderer() {
        return $this->_currentRenderer;
    }

    /**
     * Return content type for header function
     *
     * @return string
     */
    public function getContentType()
    {
        if ($this->getCurrentRenderer() == Renderer::RENDER_XML || $this->getCurrentRenderer() == Renderer::RENDER_BROWSER) {
            return 'application/xml';
        }
        return 'text/html';
    }

}
