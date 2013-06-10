<?php
use ApaiIO\Request\Util;
use ApaiIO\ResponseTransformer\ObjectToArray;
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
}