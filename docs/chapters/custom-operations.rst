Creating custom operations
==========================

If the built in operations are note enough, you can build your own operations.

For example if you want to add your own custom logic to the operation like validation or more special getter and setter.

apai-io accepts every operation class which implements the following interface:

.. code-block:: php

    ApaiIO\Operations\OperationInterface
    namespace ApaiIO\Operations;

    interface OperationInterface
    {
        public function getName();

        public function setResponseGroup(array $responseGroup);

        public function getOperationParameter();
    }

Lets build a custom ItemSearch class
------------------------------------
The class
_________

.. code-block:: php

    namespace Acme\MyApp;

    use ApaiIO\Operations\OperationInterface;

    class SimpleKeywordSearch implements OperationInterface
    {
        private $operationParameter = array(
            'ResponseGroup' => 'Large',
            'SearchIndex' => 'Blended'
        );

        public function getName()
        {
            return "ItemSearch"; // Amazon operation name
        }

        public function setResponseGroup($responseGroup)
        {
            $this->operationParameter['ResponseGroup'] = $responseGroup;
        }

        public function getOperationParameter()
        {
            return $this->operationParameter;
        }

        public function setKeywords($keywords)
        {
            $this->operationParameter['Keywords'] = $keywords;
        }

        public function setCategory($category)
        {
            $this->parameter['SearchIndex'] = $category;
        }
    }

Running the operation
_____________________

.. code-block:: php

    use Acme\MyApp\SimpleKeywordSearch;

    $simpleKeywordSearch = new SimpleKeywordSearch();
    $simpleKeywordSearch->setKeywords("Bruce Willis, Die Hard");

    $response = $apaiIo->runOperation($simpleKeywordSearch);