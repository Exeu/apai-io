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

namespace ApaiIO\Configuration;

use ApaiIO\Configuration\Country;

class GenericConfiguration implements ConfigurationInterface
{
    protected $country;

    protected $accessKey;

    protected $secretKey;

    protected $associateTag;

    /**
     * Set or get the country
     *
     * if the country argument is null it will return the current
     * country, otherwise it will set the country and return itself.
     *
     * @param string|null $country
     *
     * @return string|GenericConfiguration depends on country argument
     */
    public function country($country = null)
    {
        if (null === $country) {
            return $this->country;
        }

        Country::isValidCountry($country);

        $this->country = strtolower($country);

        return $this;
    }

    /**
     * Setter/Getter of the AssociateTag.
     * This could be used for late bindings of this attribute
     *
     * @param string $associateTag
     *
     * @return string|GenericConfiguration depends on associateTag argument
     */
    public function associateTag($associateTag = null)
    {
        if (null === $associateTag) {
            return $this->associateTag;
        }

        $this->associateTag = $associateTag;

        return $this;
    }

    /**
     * Setter/Getter of the AssociateTag.
     * This could be used for late bindings of this attribute
     *
     * @param string $associateTag
     *
     * @return string|GenericConfiguration depends on associateTag argument
     */
    public function accessKey($accessKey = null)
    {
        if (null === $accessKey) {
            return $this->accessKey;
        }

        $this->accessKey = $accessKey;

        return $this;
    }

    /**
     * Setter/Getter of the AssociateTag.
     * This could be used for late bindings of this attribute
     *
     * @param string $associateTag
     *
     * @return string|GenericConfiguration depends on associateTag argument
     */
    public function secretKey($secretKey = null)
    {
        if (null === $secretKey) {
            return $this->secretKey;
        }

        $this->secretKey = $secretKey;

        return $this;
    }
}