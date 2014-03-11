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

use ApaiIO\Common\OperationTrait;
use ApaiIO\Operations\Lookup;

class LookupTest extends \PHPUnit_Framework_TestCase
{
    public function testSetter()
    {
        $lookup = new Lookup();
        $lookup->setItemId('B1234');
    }

    public function testGetName()
    {
        $lookup = new Lookup();
        $this->assertEquals('ItemLookup', $lookup->getName());
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
        foreach($valididTypes as $valididType) {
            $lookup->setIdType($valididType);
            $this->assertEquals($valididType, $lookup->getIdType());
        }
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
        $lookup->setSearchIndex('Appliances');
        $this->assertEquals('Appliances', $lookup->getSearchIndex());
    }
}
