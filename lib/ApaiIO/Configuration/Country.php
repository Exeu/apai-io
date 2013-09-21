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

/**
 * Countryvalidation and countrylistings according to the amazonapi
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
final class Country
{
    /**
     * Possible countries
     * Important for the requestendpoints
     *
     * @var array
     */
    private static $countryList = array('de', 'com', 'co.uk', 'ca', 'fr', 'co.jp', 'it', 'cn', 'es', 'in');

    /**
     * Gets all possible countries
     *
     * @return array
     */
    public static function getCountries()
    {
        return self::$countryList;
    }

    /**
     * Checks if the given value is a valid country
     *
     * @param string $country
     * @param string $exception false = throw no exception true = throw an exception
     *
     * @return boolean
     */
    public static function isValidCountry($country, $exception = true)
    {
        $isValid = in_array(strtolower($country), self::$countryList) ? true : false;

        if (true === $exception && false === $isValid) {
            throw new \InvalidArgumentException(sprintf(
                "Invalid Country-Code: %s! Possible Country-Codes: %s",
                $country,
                implode(', ', self::$countryList)
            ));
        }

        return $isValid;
    }
}
