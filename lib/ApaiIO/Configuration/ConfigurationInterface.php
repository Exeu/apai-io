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

interface ConfigurationInterface
{
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
    function country($country);

    /**
     * Setter/Getter of the AssociateTag.
     * This could be used for late bindings of this attribute
     *
     * @param string $associateTag
     *
     * @return string|GenericConfiguration depends on associateTag argument
     */
    function associateTag($associateTag);

    /**
     * Setter/Getter of the AssociateTag.
     * This could be used for late bindings of this attribute
     *
     * @param string $associateTag
     *
     * @return string|GenericConfiguration depends on associateTag argument
     */
    function accessKey($accessKey);

    /**
     * Setter/Getter of the AssociateTag.
     * This could be used for late bindings of this attribute
     *
     * @param string $associateTag
     *
     * @return string|GenericConfiguration depends on associateTag argument
     */
    function secretKey($secretKey);
}