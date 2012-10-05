
XSLTemplate documentation
=========================

About
-----

XSLTemplate is a PHP 5.3 library for processing xsl templates in web projects.


Supported engines
-----------------

XSLTemplate support follow render engines:
 - LibXslt (http://xmlsoft.org/XSLT/), embedded in php5 extension;
 - Browsers embedded xslt engines, supported browsers (more info http://www.w3schools.com/xsl/xsl_browsers.asp):
    + Firefox (http://www.mozilla.org/projects/xslt/);
    + Chromium version >= 10.0 (used embedded LibXslt http://xmlsoft.org/XSLT/);
    + Chrome version >= 1.0 (used embedded LibXslt http://xmlsoft.org/XSLT/);
    + Opera version >= 9.0 (http://www.opera.com/);
    + IE version >= 7.0;
    + Safari version >= 7.0;
 - XslCache (http://code.nytimes.com/projects/xslcache), extension is a modification of PHP's standard XSL extension;

Installation
------------

1. Install libxslt for php:
   ::
       
     apt-get install php5-xsl
2. Set up `browscap <http://php.net/manual/en/misc.configuration.php#ini.browscap>`_
   option to php.ini, browscap.ini is not bundled with PHP, but you may find an up-to-date `php_browscap.ini <http://browsers.garykeith.com/downloads.asp>`_ file here;
3. Install xslcache [optional] (http://code.nytimes.com/projects/xslcache/wiki).
4. Install Git
5. Git source:
   ::

     git clone git://github.com/kucherenko/xsltemplate.git

Getting started
---------------

This section gives you a documentation to the PHP API for XSLTemplate.

Register autoloader:
::

    <?php
    if (false === class_exists('Symfony\Component\ClassLoader\UniversalClassLoader', false)){
        require_once '/path/to/Symfony/Component/ClassLoader/UniversalClassLoader.php';
    }

    use Symfony\Component\ClassLoader\UniversalClassLoader;

    $loader = new UniversalClassLoader();
    $loader->registerNamespaces(array(
        'XSLTemplate'   => '/path/to/xsltemplate/src',
    ));
    $loader->register();

Basic usage:
::
        
    //Create and initialize xml writer
    $xmlWriter = new \XSLTemplate\XML\Writer();
    $xmlWriter->init();

    // accumulate data to xml
    $xmlWriter->startElement('page');
    $xmlWriter->endElement();

    //create renderer object
    $renderer = new \XSLTemplate\Renderer();

    echo $renderer->render('index.xsl', $xmlWriter);

Parameters
----------

The following sections describe the configuration parameters available on a Renderer instance.

For work with parameters use follow code:
::

    //create renderer object
    $renderer = new \XSLTemplate\Renderer();

    //Add parameters to renderer, merge with default parameters
    $renderer->addParameters(array(
        'parameter.name' => 'parameter value',
    ));

    // Set new parameters to renderer, remove default parameters
    $renderer->setParameters(array(
        'parameter.name' => 'parameter value',
    ));

    //return default parameters
    $parameters = $renderer->getParameters();

    // last method parameter is a array of parameters for current render process
    $renderer->render('template_name.xsl', $xmlWriter, $parameters);

    //Return parameters of last render process
    $currentParameters = $renderer->getCurrentRenderer();


Parameters list:
________________

render.types
^^^^^^^^^^^^
Types of render you can use following values for this
(required parameter):
::

    // supports render in browser
    Renderer::RENDER_BROWSER
    // render with libxslt on server
    Renderer::RENDER_LIB_XSLT
    // render with xslcache extension
    Renderer::RENDER_XSL_CACHE
    // don't use xslt transformation, output only xml
    Renderer::RENDER_XML

Default value:
::

  array(
     Renderer::RENDER_BROWSER,
     Renderer::RENDER_LIB_XSLT,
     Renderer::RENDER_XML
  )

templates.path 
^^^^^^^^^^^^^^
Path on server to xsl templates.
Required if use ``Renderer::RENDER_LIB_XSLT`` or ``Renderer::RENDER_XSL_CACHE`` 
renderer.

Default value: not defined

templates.url 
^^^^^^^^^^^^^
HTTP url to xsl templates, must be at same domain with php code.
Required if use Renderer::RENDER_BROWSER renderer.

Default value: /

render.browsers
^^^^^^^^^^^^^^^

List of browser with xslt support (Required if use Renderer::RENDER_BROWSER renderer).

Default value:
::

    array(
        //name => version
        'Opera'    => 9.0,
        'Firefox'  => 3.0,
        'Safari'   => 3.0,
        'Chrome'   => 1.0,
        'IE'       => 7.0,
        'Safari'   => 3.0,
        'Chromium' => 10.0,
    )

only.xml
^^^^^^^^
If this parameter is true, renderer will use only RENDER_XML (Not required parameter).

Default value: false

output.type
^^^^^^^^^^^
Output type, using at ``Renderer::RENDER_LIB_XSLT`` and ``Renderer::RENDER_XSL_CACHE``, can use 'html' and 'xml' types,
if output.type == 'xml' transformation result will output with ``DOMDocument::saveXML()``,
otherwise will output with ``DOMDocument::saveHTML()``. (Not required)

Default value: html


