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

namespace ApaiIO\Operations;

/**
 * A cart add operation
 *
 * @see    http://docs.aws.amazon.com/AWSECommerceService/2011-08-01/DG/CartAdd.html
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class CartAdd extends CartCreate
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'CartAdd';
    }

    /**
     * Returns the cart id
     *
     * @return string
     */
    public function getCartId()
    {
        return $this->getSingleOperationParameter('CartId');
    }

    /**
     * Sets the cart id
     *
     * @param string $cartId
     */
    public function setCartId($cartId)
    {
        $this->parameters['CartId'] = $cartId;
    }

    /**
     * Returns the HMAC
     *
     * @return mixed
     */
    public function getHMAC()
    {
        return $this->getSingleOperationParameter('HMAC');
    }

    /**
     * Sets the HMAC
     *
     * @param string $HMAC
     */
    public function setHMAC($HMAC)
    {
        $this->parameters['HMAC'] = $HMAC;
    }
}
