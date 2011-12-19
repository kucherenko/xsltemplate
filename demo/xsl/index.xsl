<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:output encoding="UTF-8" method="html" omit-xml-declaration="yes" indent="no"
                doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"/>

    <xsl:include href="layout.xsl"/>

    <xsl:variable name="docs" select="document('../../docs/index.xhtml')/html/body/div[@id='content']" />

    <xsl:template match="/">
        <xsl:apply-templates select="page">
            <xsl:with-param name="title">Demo page for XSLTemplate</xsl:with-param>
        </xsl:apply-templates>

    </xsl:template>

    <xsl:template match="content">
        <xsl:copy-of select="$docs/*|$docs/text()"/>
        <h3>PHP extensions list</h3>
        <xsl:apply-templates select="extensions"/>
    </xsl:template>

    <xsl:template match="extensions/row">
        <div>
            <xsl:if test="position() mod 2 = 0">
                <xsl:attribute name="class">gray</xsl:attribute>
            </xsl:if>
            <xsl:value-of select="text()"/>
        </div>
    </xsl:template>

</xsl:stylesheet>