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

use ApaiIO\Request\Util;
use ApaiIO\Request\RequestFactory;
use ApaiIO\Configuration\GenericConfiguration;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testValidRequestObjectFromString()
    {
        $conf = new GenericConfiguration();
        $conf->setRequest('\ApaiIO\Request\Soap\Request');

        $request = RequestFactory::createRequest($conf);

        $this->assertInstanceOf('\ApaiIO\Request\Soap\Request', $request);
    }

    public function testValidRequestObjectFromObject()
    {
        $conf = new GenericConfiguration();
        $conf->setRequest(new \ApaiIO\Request\Soap\Request());

        $request = RequestFactory::createRequest($conf);

        $this->assertInstanceOf('\ApaiIO\Request\Soap\Request', $request);
    }

    /**
     * @expectedException LogicException
     */
    public function testInvalidRequestObjectFromString()
    {
        $conf = new GenericConfiguration();
        $conf->setRequest('\Exception');

        $request = RequestFactory::createRequest($conf);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testNonExistingRequestObjectFromString()
    {
        $conf = new GenericConfiguration();
        $conf->setRequest('\XFOO');

        $request = RequestFactory::createRequest($conf);
    }

    /**
     * @expectedException LogicException
     */
    public function testInvalidRequestObjectFromObject()
    {
        $conf = new GenericConfiguration();
        $conf->setRequest(new \Exception());

        $request = RequestFactory::createRequest($conf);
    }

    public function testSameRequest()
    {
        $conf = new GenericConfiguration();

        $requestA = RequestFactory::createRequest($conf);
        $requestB = RequestFactory::createRequest($conf);

        $this->assertSame($requestA, $requestB);

    }
}