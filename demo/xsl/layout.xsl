<!DOCTYPE xsl:stylesheet [
        <!ENTITY copy "&#169;">
        <!ENTITY nbsp "&#160;">
        <!ENTITY laquo "&#171;">
        <!ENTITY raquo "&#187;">
        ]>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:output
            encoding="UTF-8"
            method="html"
            omit-xml-declaration="yes"
            indent="no"
            doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN"
            doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"/>

    <xsl:template match="page">
        <xsl:param name="title"/>
        <html>
            <head>
                <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
                <title>
                    <xsl:value-of select="$title"/>
                </title>
                <link rel="stylesheet" href="css/main.css" type="text/css"/>
            </head>
            <body>
                <html xmlns="http://www.w3.org/1999/xhtml">
                    <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                        <title>
                            <xsl:value-of select="$title"/>
                        </title>
                    </head>
                    <body>
                        <div id="head">
                            <h1>XSLTemplate demos</h1>
                        </div>
                        <div id="menu">
                            <div>
                                <a href="index.php">Home</a>
                            </div>
                            <div>
                                <a href="demo1.php">Demo 1</a>
                            </div>
                            <div>
                                <a href="demo2.php">Demo 2</a>
                            </div>
                            <div class="line"></div>
                            <div>
                                <h4>XSL Info:</h4>
                                <p>
                                    Version:
                                    <xsl:value-of select="system-property('xsl:version')"/>
                                    <br/>
                                    Vendor:
                                    <xsl:value-of select="system-property('xsl:vendor')"/>
                                    <br/>
                                    Vendor URL:
                                    <xsl:value-of select="system-property('xsl:vendor-url')"/>
                                </p>
                                <xsl:if test="content/browser">
                                <h4>Browser Info:</h4>
                                <p>
                                    Name:
                                    <xsl:value-of select="content/browser/name"/>
                                    <br/>
                                    Version:
                                    <xsl:value-of select="content/browser/version"/>
                                    <br/>
                                </p>
                                </xsl:if>
                            </div>
                        </div>
                        <div id="content">
                            <h2><xsl:value-of select="$title"/></h2>
                            <xsl:apply-templates select="content"/>
                        </div>
                        <div id="foot">
                            Copyright &copy; XSLTemplate
                        </div>
                    </body>
                </html>
            </body>
        </html>
    </xsl:template>

</xsl:stylesheet>