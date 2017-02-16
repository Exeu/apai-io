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

use ApaiIO\Operations\CartModify;

class CartModifyTest extends \PHPUnit_Framework_TestCase
{
    public function testSetter()
    {
        $operation = new CartModify();
        $operation->setHMAC('1234');
        $operation->setCartId('789');
    }

    public function testGetName()
    {
        $operation = new CartModify();
        $this->assertEquals('CartModify', $operation->getName());
    }

    public function testGetCartId()
    {
        $operation = new CartModify();
        $this->assertEquals(null, $operation->getCartId());
        $operation->setCartId('789');
        $this->assertEquals('789', $operation->getCartId());
    }

    public function testGetHMAC()
    {
        $operation = new CartModify();
        $this->assertEquals(null, $operation->getHMAC());
        $operation->setHMAC('1234');
        $this->assertEquals('1234', $operation->getHMAC());
    }

    public function testCountable()
    {
        $operation = new CartModify();
        $this->assertEquals(0, count($operation));

        $operation->modifyQuantity('dummyId1', 1);
        $operation->modifyQuantity('dummyId1', 1);
        $operation->modifyQuantity('dummyId2', 1);
        $operation->modifyAction('dummyId1', 'SaveForLater');

        $this->assertEquals(4, count($operation));
    }

    /**
     * @expectedException \OverflowException
     */
    public function testModifyQuantityModificationLimit()
    {
        $operation = new CartModify();

        $operation->modifyQuantity('dummyId1', 1);
        $operation->modifyQuantity('dummyId1', 1);
        $operation->modifyQuantity('dummyId2', 1);
        $operation->modifyQuantity('dummyId1', 1);
        $operation->modifyQuantity('dummyId1', 1);
        $operation->modifyQuantity('dummyId2', 1);
        $operation->modifyQuantity('dummyId1', 1);
        $operation->modifyQuantity('dummyId1', 1);
        $operation->modifyQuantity('dummyId2', 1);
        $operation->modifyQuantity('dummyId1', 1);
        $operation->modifyQuantity('dummyId1', 1);
        $operation->modifyQuantity('dummyId2', 1);
    }

    public function testModifyActionMoveToCart()
    {
        $operation = new CartModify();
        $operation->modifyAction('dummyId1', 'MoveToCart');
        
        $this->assertEquals(1, count($operation));
    }

    public function testModifyActionSaveForLater()
    {
        $operation = new CartModify();
        $operation->modifyAction('dummyId1', 'SaveForLater');

        $this->assertEquals(1, count($operation));
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testModifyActionWrongType()
    {
        $operation = new CartModify();
        $operation->modifyAction('dummyId1', 13);

        $this->assertEquals(1, count($operation));
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testModifyActionInvalidOption()
    {
        $operation = new CartModify();
        $operation->modifyAction('dummyId1', 13);

        $this->assertEquals(1, count($operation));
    }

    public function testModifyQuantityQuantityMinLimit()
    {
        $operation = new CartModify();
        $operation->modifyQuantity('dummyId1', 0);

        $this->assertEquals(1, count($operation));
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testModifyQuantityQuantityUnderMinLimit()
    {
        $operation = new CartModify();
        $operation->modifyQuantity('dummyId1', -1);
    }

    public function testModifyQuantityQuantityMaxLimit()
    {
        $operation = new CartModify();
        $operation->modifyQuantity('dummyId1', 999);
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testModifyQuantityQuantityOverMaxLimit()
    {
        $operation = new CartModify();
        $operation->modifyQuantity('dummyId1', 1000);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage  quantity must be integer, string given
     */
    public function testModifyQuantityQuantityWrongType()
    {
        $operation = new CartModify();
        $operation->modifyQuantity('dummyId1', '3');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage  quantity must be integer, double given
     */
    public function testModifyQuantityQuantityWrongType2()
    {
        $operation = new CartModify();
        $operation->modifyQuantity('dummyId1', 3.3);
    }
}
