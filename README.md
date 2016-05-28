#apai-io
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Exeu/apai-io/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Exeu/apai-io/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/Exeu/apai-io/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Exeu/apai-io/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/Exeu/apai-io/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Exeu/apai-io/build-status/master)
[![Latest Stable Version](https://poser.pugx.org/exeu/apai-io/v/stable.svg)](https://packagist.org/packages/exeu/apai-io) [![Total Downloads](https://poser.pugx.org/exeu/apai-io/downloads.svg)](https://packagist.org/packages/exeu/apai-io)
[![Build Status](https://travis-ci.org/Exeu/apai-io.png?branch=master)](https://travis-ci.org/Exeu/apai-io)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/9b802be9-541d-4008-b56c-9c9f5baece8b/mini.png)](https://insight.sensiolabs.com/projects/9b802be9-541d-4008-b56c-9c9f5baece8b)

ApaiIO is a highly flexible PHP library for fetching the Product Advertising API using REST or SOAP.
You can either use the built in operations like ItemSearch or ItemLookup or you can implement your own operations which fits to your needs.

Everything is programmed against interfaces so you can implement your own request or response classes for example.

This class is realized by the Product Advertising API (former ECS) from Amazon WS Front. https://affiliate-program.amazon.com/gp/advertising/api/detail/main.html

You can try it out with the new demo site: http://apaiio.dev.pixel-web.org/

## Documentation

The documentation is currently under construction.

You can read here: http://docs.pixel-web.org/apai-io/master/

## Installation

### Composer

Add apai-io in your composer.json or create a new composer.json:

```js
{
    "require": {
        "exeu/apai-io": "~2.0"
    }
}
```

Now tell composer to download the library by running the command:

``` bash
$ php composer.phar install
```

Composer will generate the autoloader file automaticly. So you only have to include this.
Typically its located in the vendor dir and its called autoload.php

##Basic Usage:
This library is using the PSR-0 standard: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md
So you can use any autoloader which fits into this standard.
The tests directory contains an example bootstrap file.

``` php
<?php
namespace Acme\Demo;

use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Search;
use ApaiIO\ApaiIO;

$conf = new GenericConfiguration();
$client = new \GuzzleHttp\Client();
$request = new \ApaiIO\Request\GuzzleRequest($client);

$conf
    ->setCountry('com')
    ->setAccessKey(AWS_API_KEY)
    ->setSecretKey(AWS_API_SECRET_KEY)
    ->setAssociateTag(AWS_ASSOCIATE_TAG)
    ->setRequest($request);
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
