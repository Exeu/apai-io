#apai-io

ApaiIO is a highly flexible PHP library for fetching the Product Advertising API using REST or SOAP.
You can either use the built in operations like ItemSearch or ItemLookup or you can implement your own operations which fits to your needs.

Everything is programmed against interfaces so you can implement your own request or response classes for example.

This class is realized by the Product Advertising API (former ECS) from Amazon WS Front. https://affiliate-program.amazon.com/gp/advertising/api/detail/main.html

You can try it out with the new demo site: http://apaiio.dev.pixel-web.org/

## Documentation

The documentation is currently under construction.

You can read here: http://apai-io.pixel-web.org

## Build status

[![Build Status](http://ci.pixel-web.org/job/ApaiIO/badge/icon)](http://ci.pixel-web.org/job/ApaiIO/)

[![Build Status](https://travis-ci.org/Exeu/apai-io.png?branch=master)](https://travis-ci.org/Exeu/apai-io)

## Installation

### Composer

Add apai-io in your composer.json or create a new composer.json:

```js
{
    "require": {
        "exeu/apai-io": "dev-master"
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
