<?xml version="1.0" encoding="utf-8"?><!DOCTYPE xsl:stylesheet  [
	<!ENTITY nbsp   "&#160;">
	<!ENTITY copy   "&#169;">
	<!ENTITY reg    "&#174;">
	<!ENTITY trade  "&#8482;">
	<!ENTITY mdash  "&#8212;">
	<!ENTITY ldquo  "&#8220;">
	<!ENTITY rdquo  "&#8221;"> 
	<!ENTITY pound  "&#163;">
	<!ENTITY yen    "&#165;">
	<!ENTITY euro   "&#8364;">
]>
<xsl:stylesheet version="1.0" 
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
	xmlns:atom="http://www.w3.org/2005/Atom">
<xsl:output method="html" encoding="utf-8" doctype-system="about:legacy-compat"/>
<xsl:template match="/">
	<xsl:apply-templates select="rss/channel"/>
</xsl:template>

<xsl:template match="rss/channel">

<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><xsl:value-of select="title"/></title>
    <meta name="description" content="RSS feed for photography by Matthew Schlachter" />
    <meta name="author" content="Matthew Schlachter" />
    <meta name="language" content="en" />
    
    <link rel="stylesheet" type="text/css" href="/css/app.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png" />
    <link rel="manifest" href="/site.webmanifest" />
</head>

<body style="padding:2rem;">
<div id="cometestme" style="display:none;"
 ><xsl:text disable-output-escaping="yes" >&amp;amp;</xsl:text></div>
<h1><xsl:apply-templates select="title"/></h1>
<p>This RSS feed provides the latest posts from <xsl:apply-templates select="title"/>.</p>
	
<h2>What is an RSS feed?</h2>
<p>An RSS feed is an XML-based data format that allows publishers to syndicate information. It allows you to stay up to date on topics that interest you&mdash;all in one place&mdash;without visiting 20-30 different web sites to check for new content. All you need to do to get started is to add the URL (web address) for this feed to your RSS reader.</p>
<p>The URL for this RSS feed is: <xsl:apply-templates select="atom:link"/></p>

<xsl:apply-templates select="item"/>

<script type="text/javascript" src="/js/xsl-to-html.js"></script>
</body>
</html>

</xsl:template>

<xsl:template match="item">
	<h2><a href="{link}"><xsl:apply-templates select="title"/></a></h2>
	<p><emph><xsl:apply-templates select="pubDate"/></emph></p>
	<p><xsl:apply-templates select="description"/></p>
	<hr/>
</xsl:template>

<xsl:template match="title">
	<xsl:value-of select="."/>
</xsl:template>

<xsl:template match="pubdate">
	<xsl:value-of select="."/>
</xsl:template>

<xsl:template match="description">
    <div name="decodeme">
        <xsl:value-of select="." disable-output-escaping="yes"/>
    </div>
</xsl:template>

<xsl:template match="link">
	<a href="{.}"><xsl:value-of select="."/></a>
</xsl:template>

<xsl:template match="atom:link">
	<a href="{@href}"><xsl:value-of select="@href"/></a>
</xsl:template>


</xsl:stylesheet>
