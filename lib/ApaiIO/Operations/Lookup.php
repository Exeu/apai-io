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
    const TYPE_ASIN = 'ASIN';
    const TYPE_SKU = 'SKU';
    const TYPE_UPC = 'UPC';
    const TYPE_EAN = 'EAN';
    const TYPE_ISBN = 'ISBN';

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

    /**
     * Sets the idtype either ASIN (Default), SKU, UPC, EAN, and ISBN
     *
     * @param string $idType
     *
     * @return \ApaiIO\Operations\Lookup
     */
    public function setIdType($idType)
    {
        $idTypes = array(
            self::TYPE_ASIN,
            self::TYPE_SKU,
            self::TYPE_UPC,
            self::TYPE_EAN,
            self::TYPE_ISBN
        );

        if (!in_array($idType, $idTypes)) {
            throw new \InvalidArgumentException(sprintf(
                "Invalid type '%s' passed. Valid types are: '%s'",
                $idType,
                implode(', ', $idTypes)
            ));
        }

        $this->parameter['IdType'] = $idType;

        if (empty($this->parameter['SearchIndex'])) {
            $this->parameter['SearchIndex'] = 'All';
        }

        return $this;
    }

    /**
     * Sets the searchindex which should be used when set IdType other than ASIN
     *
     * @param string $searchIndex
     *
     * @return \ApaiIO\Operations\Lookup
     */
    public function setSearchIndex($searchIndex)
    {
        $this->parameter['SearchIndex'] = $searchIndex;

        return $this;
    }
}
