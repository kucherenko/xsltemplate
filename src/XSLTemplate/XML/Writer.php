<?php
/**
 * File contains class for generate xml fro XSLTemplate
 *
 * @author Andrey Kucherenko <andrey@kucherenko.org>
 * @date 30.11.11
 */
namespace XSLTemplate\XML;

/**
 * Class for collect data in xml format
 */
class Writer extends \XMLWriter
{

    /**
     * Flag for
     * @var bool
     */
    private $_hasIncludedXml = false;

    /**
     * Default attribute name
     * @var string
     */
    private $_defaultAttributeName = 'attr';

    /**
     * Default xml node name
     *
     * @var string
     */
    private $_defaultNodeName = 'row';

    /**
     * Method for initialisation of XML writer, open memory for write xml and start document with $version and $encoding.
     *
     * @param string $version
     * @param string $encoding
     */
    public function init($version = '1.0', $encoding = 'utf-8')
    {
        $this->openMemory();
        $this->startDocument($version, $encoding);
    }

    /**
     * Generate xi:include instruction
     *
     * @param string $path
     */
    public function includeXML($path)
    {
        $this->startElementNs('xi', 'include', 'http://www.w3.org/2001/XInclude');
        $this->writeAttribute('href', $path);
        $this->writeAttribute('parse', 'xml');
        $this->startElementNs('xi', 'fallback', 'http://www.w3.org/2001/XInclude');
        $this->writeElement('error', 'Error include ' . $path);
        $this->endElement();
        $this->endElement();

        $this->_hasIncludedXml = true;
    }

    /**
     * Method for write any string to xml as valid xml.
     *
     * @param string $xmlString
     */
    public function writeRawXml($xmlString)
    {
        $xmlString = '<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>' . $xmlString . '</body></html>';
        $xhtml = new \DOMDocument('1.0', 'utf-8');
        @$xhtml->loadHTML($xmlString);
        $string = $xhtml->saveXML();
        $pattern = '%<body>(.*?)<\/body>%is';
        preg_match($pattern, $string, $matches, PREG_OFFSET_CAPTURE);
        $result = $matches[1][0];
        $result = str_replace('&#13;', '', $result);

        $this->writeRaw($result);
    }

    /**
     * Assign $value with $name to xml
     *
     * @param string $name
     * @param mixed $value
     */
    public function assign($name, $value = null)
    {
        if ($value instanceof XMLConvertible){
            $this->startElement($name);
            $this->convertObjectToXML($value);
            $this->endElement();
        } elseif (is_array($value) || $value instanceof \Traversable) {
            $this->startElement($name);
            $this->arrayToXml($value);
            $this->endElement();
        } else {
            $this->writeElement($name, $value);
        }
    }

    /**
     * Convert any XMLConvertible $object to xml string.
     *
     * @param XMLConvertible $object
     */
    public function convertObjectToXML(XMLConvertible $object)
    {
        $object->toXML($this);
    }

    /**
     * Convert array to xml.
     *
     * @param array $array
     */
    public function arrayToXml($array)
    {
        if (!is_array($array) && !($array instanceof \Traversable)) {
            throw new \InvalidArgumentException('Parameter is not array');
        }

        foreach ($array as $key => $value) {
            if ($value instanceof XMLConvertible) {
                $this->convertObjectToXML($value);
                continue;
            }
            if (is_numeric($key[0])) {
                $nodeName = $this->getDefaultNodeName();
            } else {
                $nodeName = $key;
            }
            $this->startElement($nodeName);
            try {
                $this->arrayToXml($value);
            } catch (\InvalidArgumentException $e) {
                $this->text($value);
            }
            $this->endElement();
        }
    }

    /**
     * return true if already included some xml via xi:include
     * @return bool
     */
    public function hasIncludedXml()
    {
        return $this->_hasIncludedXml;
    }

    /**
     * Set default attribute name
     *
     * @param string $defaultAttributeName
     */
    public function setDefaultAttributeName($defaultAttributeName)
    {
        $this->_defaultAttributeName = $defaultAttributeName;
    }

    /**
     * Get default attribute name
     *
     * @return string
     */
    public function getDefaultAttributeName()
    {
        return $this->_defaultAttributeName;
    }

    /**
     * Set default node name
     *
     * @param string $defaultNodeName
     */
    public function setDefaultNodeName($defaultNodeName)
    {
        $this->_defaultNodeName = $defaultNodeName;
    }

    /**
     * Get default node name
     *
     * @return string
     */
    public function getDefaultNodeName()
    {
        return $this->_defaultNodeName;
    }

    /**
     * Return DomDocument object for current xml
     *
     * @return \DOMDocument
     */
    public function getDom()
    {
        $xmlString = $this->outputMemory();
        $dom = new \DOMDocument();
        $dom->loadXML($xmlString);
        if ($this->hasIncludedXml()) {
            $dom->xinclude();
        }
        return $dom;
    }
}
