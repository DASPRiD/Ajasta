<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet
    version="1.0"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:fo="http://www.w3.org/1999/XSL/Format"
    xmlns:ajasta="https://github.com/DASPRiD/Ajasta"
>
    <xsl:output method="xml" indent="yes"/>
    <!-- This is a template following the German DIN standard 5008 for letters -->
    <xsl:template match="/ajasta:invoice">
        <fo:root>
            <!-- This is the master layout, describing all regions -->
            <fo:layout-master-set>
                <fo:simple-page-master
                    master-name="A4-portrait"
                    page-height="297mm"
                    page-width="210mm"
                >
                    <fo:region-body margin-left="25mm" margin-right="20mm" margin-top="45mm" margin-bottom="50mm"/>
                    <fo:region-before extent="45mm"/>
                    <fo:region-after extent="33mm"/>
                </fo:simple-page-master>
            </fo:layout-master-set>

            <fo:page-sequence master-reference="A4-portrait">
                <!-- Header of each page, also used to place some common elements -->
                <fo:static-content flow-name="xsl-region-before">
                    <fo:block-container
                        absolute-position="absolute"
                        top="15mm"
                        left="135mm"
                        width="70mm"
                        height="20mm"
                    >
                        <!-- Note that external URLs must be either absolute or relative to the the root of the application -->
                        <fo:block><fo:external-graphic src="url('module/AjastaInvoice/data/logo.tif')" content-width="60mm" content-height="13.64mm"/></fo:block>
                    </fo:block-container>

                    <!-- Upper fold mark -->
                    <fo:block-container absolute-position="absolute" top="105mm" left="0" width="10mm" height="0.2mm" background-color="cmyk(0, 0, 0, 0.5)"><fo:block/></fo:block-container>
                    <!-- Lower fold mark -->
                    <fo:block-container absolute-position="absolute" top="210mm" left="0" width="10mm" height="0.2mm" background-color="cmyk(0, 0, 0, 0.5)"><fo:block/></fo:block-container>
                    <!-- Punch hole mark -->
                    <fo:block-container absolute-position="absolute" top="148.5mm" left="0" width="5mm" height="0.2mm" background-color="cmyk(0, 0, 0, 0.5)"><fo:block/></fo:block-container>
                </fo:static-content>

                <!-- Footer of each page -->
                <fo:static-content flow-name="xsl-region-after">
                    <fo:block-container
                        absolute-position="absolute"
                        top="0"
                        left="25mm"
                        width="55mm"
                    >
                        <fo:block font-size="7pt" white-space-collapse="true" linefeed-treatment="preserve"><xsl:value-of select="ajasta:translations/ajasta:footer-field-1"/></fo:block>
                    </fo:block-container>
                    <fo:block-container
                        absolute-position="absolute"
                        top="0"
                        left="80mm"
                        width="55mm"
                    >
                        <fo:block font-size="7pt" white-space-collapse="true" linefeed-treatment="preserve"><xsl:value-of select="ajasta:translations/ajasta:footer-field-2"/></fo:block>
                    </fo:block-container>
                    <fo:block-container
                        absolute-position="absolute"
                        top="0"
                        left="135mm"
                        width="65mm"
                    >
                        <fo:block font-size="7pt" white-space-collapse="true" linefeed-treatment="preserve"><xsl:value-of select="ajasta:translations/ajasta:footer-field-3"/></fo:block>
                    </fo:block-container>

                    <fo:block-container absolute-position="absolute" bottom="10.5mm" left="0" width="210mm" height="0.5mm" background-color="cmyk(0, 0, 0, 0.5)"><fo:block/></fo:block-container>
                    <fo:block-container absolute-position="absolute" bottom="0" left="0" width="210mm" height="10mm" background-color="cmyk(0.79, 0, 1, 0)"><fo:block/></fo:block-container>
                </fo:static-content>

                <!-- Actual body of the invoice -->
                <fo:flow flow-name="xsl-region-body">
                    <!-- This is the address on the first page -->
                    <fo:block-container absolute-position="absolute" top="0" left="0" width="165mm" height="45mm">
                        <fo:block font-size="7pt">John Doe, 100 Main St, Seattle WA 98104, UNITED STATES</fo:block>
                        <fo:block-container absolute-position="absolute" top="3mm" left="-5mm" width="85mm" height="0.2mm" background-color="cmyk(0, 0, 0, 0.5)"><fo:block/></fo:block-container>
                        <fo:block margin-top="1mm" font-size="10pt" white-space-collapse="true" linefeed-treatment="preserve"><xsl:value-of select="ajasta:address"/></fo:block>

                        <fo:block-container absolute-position="absolute" top="5mm" left="110mm" width="35mm">
                            <fo:block font-size="10pt" margin-bottom="2mm"><xsl:value-of select="ajasta:translations/ajasta:message[@id='invoice-id']"/></fo:block>
                            <fo:block font-size="10pt" margin-bottom="2mm"><xsl:value-of select="ajasta:translations/ajasta:message[@id='issue-date']"/></fo:block>
                            <fo:block font-size="10pt" margin-bottom="2mm"><xsl:value-of select="ajasta:translations/ajasta:message[@id='due-date']"/></fo:block>
                        </fo:block-container>

                        <fo:block-container absolute-position="absolute" top="5mm" left="145mm" width="40mm">
                            <fo:block font-size="10pt" margin-bottom="2mm"><xsl:value-of select="ajasta:invoice-id"/></fo:block>
                            <fo:block font-size="10pt" margin-bottom="2mm"><xsl:value-of select="ajasta:issue-date"/></fo:block>
                            <fo:block font-size="10pt" margin-bottom="2mm"><xsl:value-of select="ajasta:due-date"/></fo:block>
                        </fo:block-container>
                    </fo:block-container>

                    <!-- Subject -->
                    <fo:block font-size="20pt" font-weight="bold" margin-top="53.45mm" margin-bottom="5mm">Invoice</fo:block>

                    <!-- This is the table containing all items -->
                    <fo:table table-layout="fixed" width="165mm">
                        <fo:table-column column-width="75mm"/>
                        <fo:table-column column-width="30mm"/>
                        <fo:table-column column-width="30mm"/>
                        <fo:table-column column-width="30mm"/>

                        <fo:table-header>
                            <fo:table-row>
                                <fo:table-cell border-after-width="0.2mm" border-after-color="cmyk(0, 0, 0, 1)" border-after-style="solid" padding="1mm">
                                    <fo:block font-size="10pt" font-weight="bold" color="cmyk(0.79, 0, 1, 0)">
                                        <xsl:value-of select="ajasta:translations/ajasta:message[@id='description']"/>
                                    </fo:block>
                                </fo:table-cell>
                                <fo:table-cell border-after-width="0.2mm" border-after-color="cmyk(0, 0, 0, 1)" border-after-style="solid" padding="1mm">
                                    <fo:block font-size="10pt" font-weight="bold" color="cmyk(0.79, 0, 1, 0)">
                                        <xsl:value-of select="ajasta:translations/ajasta:message[@id='quantity']"/>
                                    </fo:block>
                                </fo:table-cell>
                                <fo:table-cell border-after-width="0.2mm" border-after-color="cmyk(0, 0, 0, 1)" border-after-style="solid" padding="1mm" text-align="right">
                                    <fo:block font-size="10pt" font-weight="bold" color="cmyk(0.79, 0, 1, 0)">
                                        <xsl:value-of select="ajasta:translations/ajasta:message[@id='unit-price']"/>
                                    </fo:block>
                                </fo:table-cell>
                                <fo:table-cell border-after-width="0.2mm" border-after-color="cmyk(0, 0, 0, 1)" border-after-style="solid" padding="1mm" text-align="right">
                                    <fo:block font-size="10pt" font-weight="bold" color="cmyk(0.79, 0, 1, 0)">
                                        <xsl:value-of select="ajasta:translations/ajasta:message[@id='amount']"/>
                                    </fo:block>
                                </fo:table-cell>
                            </fo:table-row>
                        </fo:table-header>
                        <fo:table-body>
                            <!-- The items and other data are formatted via templates -->
                            <xsl:apply-templates select="ajasta:items/ajasta:item"/>
                            <xsl:apply-templates select="ajasta:sub-total"/>
                            <xsl:apply-templates select="ajasta:discount"/>
                            <xsl:apply-templates select="vat"/>
                            <xsl:apply-templates select="ajasta:total"/>
                        </fo:table-body>
                    </fo:table>
                </fo:flow>
            </fo:page-sequence>
        </fo:root>
    </xsl:template>

    <!-- Template for displaying individual items in the table -->
    <xsl:template match="ajasta:item">
        <fo:table-row>
            <fo:table-cell padding="1mm">
                <fo:block font-size="10pt"><xsl:value-of select="ajasta:description"/></fo:block>
            </fo:table-cell>
            <fo:table-cell padding="1mm">
                <fo:block font-size="10pt"><xsl:value-of select="ajasta:quantity"/></fo:block>
            </fo:table-cell>
            <fo:table-cell padding="1mm" text-align="right">
                <fo:block font-size="10pt"><xsl:value-of select="ajasta:unit-price"/></fo:block>
            </fo:table-cell>
            <fo:table-cell padding="1mm" text-align="right">
                <fo:block font-size="10pt"><xsl:value-of select="ajasta:amount"/></fo:block>
            </fo:table-cell>
        </fo:table-row>
    </xsl:template>

    <!-- Template for the sub-total amount -->
    <xsl:template match="ajasta:sub-total">
        <fo:table-row>
            <fo:table-cell border-before-width="0.2mm" border-before-color="cmyk(0, 0, 0, 0.5)" border-before-style="solid" padding="1mm"><fo:block/></fo:table-cell>
            <fo:table-cell border-before-width="0.2mm" border-before-color="cmyk(0, 0, 0, 0.5)" border-before-style="solid" padding="1mm">
                <fo:block font-size="10pt">Subtotal</fo:block>
            </fo:table-cell>
            <fo:table-cell border-before-width="0.2mm" border-before-color="cmyk(0, 0, 0, 0.5)" border-before-style="solid" padding="1mm" number-columns-spanned="2" text-align="right">
                <fo:block font-size="10pt"><xsl:value-of select="."/></fo:block>
            </fo:table-cell>
        </fo:table-row>
    </xsl:template>

    <!-- Template for the total amount -->
    <xsl:template match="ajasta:total">
        <fo:table-row>
            <fo:table-cell padding="1mm"><fo:block/></fo:table-cell>
            <fo:table-cell padding="1mm">
                <fo:block font-size="10pt" font-weight="bold">Total amount</fo:block>
            </fo:table-cell>
            <fo:table-cell padding="1mm" number-columns-spanned="2" text-align="right">
                <fo:block font-size="10pt" font-weight="bold"><xsl:value-of select="."/></fo:block>
            </fo:table-cell>
        </fo:table-row>
    </xsl:template>
</xsl:stylesheet>
