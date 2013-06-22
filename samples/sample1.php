<?php
require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'tests'.DIRECTORY_SEPARATOR.'bootstrap.php';
require_once 'Config.php';

use ApaiIO\Request\RequestFactory;
use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Search;
use ApaiIO\Response\ObjectToArray;
use ApaiIO\Operations\Lookup;
use ApaiIO\Operations\SimilarityLookup;
use ApaiIO\Operations\CartCreate;
use ApaiIO\ApaiIO;
use ApaiIO\Operations\BrowseNodeLookup;
use ApaiIO\Operations\CartAdd;

$conf = new GenericConfiguration();

try {
    $conf
        ->setCountry('de')
        ->setAccessKey(AWS_API_KEY)
        ->setSecretKey(AWS_API_SECRET_KEY)
        ->setAssociateTag(AWS_ASSOCIATE_TAG);
} catch (\Exception $e) {
    echo $e->getMessage();
}
$apaiIO = new ApaiIO($conf);

$search = new Search();
$search->setCategory('DVD');
$search->setActor('Bruce Willis');
$search->setKeywords('Stirb Langsam');
$search->setPage(3);
$search->setResponseGroup(array('Large', 'Small'));

$formattedResponse = $apaiIO->runOperation($search);

// var_dump($formattedResponse);

// $cartCreate = new CartCreate();
// $cartCreate->addItem("B0040PBK32", 1);

// $formattedResponse = $apaiIO->runOperation($cartCreate);

// $cartAdd = new CartAdd();
// $cartAdd->setCartId('280-6695255-7497359');
// $cartAdd->setHMAC('LxQ0BKVBeQTrzFCXvIoa/262EcU=');
// $cartAdd->addItem('B003YL444A', 1);

// $formattedResponse = $apaiIO->runOperation($cartAdd);

// var_dump($formattedResponse);

$conf->setResponseTransformer('\ApaiIO\ResponseTransformer\XmlToDomDocument');

$lookup = new Lookup();
$lookup->setItemId('B0040PBK32');
$lookup->setResponseGroup(array('Large', 'Small'));

$formattedResponse = $apaiIO->runOperation($lookup, $configuration);

//var_dump($formattedResponse);

$lookup = new SimilarityLookup();
$lookup->setItemId('B0040PBK32');
$lookup->setResponseGroup(array('Large', 'Small'));

$formattedResponse = $apaiIO->runOperation($lookup);

$conf->setRequest('\ApaiIO\Request\Soap\Request');
$conf->setResponseTransformer('\ApaiIO\ResponseTransformer\ObjectToArray');

$lookup = new SimilarityLookup();
$lookup->setItemId('B0040PBK32');
$lookup->setResponseGroup(array('Large', 'Small'));

$formattedResponse = $apaiIO->runOperation($lookup, $conf);

//var_dump($formattedResponse);

$conf->setResponseTransformer(new \ApaiIO\ResponseTransformer\ObjectToArray());
$browseNodeLookup = new BrowseNodeLookup();
$browseNodeLookup->setNodeId(542064);

$formattedResponse = $apaiIO->runOperation($browseNodeLookup, $configuration);

var_dump($formattedResponse);
