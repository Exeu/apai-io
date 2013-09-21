<?php
use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\ApaiIO;
use ApaiIO\Operations\Search;
use ApaiIO\ResponseTransformer\ObjectToArray;

/*
 * Copyright 2013 Jan Eichhorn <exeu65@googlemail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

class RestRequestTest extends \PHPUnit_Framework_TestCase
{
    private $accessKey = null;
    private $secretKey = null;
    private $conf = null;

    protected function setUp()
    {
        $this->secretKey = getenv('APAI_IO_SECRETKEY');
        $this->accessKey = getenv('APAI_IO_ACCESSKEY');

        if (true === empty($this->secretKey) || true === empty($this->accessKey )) {
            $this->markTestSkipped('No AccessKey/SecretKey ENVs');
        }

        $this->conf = new GenericConfiguration();
        $this->conf
            ->setCountry('de')
            ->setAccessKey($this->accessKey)
            ->setSecretKey($this->secretKey)
            ->setAssociateTag('apaiIOTest');
    }

    public function testRestSuccessRequest()
    {
        $search = new Search();
        $search
            ->setKeywords('Bruce Willis')
            ->setCategory('DVD')
            ->setPage(2);

        $xml = $this->runOperation($search);
        $res = $xml->xpath('//a:Request');

        $success = (string) $res[0]->IsValid;
        $this->assertEquals("True", $success);

        $this->assertEquals('Bruce Willis', (string) $res[0]->ItemSearchRequest->Keywords);
        $this->assertEquals('Small', (string) $res[0]->ItemSearchRequest->ResponseGroup);
        $this->assertEquals('DVD', (string) $res[0]->ItemSearchRequest->SearchIndex);
        $this->assertEquals(2, (integer) $res[0]->ItemSearchRequest->ItemPage);
    }


    public function testRestArrayValues()
    {
        $search = new Search();
        $search
            ->setKeywords('Bruce Willis')
            ->setCategory('DVD')
            ->setResponseGroup(array('Large', 'Images'))
            ->setPage(2);

        $xml = $this->runOperation($search);
        $res = $xml->xpath('//a:Request');

        $success = (string) $res[0]->IsValid;
        $this->assertEquals("True", $success);

        $this->assertEquals('Large', (string) $res[0]->ItemSearchRequest->ResponseGroup[0]);
        $this->assertEquals('Images', (string) $res[0]->ItemSearchRequest->ResponseGroup[1]);
    }

    public function testRestErrorRequest()
    {
        $search = new Search();
        $search
            ->setCategory('DVD')
            ->setPage(2);

        $xml = $this->runOperation($search);
        $res = $xml->xpath('//a:Request');

        $success = (string) $res[0]->IsValid;
        $this->assertEquals("False", $success);

        $this->assertEquals('AWS.MinimumParameterRequirement', (string) $res[0]->Errors->Error->Code);
    }

    protected function runOperation($operation)
    {
        $apaiIo = new ApaiIO($this->conf);
        $response = $apaiIo->runOperation($operation);

        $xml = simplexml_load_string($response);
        $xml->registerXPathNamespace('a', 'http://webservices.amazon.com/AWSECommerceService/2011-08-01');

        return $xml;
    }
}