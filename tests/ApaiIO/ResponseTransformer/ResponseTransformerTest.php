<?php
use ApaiIO\Request\Util;
use ApaiIO\ResponseTransformer\ObjectToArray;
use ApaiIO\ResponseTransformer\XmlToDomDocument;
use ApaiIO\ResponseTransformer\XmlToSimpleXmlObject;

/*
 * Copyright 2013 Jan Eichhorn <exeu65@googlemail.com>
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

class ResponseTransformerTest extends \PHPUnit_Framework_TestCase
{
    public function testObjectToArray()
    {
        $stdClassSub = new \stdClass();
        $stdClassSub->baz = 'bar';

        $stdClass = new \stdClass();
        $stdClass->foo = 'bar';
        $stdClass->bar = $stdClassSub;

        $array = array('foo' => 'bar', 'bar' => array('baz' => 'bar'));
        $transformer = new ObjectToArray();

        $this->assertEquals($array, $transformer->transform($stdClass));
    }

    public function testXmlToDomDocument()
    {
        $transformer = new XmlToDomDocument();

        $xml = $this->getSampleXMLResponse();

        $document = $transformer->transform($xml);

        $this->assertInstanceOf('\DOMDocument', $document);
    }

    public function testXmlToSimpleXMLObject()
    {
        $transformer = new XmlToSimpleXmlObject();

        $sampleXML = $this->getSampleXMLResponse();

        $simpleXML = $transformer->transform($sampleXML);

        $this->assertInstanceOf('\SimpleXMLElement', $simpleXML);
        $this->assertEquals('Wikipedia Städteverzeichnis', $simpleXML->titel);
        $this->assertEquals('Genf', $simpleXML->eintrag[0]->stichwort);
    }

    /**
     * @return string
     */
    private function getSampleXMLResponse()
    {
        return <<<EOF
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
        <verzeichnis>
             <titel>Wikipedia Städteverzeichnis</titel>
             <eintrag>
                  <stichwort>Genf</stichwort>
                  <eintragstext>Genf ist der Sitz von ...</eintragstext>
             </eintrag>
             <eintrag>
                  <stichwort>Köln</stichwort>
                  <eintragstext>Köln ist eine Stadt, die ...</eintragstext>
             </eintrag>
        </verzeichnis>
EOF;
    }
}