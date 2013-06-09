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

namespace ApaiIO\Operations;

/**
 * A cart create operation
 *
 * @see    http://docs.aws.amazon.com/AWSECommerceService/2011-08-01/DG/CartCreate.html
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class CartCreate extends AbstractOperation
{
    private $itemCounter = 1;

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'CartCreate';
    }

    /**
     * Adds an item to the Cart
     *
     * @param string  $asin     The ASIN Number of the item
     * @param integer $quantity How much you want to add
     */
    public function addItem($asin, $quantity)
    {
        $this->parameter['Item.'.$this->itemCounter.'.ASIN'] = $asin;
        $this->parameter['Item.'.$this->itemCounter.'.Quantity'] = $quantity;

        $this->itemCounter++;
    }
}
