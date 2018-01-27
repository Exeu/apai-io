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

namespace ApaiIO\Configuration;

/**
 * Country validation and country listings according to the amazon api
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
final class Country
{
    const AMERICA = 'com';
    const AUSTRALIA = 'com.au';
    const BRAZIL = 'com.br';
    const CANADA = 'ca';
    const CHINA = 'cn';
    const FRANCE = 'fr';
    const GERMANY = 'de';
    const INDIA = 'in';
    const ITALY = 'it';
    const JAPAN = 'co.jp';
    const MEXICO = 'com.mx';
    const SPAIN = 'es';
    const UNITED_KINGDOM = 'co.uk';

    /**
     * Possible countries
     * Important for the request endpoints
     *
     * @var array
     */
    private static $countryList = [
        'de',
        'com',
        'co.uk',
        'ca',
        'fr',
        'co.jp',
        'it',
        'cn',
        'es',
        'in',
        'com.br',
        'com.mx',
        'com.au'
    ];

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
     * @param string  $country
     *
     * @return boolean
     */
    public static function isValidCountry($country)
    {
        return in_array(strtolower($country), self::$countryList);
    }
}
