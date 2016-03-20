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

use ApaiIO\Operations\CartCreate;

class CartCreateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * the subject
     *
     * @var CartCreate
     */
    private $cartCreate;

    protected function setUp()
    {
        parent::setUp();
        $this->cartCreate = new CartCreate();
    }

    protected function tearDown()
    {
        $this->cartCreate = null;
        parent::tearDown();
    }

    public function testName()
    {
        $this->assertEquals("CartCreate", $this->cartCreate->getName());
    }

    public function testAddItem()
    {
        $operationParameters = $this->cartCreate->getOperationParameter();
        $this->assertEquals([], $operationParameters);

        $asin = __LINE__;
        $this->cartCreate->addItem($asin, 2);

        $operationParameters = $this->cartCreate->getOperationParameter();
        $this->assertEquals($asin, $operationParameters["Item.1.ASIN"]);
        $this->assertEquals(2, $operationParameters["Item.1.Quantity"]);
    }

    public function testAddItemByOfferListingId()
    {
        $operationParameters = $this->cartCreate->getOperationParameter();
        $this->assertEquals([], $operationParameters);

        $asin = __LINE__;
        $this->cartCreate->addItem($asin, 2, false);

        $operationParameters = $this->cartCreate->getOperationParameter();
        $this->assertEquals($asin, $operationParameters["Item.1.OfferListingId"]);
        $this->assertEquals(2, $operationParameters["Item.1.Quantity"]);
    }

    public function testAddItemIncrementsCounter()
    {
        $asin = __LINE__;
        $this->cartCreate->addItem($asin, 2);
        $this->cartCreate->addItem($asin, 2);

        $operationParameters = $this->cartCreate->getOperationParameter();
        $this->assertEquals($asin, $operationParameters["Item.2.ASIN"]);
        $this->assertEquals(2, $operationParameters["Item.2.Quantity"]);
    }
}
