Built in operations
===================
apai-io comes with some built in operations.

ItemSeach
---------
The ItemSearch can be used to search products in the amazon database.

Please see the following documentation for more information.

Finding movies with "Bruce Willis" and keywords like "Die Hard"

.. code-block:: php

    use ApaiIO\Operations\Search;

    $search = new Search();
    $search->setCategory('DVD');
    $search->setActor('Bruce Willis');
    $search->setKeywords('Die Hard');
    $search->setResponsegroup(array('Large', 'Images'));

    $response = $apaiIo->runOperation($search);

Finding books "lord of the rings" and the condition "used"

.. code-block:: php

    use ApaiIO\Operations\Search;

    $search = new Search();
    $search->setCategory('Books');
    $search->setKeywords('lord of the rings');
    $search->setCondition('used');

    $response = $apaiIo->runOperation($search);

ItemLookup
----------

The ItemLookup can be used to lookup a product in the amazon database.

Please see the following documentation for more information.

Getting the item with asin "B00D6BN9NK" -> link

.. code-block:: php

    use ApaiIO\Operations\Lookup;

    $lookup = new Lookup();
    $lookup->setItemId('B00D6BN9NK');
    $lookup->setResponseGroup(array('Large')); // More detailed information

    $response = $apaiIo->runOperation($lookup);

SimilarityLookup
----------------

The SimilarityLookup can be used to lookup similar products of the given asin in the amazon database.

Please see the following documentation for more information.

Getting similar products to asin "B00D6BN9NK" -> link

.. code-block:: php

    use ApaiIO\Operations\SimilarityLookup;

    $similaritylookup = new SimilarityLookup();
    $similaritylookup->setItemId('B00D6BN9NK');

    $response = $apaiIo->runOperation($similaritylookup);

BrowseNodeLookup
----------------

The BrowseNodeLookup can be used to browse the amazon product nodes.

Please see the following documentation for more information.

Browsing the node "163357" (Comedy)

.. code-block:: php

    use ApaiIO\Operations\BrowseNodeLookup;

    $browseNodeLookup = new BrowseNodeLookup();
    $browseNodeLookup->setNodeId(163357);

    $response = $apaiIo->runOperation($browseNodeLookup);