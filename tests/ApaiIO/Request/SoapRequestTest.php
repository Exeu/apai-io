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

class SoapRequestTest extends \PHPUnit_Framework_TestCase
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
            ->setAssociateTag('apaiIOTest')
            ->setRequest('\ApaiIO\Request\Soap\Request');
    }

    public function testRestSuccessRequest()
    {
        $search = new Search();
        $search
            ->setKeywords('Bruce Willis')
            ->setCategory('DVD')
            ->setPage(2);

        $res = $this->runOperation($search);

        $this->assertEquals("True", $res->Items->Request->IsValid);

        $this->assertEquals('Bruce Willis', $res->Items->Request->ItemSearchRequest->Keywords);
        $this->assertEquals('Small', $res->Items->Request->ItemSearchRequest->ResponseGroup);
        $this->assertEquals('DVD', $res->Items->Request->ItemSearchRequest->SearchIndex);
        $this->assertEquals(2, $res->Items->Request->ItemSearchRequest->ItemPage);
    }


    public function testRestArrayValues()
    {
        $responseGroups = array('Large', 'Images');

        $search = new Search();
        $search
            ->setKeywords('Bruce Willis')
            ->setCategory('DVD')
            ->setResponseGroup($responseGroups)
            ->setPage(2);

        $res = $this->runOperation($search);

        $this->assertEquals($responseGroups, $res->Items->Request->ItemSearchRequest->ResponseGroup);
    }

    public function testRestErrorRequest()
    {
        $search = new Search();
        $search
            ->setCategory('DVD')
            ->setPage(2);

        $res = $this->runOperation($search);

        $this->assertEquals("False", $res->Items->Request->IsValid);
    }

    protected function runOperation($operation)
    {
        $apaiIo = new ApaiIO($this->conf);
        $response = $apaiIo->runOperation($operation);

        return $response;
    }
}