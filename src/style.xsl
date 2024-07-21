<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:xlink="http://www.w3.org/1999/xlink">
    <xsl:template match="/">
        <html>
            <body>
                <h2>User List</h2>
                <table border="1">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Pass Hash</th>
                        <th>Images</th>
                    </tr>
                    <xsl:for-each select="users/user">
                        <tr>
                            <td><xsl:value-of select="id"/></td>
                            <td><xsl:value-of select="name"/></td>
                            <td>
                                <a href="{email/@xlink:href}">
                                    <xsl:value-of select="email"/>
                                </a>
                            </td>
                            <td><xsl:value-of select="pass_hash"/></td>
                            <td>
                                <xsl:for-each select="images/image">
                                    <p>Filename: <xsl:value-of select="filename"/></p>
                                    <img>
                                        <xsl:attribute name="src">
                                            <xsl:text>data:image/jpeg;base64,</xsl:text>
                                            <xsl:value-of select="data"/>
                                        </xsl:attribute>
                                    </img>
                                </xsl:for-each>
                            </td>
                        </tr>
                    </xsl:for-each>
                </table>
                <h2>Fractal MathML Formula</h2>
                <div>
                    <xsl:copy-of select="users/math/math"/>
                </div>
                <h2>Sierpinski Triangle SVG</h2>
                <div>
                    <xsl:copy-of select="users/svg/svg"/>
                </div>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
