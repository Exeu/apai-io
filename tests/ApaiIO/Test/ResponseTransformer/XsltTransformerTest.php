<?php
/*
 * Copyright 2016 Jan Eichhorn <exeu65@googlemail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace ApaiIO\Test\ResponseTransformer;

use ApaiIO\ResponseTransformer\Xslt;

class XsltTransformerTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        if (!extension_loaded('xsl')) {
            $this->markTestSkipped('You need to activate XSLT to run this test.');
        }
    }

    public function testXsltResponseTransformer()
    {
        $responseTransformer = new Xslt($this->getSampleXslForTransformation());

        $result = $responseTransformer->transform($this->getSampleXmlForTransformation());

        $this->assertEquals(
            'Fight for your mind by Ben Harper - 1995',
            trim($result)
        );
    }

    private function getSampleXmlForTransformation()
    {
        return <<<EOF
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<collection>
 <cd>
  <title>Fight for your mind</title>
  <artist>Ben Harper</artist>
  <year>1995</year>
 </cd>
</collection>
EOF;
    }

    private function getSampleXslForTransformation()
    {
        return <<<EOF
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
 <xsl:param name="owner" select="'Nicolas Eliaszewicz'"/>
 <xsl:output method="html" encoding="utf-8" indent="no"/>
 <xsl:template match="collection">
  <xsl:apply-templates/>
 </xsl:template>
 <xsl:template match="cd">
  <xsl:value-of select="title"/> by <xsl:value-of select="artist"/> - <xsl:value-of select="year"/>
 </xsl:template>
</xsl:stylesheet>
EOF;
    }
}
