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

require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'tests'.DIRECTORY_SEPARATOR.'bootstrap.php';
require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Config.php';

use ApaiIO\ApaiIO;
use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\CartAdd;
use ApaiIO\Operations\CartCreate;

$conf = new GenericConfiguration();
$client = new \GuzzleHttp\Client();
$request = new \ApaiIO\Request\GuzzleRequest($client);

try {
    $conf
        ->setCountry('de')
        ->setAccessKey(AWS_API_KEY)
        ->setSecretKey(AWS_API_SECRET_KEY)
        ->setAssociateTag(AWS_ASSOCIATE_TAG)
        ->setRequest($request);
} catch (\Exception $e) {
    echo $e->getMessage();
}
$apaiIO = new ApaiIO($conf);

$cartCreate = new CartCreate();
$cartCreate->addItem("B0040PBK32", 1);

$formattedResponse = $apaiIO->runOperation($cartCreate);

echo $formattedResponse;

echo "<hr>";

$cartAdd = new CartAdd();
$cartAdd->setCartId('280-6695255-7497359');
$cartAdd->setHMAC('LxQ0BKVBeQTrzFCXvIoa/262EcU=');
$cartAdd->addItem('B003YL444A', 1);

$formattedResponse = $apaiIO->runOperation($cartAdd);

echo $formattedResponse;
