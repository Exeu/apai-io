#apai-io

ApaiIO is a highly flexible PHP library for fetching the Product Advertising API using REST or SOAP.
You can either use the built in operations like ItemSearch or ItemLookup or you can implement your own operations which fits to your needs.

Everything is programmed against interfaces so you can implement your own request or response classes for example.

##Basic Usage:
This library is using the PSR-0 standrad: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md
So you can use any autoloader which fits into this standard.
The tests directory contains an example bootstrap file.

``` php
<?php
namespace Acme\Demo;

use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Search;
use ApaiIO\ApaiIO;

$conf
    ->setCountry('com')
    ->setAccessKey(AWS_API_KEY)
    ->setSecretKey(AWS_API_SECRET_KEY)
    ->setAssociateTag(AWS_ASSOCIATE_TAG);

$apaiIO = new ApaiIO($conf);

$search = new Search();
$search->setCategory('DVD');
$search->setActor('Bruce Willis');
$search->setKeywords('Die Hard');

$formattedResponse = $apaiIO->runOperation($search);

var_dump($formattedResponse);
```

For some very simple examples go to the samples-folder and have a look at the sample files.
These files contain all information you need for building queries successful.

##Webservice Documentation:
Hosted on Amazon.com:
http://docs.amazonwebservices.com/AWSECommerceService/latest/DG/
