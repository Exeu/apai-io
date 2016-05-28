Installation
============

Install via Composer
--------------------
The easiest way to install apai-io is to use the PHP dependency management tool composer.
First you have to add a file named composer.json to your project root
Edit this composer.json and add the following content to it

.. code-block:: json

    {
        "require": {
            "exeu/apai-io": "~2.0"
        }
    }

Now you have to download composer:

.. code-block:: bash

    $ curl -sS https://getcomposer.org/installer | php

Note that there are other ways to get composer. Please read the guide: http://getcomposer.org/download/

After composer is downloaded you can run the following command:

.. code-block:: bash

    $ php composer.phar install


After the installation succeeded, composer created a vendor dir where the library is placed and a additional autoload.php which you can include.

For example - create a index.php and add the following:

.. code-block:: php

    require_once "vendor/autoload.php";

    use ApaiIO\Configuration\GenericConfiguration;
    use ApaiIO\ApaiIO;

    $conf = new GenericConfiguration();
    $client = new \GuzzleHttp\Client();
    $request = new \ApaiIO\Request\GuzzleRequest($client);

    $conf
        ->setCountry('com')
        ->setAccessKey('YOUR ACCESS KEY')
        ->setSecretKey('YOUR SECRET KEY')
        ->setAssociateTag('YOUR ASSOCIATE TAG')
        ->setRequest($request);

    $apaiIo = new ApaiIO($conf);

Now your done and ready to use apai-io. See Basic usage
