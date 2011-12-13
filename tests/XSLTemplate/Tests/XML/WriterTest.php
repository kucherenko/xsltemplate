<?php

/**
 * Test for XML Writer class
 * @author Andrey Kucherenko <andrey@kucherenko.org>
 * @date 30.11.11
 */
namespace XSLTemplate\Tests\XML;

class WriterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test for initialisation xml writer
     */
    public function testInit()
    {
        /**
         * @var XSLTemplate\XML\Writer
         */
        $writer = $this->getMock('XSLTemplate\XML\Writer', array('openMemory', 'startDocument'));
        $writer->expects($this->once())
            ->method('openMemory');

        $writer->expects($this->once())
            ->method('startDocument')
            ->with($this->equalTo('1.0'), $this->equalTo('utf-8'));

        $writer->init();
    }

    /**
     * Test for includeXml method
     */
    public function testIncludeXml()
    {
        $writer = $this->getMock('XSLTemplate\XML\Writer', array('startElementNs', 'writeElement', 'writeAttribute', 'endElement'));
        $this->assertFalse($writer->hasIncludedXml());
        $writer->includeXml('test');
        $this->assertTrue($writer->hasIncludedXml());
    }


}
