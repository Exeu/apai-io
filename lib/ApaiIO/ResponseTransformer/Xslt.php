<?php
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

namespace ApaiIO\ResponseTransformer;

/**
 * A responsetransformer transforming an xml via xslt
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class Xslt implements ResponseTransformerInterface
{
    /**
     * XSLTProcessor object
     *
     * @var \XSLTProcessor
     */
    protected $xsl;

    /**
     * Constructor
     *
     * @param string $xslt
     */
    public function __construct($xslt)
    {
        $xsl = new \XSLTProcessor();
        $xsldoc = new \DOMDocument();

        $xsldoc->loadXML($xslt);
        $xsl->importStyleSheet($xsldoc);

        $this->xsl = $xsl;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($response)
    {
        $document = new \DOMDocument('1.0', 'UTF-8');
        $document->loadXML($response);

        return $this->xsl->transformToXml($document);
    }
}
