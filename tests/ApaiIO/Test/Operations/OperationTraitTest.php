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

namespace ApaiIO\Test\Operations;

use ApaiIO\Common\OperationTrait;

class OperationTraitTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        if (version_compare(phpversion(), '5.4.0', '<')) {
            $this->markTestSkipped('You need PHP >= 5.4.0 to run this test');
        }
    }

    public function testOperationTrait()
    {
        $search = new TraitSearch();

        $search->setResponseGroup(array('Large'));

        $expectedResult = array('ResponseGroup' => array('Large'));

        $this->assertEquals($expectedResult, $search->getOperationParameter());
    }
}