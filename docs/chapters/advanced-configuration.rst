Advanced configuration
======================

RequestFactory Callbacks
------------------------

Since version 1.3 you are able to set up a callback with the configuration which is called before the internal request factory returns a new requestobject.

With this change you can manipulate the requestobject easily.

.. code-block:: php

    use ApaiIO\Configuration\GenericConfiguration;
    use ApaiIO\Operations\Search;
    use ApaiIO\ApaiIO;

    $conf = new GenericConfiguration();
    $conf
        ->setCountry('com')
        ->setAccessKey('YOUR ACCESS KEY')
        ->setSecretKey('YOUR SECRET KEY')
        ->setAssociateTag('YOUR ASSOCIATE TAG')
        ->setRequestFactory(
            function($request) {
                // do what ever you want
                return $request;
            }
        );

    $search = new Search();
    $search->setCategory('DVD');
    $search->setActor('Bruce Willis');
    $search->setKeywords('Die Hard');

    $apaiIo = new ApaiIO($conf);
    $response = $apaiIo->runOperation($search);

    var_dump($response);

ResponseTransformerFactory Callbacks
------------------------------------

Since version 1.3 you are able to set up a callback with the configuration which is called before the internal responsetransformer factory returns a new responsetransformerobject.

With this change you can manipulate the responsetransformerobject easily.

.. code-block:: php

    use ApaiIO\Configuration\GenericConfiguration;
    use ApaiIO\Operations\Search;
    use ApaiIO\ApaiIO;

    $conf = new GenericConfiguration();
    $conf
        ->setCountry('com')
        ->setAccessKey('YOUR ACCESS KEY')
        ->setSecretKey('YOUR SECRET KEY')
        ->setAssociateTag('YOUR ASSOCIATE TAG')
        ->setResponseTransformerFactory(
            function($responseTransformer) {
                // do what ever you want
                return $responseTransformer;
            }
        );

    $search = new Search();
    $search->setCategory('DVD');
    $search->setActor('Bruce Willis');
    $search->setKeywords('Die Hard');

    $apaiIo = new ApaiIO($conf);
    $response = $apaiIo->runOperation($search);

    var_dump($response);