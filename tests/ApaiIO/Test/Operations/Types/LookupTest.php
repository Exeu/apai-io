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
        $lookup->setItemIds([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]);
    }

    public function testMultiItemSet()
    {
        $lookup = new Lookup();
        $lookup->setItemIds([1, 2, 3, 4]);

        $itemQuery = $lookup->getItemId();

        $this->assertSame('1,2,3,4', $itemQuery);
    }

    public function testGetName()
    {
        $lookup = new Lookup();
        $this->assertEquals('ItemLookup', $lookup->getName());
    }

    public function testGetIdType()
    {
        $lookup = new Lookup();
        $valididTypes = [
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
        ];
        foreach ($valididTypes as $valididType) {
            $lookup->setIdType($valididType);
            $this->assertEquals($valididType, $lookup->getIdType());
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
            $this->assertArrayNotHasKey('SearchIndex', $parameters);
        } else {
            $this->assertSame($expectedSearchIndex, $parameters['SearchIndex']);
        }
    }

    /**
     * @return array
     */
    public function providerSetIdTypeAffectsSearchIndex()
    {
        return [
            [Lookup::TYPE_ASIN, null],
            [Lookup::TYPE_SKU, 'All'],
            [Lookup::TYPE_UPC, 'All'],
            [Lookup::TYPE_EAN, 'All'],
            [Lookup::TYPE_ISBN, 'All']
        ];
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
        $this->assertEquals(null, $lookup->getSearchIndex());
        $lookup->setSearchIndex('Appliances');
        $this->assertEquals('Appliances', $lookup->getSearchIndex());
    }

    public function testConditionGetterAndSetter()
    {
        $lookup = new Lookup();
        $this->assertEquals(null, $lookup->getCondition());
        $lookup->setCondition('All');
        $this->assertEquals('All', $lookup->getCondition());
    }

    public function testGetItemId()
    {
        $lookup = new Lookup();
        $this->assertEquals(null, $lookup->getItemId());
        $lookup->setItemId('B0117IJ4LE');
        $this->assertEquals('B0117IJ4LE', $lookup->getItemId());
    }

    public function testGetCondition()
    {
        $lookup = new Lookup();
        $this->assertEquals(null, $lookup->getCondition());
        $lookup->setCondition('Used');
        $this->assertEquals('Used', $lookup->getCondition());
    }
}
