<?php
require_once 'autoloader.php';
require_once 'Config.php';

use ApaiIO\Request\RequestFactory;
use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Search;
use ApaiIO\Response\ObjectToArray;
use ApaiIO\Operations\Lookup;
use ApaiIO\Operations\SimilarityLookup;
use ApaiIO\Operations\CartCreate;

$conf = new GenericConfiguration();

try {
    $conf
        ->country('de')
        ->accessKey(AWS_API_KEY)
        ->secretKey(AWS_API_SECRET_KEY)
        ->associateTag(AWS_ASSOCIATE_TAG);
} catch (\Exception $e) {
    echo $e->getMessage();
}

$soapRequest = RequestFactory::createSoapRequest($conf);

$search = new Search();
$search->setCategory('DVD');
$search->setActor('Bruce Willis');
$search->setKeywords('Stirb Langsam');
$search->setItemPage(3);

echo "<pre>";

$response = new ObjectToArray();

$formattedResponse = $response->transform($soapRequest->perform($search));

$lookup = new Lookup();
$lookup->setItemId('B0040PBK32');
$lookup->responseGroup(array('Large', 'Small'));

$formattedResponse = $response->transform($soapRequest->perform($lookup));


$lookup = new SimilarityLookup();
$lookup->setItemId('B0040PBK32');
$lookup->responseGroup(array('Large', 'Small'));

$formattedResponse = $response->transform($soapRequest->perform($lookup));

$cart = new CartCreate();
$cart->addItem('B0040PBK32', 1);

$response = $soapRequest->perform($cart);

var_dump($response);