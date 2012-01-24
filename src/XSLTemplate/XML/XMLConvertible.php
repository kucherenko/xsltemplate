<?php
/**
 * File containce interface for objects with toXML realisation.
 *
 * @author Andrey Kucherenko <andrey@kucherenko.org>
 */
 namespace XSLTemplate\XML;

/**
 *
 */
interface XMLConvertible {
    public function toXML(Writer $writer);
}
