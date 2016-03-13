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

namespace ApaiIO\Test;

use ApaiIO\ApaiIO;
use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Search;

class ApaiIOTest extends \PHPUnit_Framework_TestCase
{
    public function testApaiIORequestPerfomOperation()
    {
        $conf = new GenericConfiguration();
        $operation = new Search();

        $request = $this->getMock('\ApaiIO\Request\Rest\Request', array('perform'));
        $request
            ->expects($this->once())
            ->method('perform')
            ->with($this->equalTo($operation));

        $conf->setRequest($request);

        $apaiIO = new ApaiIO($conf);
        $apaiIO->runOperation($operation);
    }

    public function testApaiIOTransformResponse()
    {
        $conf = new GenericConfiguration();
        $operation = new Search();

        $request = $this->getMock('\ApaiIO\Request\Rest\Request', array('perform'));
        $request
            ->expects($this->once())
            ->method('perform')
            ->will($this->returnValue(array('a' => 'b')));

        $conf->setRequest($request);

        $responseTransformer = $this->getMock('\ApaiIO\ResponseTransformer\ResponseTransformerInterface', array('transform'));
        $responseTransformer
            ->expects($this->once())
            ->method('transform')
            ->with($this->equalTo(array('a' => 'b')));

        $conf->setResponseTransformer($responseTransformer);

        $apaiIO = new ApaiIO($conf);
        $apaiIO->runOperation($operation);
    }
}
