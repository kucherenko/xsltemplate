<?php
/**
 * Test for Renderer class
 * @author Andrey Kucherenko <andrey@kucherenko.org>
 * @date   13.12.11
 */
namespace XSLTemplate\Tests;
/**
 * Test case for Renderer Class
 *
 */
class RendererTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \XSLTemplate\Renderer
     */
    private $_sut;

    public function setUp()
    {
        $this->_sut = new \XSLTemplate\Renderer();
        ini_set("zend.ze1_compatibility_mode", "off");
    }

    /**
     * Test for get parameters
     */
    public function testGetParameters()
    {
        $this->assertAttributeEquals($this->_sut->getParameters(), '_parameters', $this->_sut);
    }

    /**
     * Test to add parameters
     */
    public function testAddParameter()
    {
        $parametersToAdd = array('test'=>'test');
        $parameters = $this->_sut->getParameters();
        $this->_sut->addParameters($parametersToAdd);
        $this->assertEquals($this->_sut->getParameters(), array_merge($parameters, $parametersToAdd));
    }

    /**
     * Test for exceptions from render without render.types parameters
     * @expectedException        \DomainException
     * @expectedExceptionMessage render.types is not defined in renderer parameters
     */
    public function testExceptionFromRenderWithoutTypes()
    {
        $this->_sut->setParameters(array());
        $this->_sut->render('test', new \XSLTemplate\XML\Writer());
    }

 }
