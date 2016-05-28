<?php
/*
 * Copyright 2016 Jan Eichhorn <exeu65@googlemail.com>
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

namespace ApaiIO\Test\Request\Rest;

use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Lookup;
use ApaiIO\Request\GuzzleRequest;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;

class GuzzleRequestTest extends \PHPUnit_Framework_TestCase
{
    public function testPerform()
    {
        $body = $this->prophesize('\Psr\Http\Message\StreamInterface');
        $body
            ->getContents()
            ->shouldBeCalledTimes(1)
            ->willReturn('ABC');

        $response = $this->prophesize('\Psr\Http\Message\ResponseInterface');
        $response
            ->getBody()
            ->shouldBeCalledTimes(1)
            ->willReturn($body->reveal());

        $client = $this->prophesize('\GuzzleHttp\ClientInterface');
        $client
            ->send(Argument::that(function ($request) {
                if (!$request instanceof RequestInterface) {
                    return false;
                }

                $uri = $request->getUri();
                $parts = [];
                parse_str($uri->getQuery(), $parts);

                $this->assertSame('webservices.amazon.de', $uri->getHost());
                $this->assertSame('/onca/xml', $uri->getPath());
                $this->assertArrayHasKey('AWSAccessKeyId', $parts);
                $this->assertSame('jkl', $parts['AWSAccessKeyId']);
                $this->assertArrayHasKey('AssociateTag', $parts);
                $this->assertSame('def', $parts['AssociateTag']);
                $this->assertArrayHasKey('ItemId', $parts);
                $this->assertSame('1', $parts['ItemId']);
                $this->assertArrayHasKey('Test', $parts);
                $this->assertSame('a,b', $parts['Test']);
                $this->assertArrayHasKey('Operation', $parts);
                $this->assertSame('ItemLookup', $parts['Operation']);
                $this->assertArrayHasKey('Service', $parts);
                $this->assertSame('AWSECommerceService', $parts['Service']);
                $this->assertArrayHasKey('Timestamp', $parts);
                $this->assertRegExp('#[0-9]{4}(-[0-9]{2}){2}T([0-9]{2}:){2}[0-9]{2}Z#', $parts['Timestamp']);
                $this->assertArrayHasKey('Version', $parts);
                $this->assertSame('2013-08-01', $parts['Version']);
                $this->assertArrayHasKey('Signature', $parts);
                return true;
            }))
            ->shouldBeCalledTimes(1)
            ->willReturn($response->reveal());

        $request = new GuzzleRequest($client->reveal());

        $operation  = new Lookup();
        $operation->setItemId('1');
        $operation->setTest(['a', 'b']);

        $config = new GenericConfiguration();
        $config->setAccessKey('abc');
        $config->setAssociateTag('def');
        $config->setCountry('DE');
        $config->setSecretKey('ghi');
        $config->setAccessKey('jkl');

        $request->perform($operation, $config);
    }

    public function testSchemeSwitch()
    {
        $body = $this->prophesize('\Psr\Http\Message\StreamInterface');
        $body
            ->getContents()
            ->shouldBeCalledTimes(1)
            ->willReturn('ABC');

        $response = $this->prophesize('\Psr\Http\Message\ResponseInterface');
        $response
            ->getBody()
            ->shouldBeCalledTimes(1)
            ->willReturn($body->reveal());

        $client = $this->prophesize('\GuzzleHttp\ClientInterface');
        $client
            ->send(Argument::that(function ($request) {
                if (!$request instanceof RequestInterface) {
                    return false;
                }

                $uri = $request->getUri();

                $this->assertSame('https', $uri->getScheme());
                return true;
            }))
            ->shouldBeCalledTimes(1)
            ->willReturn($response->reveal());

        $request = new GuzzleRequest($client->reveal());
        $request->setScheme('HTTPS');

        $operation  = new Lookup();
        $operation->setItemId('1');

        $config = new GenericConfiguration();
        $config->setAccessKey('abc');
        $config->setAssociateTag('def');
        $config->setCountry('DE');
        $config->setSecretKey('ghi');
        $config->setAccessKey('jkl');

        $request->perform($operation, $config);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSchemeSetterWithInvalidValue()
    {
        $client = $this->prophesize('\GuzzleHttp\ClientInterface');

        $request = new GuzzleRequest($client->reveal());
        $request->setScheme('ftp');
    }
}
