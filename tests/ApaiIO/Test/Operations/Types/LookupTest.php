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

use ApaiIO\Operations\Lookup;

class LookupTest extends \PHPUnit_Framework_TestCase
{
    public function testSetter()
    {
        $lookup = new Lookup();
        $lookup->setItemId('B1234');
    }

    /**
     * @expectedException \Exception
     */
    public function testSettersNegative()
    {
        $lookup = new Lookup();
        $lookup->setItemIds(array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11));
    }

    public function testMultiItemSet()
    {
        $lookup = new Lookup();
        $lookup->setItemIds(array(1, 2, 3, 4));

        $itemQuery = $lookup->getItemId();

        static::assertSame('1,2,3,4', $itemQuery);
    }

    public function testGetName()
    {
        $lookup = new Lookup();
        static::assertEquals('ItemLookup', $lookup->getName());
    }

    public function testGetIdType()
    {
        $lookup = new Lookup();
        $valididTypes = array(
            'ASIN',
            'SKU',
            'UPC',
            'EAN',
            'ISBN',
            Lookup::TYPE_ASIN,
            Lookup::TYPE_SKU,
            Lookup::TYPE_UPC,
            Lookup::TYPE_EAN,
            Lookup::TYPE_ISBN
        );
        foreach ($valididTypes as $valididType) {
            $lookup->setIdType($valididType);
            static::assertEquals($valididType, $lookup->getIdType());
        }
    }

    /**
     * @dataProvider providerSetIdTypeAffectsSearchIndex
     *
     * @param string $idType
     * @param string|null $expectedSearchIndex
     */
    public function testSetIdTypeAffectsSearchIndex($idType, $expectedSearchIndex)
    {
        $lookup = new Lookup();
        $lookup->setIdType($idType);

        $parameters = $lookup->getOperationParameter();

        if ($expectedSearchIndex === null) {
            static::assertArrayNotHasKey('SearchIndex', $parameters);
        } else {
            static::assertSame($expectedSearchIndex, $parameters['SearchIndex']);
        }
    }

    /**
     * @return array
     */
    public function providerSetIdTypeAffectsSearchIndex()
    {
        return array(
            array(Lookup::TYPE_ASIN, null),
            array(Lookup::TYPE_SKU, 'All'),
            array(Lookup::TYPE_UPC, 'All'),
            array(Lookup::TYPE_EAN, 'All'),
            array(Lookup::TYPE_ISBN, 'All')
        );
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testExceptionWhenPassingWrongIdType()
    {
        $lookup = new Lookup();
        $lookup->setIdType('Invalid IdType');
    }

    public function testGetSearchIndex()
    {
        $lookup = new Lookup();
        static::assertEquals(null, $lookup->getSearchIndex());
        $lookup->setSearchIndex('Appliances');
        static::assertEquals('Appliances', $lookup->getSearchIndex());
    }

    public function testConditionGetterAndSetter()
    {
        $lookup = new Lookup();
        static::assertEquals(null, $lookup->getCondition());
        $lookup->setCondition('All');
        static::assertEquals('All', $lookup->getCondition());
    }

    public function testGetItemId()
    {
        $lookup = new Lookup();
        static::assertEquals(null, $lookup->getItemId());
        $lookup->setItemId('B0117IJ4LE');
        static::assertEquals('B0117IJ4LE', $lookup->getItemId());
    }

    public function testGetCondition()
    {
        $lookup = new Lookup();
        static::assertEquals(null, $lookup->getCondition());
        $lookup->setCondition('Used');
        static::assertEquals('Used', $lookup->getCondition());
    }
}
