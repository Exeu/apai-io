.. index::
    single: Basic usage

Basic usage
===========

Making your first request
-------------------------

After the installation you can use apai-io out of the box.

This guide expects that you use an autoloader in your project!

Creating your configuration
First of all you have to create a new configuration object. Apai-IO has one built in configuration class which can be used in nearly every project. Its called GenericConfiguration.

.. code-block:: php

    use ApaiIO\Configuration\GenericConfiguration;

    $client = new \GuzzleHttp\Client();
    $request = new \ApaiIO\Request\GuzzleRequest($client);

    $conf = new GenericConfiguration();
    $conf
        ->setCountry('com')
        ->setAccessKey('YOUR ACCESS KEY')
        ->setSecretKey('YOUR SECRET KEY')
        ->setAssociateTag('YOUR ASSOCIATE TAG')
        ->setRequest($request);

You have to set the country, accesskey, secretkey and your associate tag using the setter functions of the GenericConfiguration class.

How to get your accesskey, secretkey and associate tag is documented here: http://docs.aws.amazon.com/AWSECommerceService/latest/DG/becomingAssociate.html

The country could be one of the following: **de, com, co.uk, ca, fr, co.jp, it, cn, es, in, com.br, com.mx, com.au**

For example if you set this to de you will send your requests to the german amazon database (www.amazon.de)

Creating your operation
After setting up the configuration, you can go to the next step and create your operation.

In the following example we take the ItemSearch operation: http://docs.aws.amazon.com/AWSECommerceService/latest/DG/ItemSearch.html

.. code-block:: php

    use ApaiIO\Operations\Search;

    $search = new Search();
    $search->setCategory('DVD');
    $search->setActor('Bruce Willis');
    $search->setKeywords('Die Hard');

Now you have your first operation configured. It searches the DVD-Index, looking for the actor Bruce Willis and for the keywords Die Hard.

There are magic setter functions within this class. You can set additional parameters of your choice! What parameters are possible see the link above.

For example you can set the condition of the item to used:

.. code-block:: php

    $search->setCondition('used');

Making the request
The next step is to make the request:


.. code-block:: php

    use ApaiIO\ApaiIO;

    $apaiIo = new ApaiIO($conf);
    $response = $apaiIo->runOperation($search);

    var_dump($response);

If everything worked fine and your configuration (accesskey, secretkey, associatetag) was correct, you will get a xml response as string.

The full example

.. code-block:: php

    use ApaiIO\Configuration\GenericConfiguration;
    use ApaiIO\Operations\Search;
    use ApaiIO\ApaiIO;

    $client = new \GuzzleHttp\Client();
    $request = new \ApaiIO\Request\GuzzleRequest($client);

    $conf = new GenericConfiguration();
    $conf
        ->setCountry('com')
        ->setAccessKey('YOUR ACCESS KEY')
        ->setSecretKey('YOUR SECRET KEY')
        ->setAssociateTag('YOUR ASSOCIATE TAG')
        ->setRequest($request);

    $search = new Search();
    $search->setCategory('DVD');
    $search->setActor('Bruce Willis');
    $search->setKeywords('Die Hard');

    $apaiIo = new ApaiIO($conf);
    $response = $apaiIo->runOperation($search);

    var_dump($response);
