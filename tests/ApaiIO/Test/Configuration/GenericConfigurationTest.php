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

namespace ApaiIO\Test\Configuration;

use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Request\GuzzleRequest;
use ApaiIO\ResponseTransformer\XmlToDomDocument;

class GenericConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function testGettersAndSetters()
    {
        $object = new GenericConfiguration();

        $object->setAccessKey('ABC');
        $object->setSecretKey('DEF');
        $object->setAssociateTag('GHI');
        $object->setResponseTransformer($a = new XmlToDomDocument());
        $object->setRequest($b = new GuzzleRequest($this->prophesize('\GuzzleHttp\ClientInterface')->reveal()));

        $this->assertSame('ABC', $object->getAccessKey());
        $this->assertSame('DEF', $object->getSecretKey());
        $this->assertSame('GHI', $object->getAssociateTag());
        $this->assertSame($a, $object->getResponseTransformer());
        $this->assertSame($b, $object->getRequest());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCountryException()
    {
        $object = new GenericConfiguration();
        $object->setCountry('no country');
    }

    public function testCountrySetter()
    {
        $object = new GenericConfiguration();
        $object->setCountry('DE');

        $this->assertEquals('de', $object->getCountry());
    }
}
