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

use ApaiIO\Operations\CartAdd;

class CartAddTest extends \PHPUnit_Framework_TestCase
{
    public function testSetter()
    {
        $cart = new CartAdd();
        $cart->setHMAC('1234');
        $cart->setCartId('789');
    }

    public function testGetName()
    {
        $cart = new CartAdd();
        $this->assertEquals('CartAdd', $cart->getName());
    }

    public function testGetCartId()
    {
        $cart = new CartAdd();
        $this->assertEquals(null, $cart->getCartId());
        $cart->setCartId('789');
        $this->assertEquals('789', $cart->getCartId());
    }

    public function testGetHMAC()
    {
        $cart = new CartAdd();
        $this->assertEquals(null, $cart->getHMAC());
        $cart->setHMAC('1234');
        $this->assertEquals('1234', $cart->getHMAC());
    }
}
