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
 * A item lookup operation
 *
 * @see    http://docs.aws.amazon.com/AWSECommerceService/2011-08-01/DG/ItemLookup.html
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class Lookup extends AbstractOperation
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ItemLookup';
    }

    /**
     * Sets the itemid which should be looked up
     *
     * @param string $itemId
     *
     * @return \ApaiIO\Operations\Lookup
     */
    public function setItemId($itemId)
    {
        $this->parameter['ItemId'] = $itemId;

        return $this;
    }
}
