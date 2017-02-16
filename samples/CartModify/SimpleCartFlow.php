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

require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'tests'.DIRECTORY_SEPARATOR.'bootstrap.php';
require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Config.php';

use ApaiIO\ApaiIO;
use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\CartAdd;
use ApaiIO\Operations\CartCreate;
use ApaiIO\Operations\CartModify;

$conf = new GenericConfiguration();
$client = new \GuzzleHttp\Client();
$request = new \ApaiIO\Request\GuzzleRequest($client);

try {
    $conf
        ->setCountry('de')
        ->setAccessKey(AWS_API_KEY)
        ->setSecretKey(AWS_API_SECRET_KEY)
        ->setAssociateTag(AWS_ASSOCIATE_TAG)
        ->setRequest($request)
        ->setResponseTransformer(new \ApaiIO\ResponseTransformer\XmlToDomDocument());
} catch (\Exception $e) {
    echo $e->getMessage();
}
$apaiIO = new ApaiIO($conf);

$cartCreate = new CartCreate();
$cartCreate->addItem('B01K4T7UR2', 1);
$cartCreate->setResponseGroup(['Cart']); // <-- IMPORTANT! Always be precise with ResponseGroup
                                         //                to avoid getting preliminary RateLimit

$domDoc = $apaiIO->runOperation($cartCreate);

$hmac       = $domDoc->documentElement->getElementsByTagName('HMAC')->item(0)->nodeValue;
$cartId     = $domDoc->documentElement->getElementsByTagName('CartId')->item(0)->nodeValue;
$subTotal   = $domDoc->documentElement->getElementsByTagName('FormattedPrice')->item(0)->nodeValue;
$subTotal2  = $domDoc->documentElement->getElementsByTagName('Amount')->item(0)->nodeValue;
$size       = $domDoc->documentElement->getElementsByTagName('CartItem')->length;

$cartAdd = new CartAdd();
$cartAdd->setCartId($cartId);
$cartAdd->setHMAC($hmac);
$cartAdd->addItem('B00125D3QK', 1);
$cartAdd->setResponseGroup(['Cart']);   // <-- IMPORTANT! Always be precise with ResponseGroup
                                        //                to avoid getting preliminary RateLimit

$domDoc = $apaiIO->runOperation($cartAdd);

$cartItemId1 = $domDoc->documentElement->getElementsByTagName('CartItemId')->item(0)->nodeValue;
$cartItemId2 = $domDoc->documentElement->getElementsByTagName('CartItemId')->item(1)->nodeValue;
$subTotal    = $domDoc->documentElement->getElementsByTagName('FormattedPrice')->item(0)->nodeValue;
$subTotal2   = $domDoc->documentElement->getElementsByTagName('Amount')->item(0)->nodeValue;
$size        = $domDoc->documentElement->getElementsByTagName('CartItem')->length;

$cartModify = new CartModify();
$cartModify->setCartId($cartId);
$cartModify->setHMAC($hmac);
$cartModify->modifyQuantity($cartItemId1, 4);
//$cartModify->modifyQuantity($cartItemId2, 2);
$cartModify->modifyAction($cartItemId2, 'SaveForLater');
$cartModify->setResponseGroup(['Cart']);

$domDoc = $apaiIO->runOperation($cartModify);   // <-- IMPORTANT! Always be precise with ResponseGroup
                                                //                to avoid getting preliminary RateLimit

$subTotal    = $domDoc->documentElement->getElementsByTagName('FormattedPrice')->item(0)->nodeValue;
$subTotal2   = $domDoc->documentElement->getElementsByTagName('Amount')->item(0)->nodeValue;
$size        = $domDoc->documentElement->getElementsByTagName('CartItem')->length;
$checkoutUrl = $domDoc->documentElement->getElementsByTagName('PurchaseURL')->item(0)->nodeValue;