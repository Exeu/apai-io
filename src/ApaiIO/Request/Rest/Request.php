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

namespace ApaiIO\Request\Rest;

use ApaiIO\ApaiIO;
use ApaiIO\Configuration\ConfigurationInterface;
use ApaiIO\Operations\OperationInterface;
use ApaiIO\Request\RequestInterface;
use ApaiIO\Request\Util;
use GuzzleHttp\ClientInterface;

/**
 * Basic implementation of the rest request
 *
 * @see    http://docs.aws.amazon.com/AWSECommerceService/2011-08-01/DG/AnatomyOfaRESTRequest.html
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class Request implements RequestInterface
{
    /**
     * The requestscheme
     *
     * @var string
     */
    private $requestScheme = "http://webservices.amazon.%s/onca/xml?%s";

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * Initialize instance
     *
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function perform(OperationInterface $operation, ConfigurationInterface $configuration)
    {
        $preparedRequestParams = $this->prepareRequestParams($operation, $configuration);
        $queryString = $this->buildQueryString($preparedRequestParams, $configuration);

        $uri = sprintf($this->requestScheme, $configuration->getCountry(), $queryString);
        $request = new \GuzzleHttp\Psr7\Request('GET', $uri, [
            'User-Agent' => 'ApaiIO [' . ApaiIO::VERSION . ']'
        ]);

        $result = $this->client->send($request);

        return $result->getBody()->getContents();
    }

    /**
     * Prepares the parameters for the request
     *
     * @param OperationInterface     $operation
     * @param ConfigurationInterface $configuration
     *
     * @return array
     */
    protected function prepareRequestParams(OperationInterface $operation, ConfigurationInterface $configuration)
    {
        $baseRequestParams = [
            'Service'        => 'AWSECommerceService',
            'AWSAccessKeyId' => $configuration->getAccessKey(),
            'AssociateTag'   => $configuration->getAssociateTag(),
            'Operation'      => $operation->getName(),
            'Version'        => '2011-08-01',
            'Timestamp'      => Util::getTimeStamp()
        ];

        $operationParams = $operation->getOperationParameter();

        foreach ($operationParams as $key => $value) {
            if (true === is_array($value)) {
                $operationParams[$key] = implode(',', $value);
            }
        }

        $fullParameterList = array_merge($baseRequestParams, $operationParams);
        ksort($fullParameterList);

        return $fullParameterList;
    }

    /**
     * Builds the final querystring including the signature
     *
     * @param array                  $params
     * @param ConfigurationInterface $configuration
     *
     * @return string
     */
    protected function buildQueryString(array $params, ConfigurationInterface $configuration)
    {
        $parameterList = [];
        foreach ($params as $key => $value) {
            $parameterList[] = sprintf('%s=%s', $key, rawurlencode($value));
        }

        $parameterList[] = 'Signature=' . rawurlencode(
            $this->buildSignature($parameterList, $configuration->getCountry(), $configuration->getSecretKey())
        );

        return implode("&", $parameterList);
    }

    /**
     * Calculates the signature for the request
     *
     * @param array  $params
     * @param string $country
     * @param string $secret
     *
     * @return string
     */
    protected function buildSignature(array $params, $country, $secret)
    {
        return Util::buildSignature(
            sprintf(
                "GET\nwebservices.amazon.%s\n/onca/xml\n%s",
                $country,
                implode('&', $params)
            ),
            $secret
        );
    }
}
