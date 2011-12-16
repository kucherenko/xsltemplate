<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:include href="layout.xsl"/>

    <xsl:template match="/">
        <xsl:apply-templates select="page">
            <xsl:with-param name="title">Demo page for XSLTemplate</xsl:with-param>
        </xsl:apply-templates>

    </xsl:template>

    <xsl:template match="content">
        <h1>Demo XSLTemplate</h1>
        <p>
            Browser:
            <xsl:value-of select="browser/name"/><xsl:text> </xsl:text><xsl:value-of select="browser/version"/>
            Version:
            <xsl:value-of select="system-property('xsl:version')"/>
            <br/>
            Vendor:
            <xsl:value-of select="system-property('xsl:vendor')"/>
            <br/>
            Vendor URL:
            <xsl:value-of select="system-property('xsl:vendor-url')"/>
        </p>
        <h3>PHP extensions list</h3>
        <xsl:apply-templates select="extensions"/>
    </xsl:template>

    <xsl:template match="extensions/row">
        <div>
            <xsl:if test="position() mod 2 = 0">
                <xsl:attribute name="style">background-color:#cfcfcf;</xsl:attribute>
            </xsl:if>
            <xsl:value-of select="text()"/>
        </div>
    </xsl:template>

</xsl:stylesheet>