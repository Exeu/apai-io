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
 * A similarity lookup operation
 *
 * @see    http://docs.aws.amazon.com/AWSECommerceService/2011-08-01/DG/SimilarityLookup.html
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class SimilarityLookup extends AbstractOperation
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'SimilarityLookup';
    }

    /**
     * Sets the itemid which has to be looked up
     * Basicly it is an amazon asin
     *
     * @param string $itemId
     *
     * @return \ApaiIO\Operations\SimilarityLookup
     */
    public function setItemId($itemId)
    {
        $this->parameter['ItemId'] = $itemId;

        return $this;
    }
}
