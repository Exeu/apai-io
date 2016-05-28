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

namespace ApaiIO\Test\Operations\Types;

use ApaiIO\Operations\Search;

class AbstractOperationTest extends \PHPUnit_Framework_TestCase
{
    public function testAbstractOperationSetterAndGetter()
    {
        $search = new Search();
        $search->setFoo('ABC');

        $this->assertEquals('ABC', $search->getFoo());
    }

    /**
     * @expectedException BadFunctionCallException
     */
    public function testAbstractOperationInvalidMethodName()
    {
        $search = new Search();
        $search->foo();
    }

    public function testGetResponseGroup()
    {
        $search = new Search();
        $this->assertEquals(null, $search->getResponseGroup());
        $search->setResponseGroup(['Small', 'Medium', 'Large']);
        $this->assertEquals(['Small', 'Medium', 'Large'], $search->getResponseGroup());
    }
}
