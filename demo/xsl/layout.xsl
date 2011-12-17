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
                        <title><xsl:value-of select="$title"/></title>
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
                                <a href="2.html">Байки по автору</a>
                            </div>
                            <div>
                                <a href="3.html">Байки по теме</a>
                            </div>
                            <div class="line"></div>
                            <div>
                                <a href="4.html">Популярные разделы</a>
                            </div>
                            <div>
                                <a href="text.html">Последние байки</a>
                            </div>
                        </div>
                        <div id="content">

                        </div>
                        <div id="foot">
                            Copyright &amp;copy; XSLTemplate
                        </div>
                    </body>
                </html>
            </body>
        </html>
    </xsl:template>

</xsl:stylesheet>