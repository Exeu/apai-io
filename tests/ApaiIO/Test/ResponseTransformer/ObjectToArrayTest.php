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

namespace ApaiIO\Test\ResponseTransformer;

use ApaiIO\ResponseTransformer\ObjectToArray;

class ObjectToArrayTest extends \PHPUnit_Framework_TestCase
{
    /**
     * the subject
     *
     * @var ObjectToArray
     */
    public $objectToArray;

    protected function setUp()
    {
        parent::setUp();
        $this->objectToArray = new ObjectToArray();
    }

    protected function tearDown()
    {
        $this->objectToArray = null;
        parent::tearDown();
    }

    public function testTransformSimpleObject()
    {
        $expectedArray = array(
            __METHOD__ => __LINE__
        );

        $transformedValue = $this->objectToArray->transform((object)$expectedArray);
        $this->assertEquals($expectedArray, $transformedValue);
    }

    public function testTransformInnerObject()
    {
        $innerObject = (object) array(__CLASS__ => __FUNCTION__);
        $expectedArray = array(
            __METHOD__ => (array) $innerObject,
        );

        $toTransformValue = $expectedArray;
        $toTransformValue[__METHOD__] = $innerObject;

        $transformedValue = $this->objectToArray->transform((object)$toTransformValue);
        $this->assertEquals($expectedArray, $transformedValue);
    }

    public function testTransformInnerArray()
    {
        $expectedArray = array(
            __METHOD__ => array(__CLASS__ => __FUNCTION__),
        );

        $transformedValue = $this->objectToArray->transform((object)$expectedArray);
        $this->assertEquals($expectedArray, $transformedValue);
    }
}
