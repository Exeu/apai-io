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

use ApaiIO\Operations\SimilarityLookup;

class SimilarityLookupTest extends \PHPUnit_Framework_TestCase
{
    public function testSetter()
    {
        $lookup = new SimilarityLookup();
        $lookup->setItemId('B1234');
    }

    public function testGetName()
    {
        $lookup = new SimilarityLookup();
        $this->assertEquals('SimilarityLookup', $lookup->getName());
    }

    public function testGetItemId()
    {
        $lookup = new SimilarityLookup();
        $this->assertEquals(null, $lookup->getItemId());
        $lookup->setItemId('B0117IJ4LE');
        $this->assertEquals('B0117IJ4LE', $lookup->getItemId());
    }
}
