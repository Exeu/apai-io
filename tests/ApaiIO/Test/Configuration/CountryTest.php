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

namespace ApaiIO\Test\Configuration;

use ApaiIO\Configuration\Country;

class CountryTest extends \PHPUnit_Framework_TestCase
{
    public function testCountryList()
    {
        $this->assertEquals(
            ['com.au', 'com.br', 'ca', 'cn', 'fr', 'de', 'in', 'com', 'it', 'co.jp', 'com.mx', 'es', 'co.uk'],
            Country::getCountries()
        );
    }

    public function testUnvalidCountry()
    {
        $this->assertFalse(Country::isValidCountry(__METHOD__));
    }

    public function testValidCountry()
    {
        $this->assertTrue(Country::isValidCountry('com'));
        $this->assertTrue(Country::isValidCountry(Country::INTERNATIONAL));
        $this->assertTrue(Country::isValidCountry(Country::AUSTRALIA));
        $this->assertTrue(Country::isValidCountry(Country::BRAZIL));
        $this->assertTrue(Country::isValidCountry(Country::CANADA));
        $this->assertTrue(Country::isValidCountry(Country::CHINA));
        $this->assertTrue(Country::isValidCountry(Country::FRANCE));
        $this->assertTrue(Country::isValidCountry(Country::GERMANY));
        $this->assertTrue(Country::isValidCountry(Country::INDIA));
        $this->assertTrue(Country::isValidCountry(Country::ITALY));
        $this->assertTrue(Country::isValidCountry(Country::JAPAN));
        $this->assertTrue(Country::isValidCountry(Country::MEXICO));
        $this->assertTrue(Country::isValidCountry(Country::SPAIN));
        $this->assertTrue(Country::isValidCountry(Country::UNITED_KINGDOM));
    }
}
