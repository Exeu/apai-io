<?php
/*
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
 * A cart modify operation
 *
 * @see http://docs.aws.amazon.com/AWSECommerceService/latest/DG/CartModify.html
 */
class CartModify extends AbstractOperation implements \Countable
{
    private $itemCounter = 1;

    const ITEM_LIMIT = 10;

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'CartModify';
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

    /**
     * Changes quantity of a CartItem
     *
     * @param string  $cartItemId The CartItemId retrieved from CartCreate | CartAdd result
     * @param integer $quantity   How many items should be in cart after modification
     *
     * @return $this
     *
     * @throws \OverflowException        if more then self::ITEM_LIMIT items are to be modified
     * @throws \InvalidArgumentException if $quantity is not an integer
     * @throws \OutOfRangeException      if $quantity is not in the allowed range: 0 <= $quantity <= 999
     */
    public function modifyQuantity($cartItemId, $quantity)
    {
        $this->validateModificationCount();
        $this->validateQuantity($quantity);

        $this->parameters['Item.' . $this->itemCounter . '.CartItemId'] = $cartItemId;
        $this->parameters['Item.' . $this->itemCounter . '.Quantity']   = $quantity;

        $this->itemCounter++;

        return $this;
    }

    /**
     * Changes an action of CartIteam to move between Cart and SaveForLater lists
     *
     * @param string $cartItemId The CartItemId retrieved from CartCreate | CartAdd result
     * @param string $action     Valid Values: MoveToCart | SaveForLater
     *
     * @return $this
     *
     * @throws \OutOfRangeException if more then self::ITEM_LIMIT items are to be modified
     */
    public function modifyAction($cartItemId, $action)
    {
        $this->validateModificationCount();
        $this->validateAction($action);

        $this->parameters['Item.' . $this->itemCounter . '.CartItemId'] = $cartItemId;
        $this->parameters['Item.' . $this->itemCounter . '.Action']     = $action;

        $this->itemCounter++;

        return $this;
    }

    /**
     * Counts cart modification for this operation
     *
     * @link  http://php.net/manual/en/countable.count.php
     * @return int The number of modifications for this operations
     *
     * @since 5.1.0
     */
    public function count()
    {
        return $this->itemCounter - 1;
    }

    /**
     * @param integer $quantity
     */
    private function validateQuantity($quantity)
    {
        if (false === is_int($quantity)) {
            throw new \InvalidArgumentException(
                sprintf('quantity must be integer, %s given', gettype($quantity))
            );
        }

        if ($quantity < 0 || $quantity > 999) {
            throw new \OutOfRangeException(
                sprintf('%s is an invalid quantity value. It has to be numeric and between 0 and 999', $quantity)
            );
        }
    }

    /**
     * Validates ActionTypes
     *
     * @param string $action
     */
    private function validateAction($action)
    {
        switch ($action) {
            case 'MoveToCart':
            case 'SaveForLater':
                return;
            default:
                throw new \OutOfRangeException(
                    sprintf('%s is not a valid action. Must be one of: MoveToCart, SaveForLater', $action)
                );
        }
    }

    /**
     * Validates maximum request size
     */
    private function validateModificationCount()
    {
        if (count($this) >= self::ITEM_LIMIT) {
            throw new \OverflowException(
                sprintf('You must not do more than %d modifications per request', self::ITEM_LIMIT)
            );
        }
    }
}
