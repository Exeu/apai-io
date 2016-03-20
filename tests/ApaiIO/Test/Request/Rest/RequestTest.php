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
use ApaiIO\Request\Rest\Request;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;

class RequestTest extends \PHPUnit_Framework_TestCase
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

        $that = $this;

        $client
            ->send(Argument::that(function ($request) use ($that) {
                if (!$request instanceof RequestInterface) {
                    return false;
                }

                $uri = $request->getUri();
                $parts = [];
                parse_str($uri->getQuery(), $parts);

                $that->assertSame('webservices.amazon.de', $uri->getHost());
                $that->assertSame('/onca/xml', $uri->getPath());
                $that->assertArrayHasKey('AWSAccessKeyId', $parts);
                $that->assertSame('jkl', $parts['AWSAccessKeyId']);
                $that->assertArrayHasKey('AssociateTag', $parts);
                $that->assertSame('def', $parts['AssociateTag']);
                $that->assertArrayHasKey('ItemId', $parts);
                $that->assertSame('1', $parts['ItemId']);
                $that->assertArrayHasKey('Operation', $parts);
                $that->assertSame('ItemLookup', $parts['Operation']);
                $that->assertArrayHasKey('Service', $parts);
                $that->assertSame('AWSECommerceService', $parts['Service']);
                $that->assertArrayHasKey('Timestamp', $parts);
                $that->assertRegExp('#[0-9]{4}(-[0-9]{2}){2}T([0-9]{2}:){2}[0-9]{2}Z#', $parts['Timestamp']);
                $that->assertArrayHasKey('Version', $parts);
                $that->assertSame('2011-08-01', $parts['Version']);
                $that->assertArrayHasKey('Signature', $parts);
                return true;
            }))
            ->shouldBeCalledTimes(1)
            ->willReturn($response->reveal());

        $request = new Request($client->reveal());

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
}
