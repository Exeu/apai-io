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

namespace ApaiIO\Test\Operations\Types;

use ApaiIO\Operations\Search;

class SearchTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function testSearchException()
    {
        $search = new Search();
        $search->setPage(11);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testMaximumPriceException()
    {
        $search = new Search();
        $search->setMaximumPrice(-1);
    }

    public function testMaximumPriceGetterAndSetter()
    {
        $search = new Search();

        $object = $search->setMaximumPrice(100);

        static::assertSame($search, $object);
        static::assertEquals(100, $search->getMaximumPrice());
    }

    public function testMinimumPriceGetterAndSetter()
    {
        $search = new Search();

        $object = $search->setMinimumPrice(100);

        static::assertSame($search, $object);
        static::assertEquals(100, $search->getMinimumPrice());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testMinimumPriceException()
    {
        $search = new Search();
        $search->setMinimumPrice('helloworld');
    }

    public function testSearchValidPage()
    {
        $search = new Search();
        $search->setPage(1);

        static::assertEquals(1, $search->getItemPage());
    }

    public function testConditionGetterAndSetter()
    {
        $search = new Search();
        $search->setCondition('All');
        static::assertEquals('All', $search->getCondition());
    }

    public function testAvailabilityGetterAndSetter()
    {
        $search = new Search();
        $search->setAvailability('Available');
        static::assertEquals('Available', $search->getAvailability());
    }

    public function testNodeGetterAndSetter()
    {
        $search = new Search();
        static::assertEquals(null, $search->getBrowseNode());
        $search->setBrowseNode(10967581);
        static::assertEquals(10967581, $search->getBrowseNode());
    }

    public function testGetCategory()
    {
        $search = new Search();
        static::assertEquals(null, $search->getCategory());
        $search->setCategory('All');
        static::assertEquals('All', $search->getCategory());
    }

    public function testGetKeywords()
    {
        $search = new Search();
        static::assertEquals(null, $search->getKeywords());
        $search->setKeywords('4k tv');
        static::assertEquals('4k tv', $search->getKeywords());
    }

    public function testGetPage()
    {
        $search = new Search();
        static::assertEquals(null, $search->getPage());
        $search->setPage(3);
        static::assertEquals(3, $search->getPage());
    }

    public function testGetMinimumPrice()
    {
        $search = new Search();
        static::assertEquals(null, $search->getMinimumPrice());
        $search->setMinimumPrice(899);
        static::assertEquals(899, $search->getMinimumPrice());
    }

    public function testGetMaximumPrice()
    {
        $search = new Search();
        static::assertEquals(null, $search->getMaximumPrice());
        $search->setMaximumPrice(899);
        static::assertEquals(899, $search->getMaximumPrice());
    }

    public function testGetCondition()
    {
        $search = new Search();
        static::assertEquals(null, $search->getCondition());
        $search->setCondition('Collectible');
        static::assertEquals('Collectible', $search->getCondition());
    }

    public function testGetAvailability()
    {
        $search = new Search();
        static::assertEquals(null, $search->getAvailability());
        $search->setAvailability('Available');
        static::assertEquals('Available', $search->getAvailability());
    }

    public function testGetBrowseNode()
    {
        $search = new Search();
        static::assertEquals(null, $search->getBrowseNode());
        $search->setBrowseNode(123);
        static::assertEquals(123, $search->getBrowseNode());
    }
}
