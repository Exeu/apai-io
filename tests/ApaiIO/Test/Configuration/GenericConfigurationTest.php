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

namespace ApaiIO\Test\Configuration;

use ApaiIO\Configuration\GenericConfiguration;

class GenericConfigurationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \ApaiIO\Configuration\GenericConfiguration
     */
    private $genericConfiguration;

    protected function setUp()
    {
        $this->genericConfiguration = new GenericConfiguration();
        parent::setUp();
    }

    public function testSetRequestFactoryExeptsClosure()
    {
        $this->genericConfiguration->setRequestFactory(function(){});
    }

    public function testSetRequestFactoryExeptsCallable()
    {
        $this->genericConfiguration->setRequestFactory(array(__NAMESPACE__ . '\CallableClass', 'foo'));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetRequestFactoryThrowExceptionIfArgumentIsNotCallable()
    {
        $this->genericConfiguration->setRequestFactory("");
    }

    public function testSetResponseTransformerFactoryExeptsClosure()
    {
        $this->genericConfiguration->setResponseTransformerFactory(function(){});
    }

    public function testSetResponseTransformerExeptsCallable()
    {
        $this->genericConfiguration->setResponseTransformerFactory(array(__NAMESPACE__ . '\CallableClass', 'foo'));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetResponseTransformerFactoryThrowExceptionIfArgumentIsNotCallable()
    {
        $this->genericConfiguration->setResponseTransformerFactory("");
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

class CallableClass
{
    public static function foo()
    {
    }
}
