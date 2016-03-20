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

use ApaiIO\Operations\BrowseNodeLookup;

class BrowseNodeLookupTest extends \PHPUnit_Framework_TestCase
{
    public function testSetter()
    {
        $nodeLookup = new BrowseNodeLookup();
        $nodeLookup->setNodeId('12345');
    }

    public function testGetName()
    {
        $nodeLookup = new BrowseNodeLookup();
        $this->assertEquals('BrowseNodeLookup', $nodeLookup->getName());
    }

    public function testGetBrowseNode()
    {
        $nodeLookup = new BrowseNodeLookup();
        $this->assertEquals(null, $nodeLookup->getNodeId());
        $nodeLookup->setNodeId(290060);
        $this->assertEquals(290060, $nodeLookup->getNodeId());
    }
}
