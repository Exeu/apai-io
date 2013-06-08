<?php
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

namespace ApaiIO\Request\Soap;

use ApaiIO\Configuration\ConfigurationInterface;
use ApaiIO\Request\Util;
use ApaiIO\Operations\OperationInterface;

class Request
{
    /**
     * The WSDL File
     *
     * @var string
     */
    protected $webserviceWsdl = 'http://webservices.amazon.com/AWSECommerceService/AWSECommerceService.wsdl';

    /**
     * The SOAP Endpoint
     *
     * @var string
     */
    protected $webserviceEndpoint = 'https://webservices.amazon.%%COUNTRY%%/onca/soap?Service=AWSECommerceService';

    /**
     * @var ConfigurationInterface
     */
    protected $configuration;

    public function __construct(ConfigurationInterface $configuration)
    {
        $this->configuration = $configuration;
    }

    public function perform(OperationInterface $operation)
    {
        $requestParams = $this->buildRequestParams($operation);

        $result = $this->performSoapRequest($operation, $requestParams);

        return $result;
    }

    /**
     * Provides some necessary soap headers
     *
     * @param string $function
     *
     * @return array Each element is a concrete SoapHeader object
     */
    protected function buildSoapHeader(OperationInterface $operation)
    {
        $timeStamp = Util::getTimeStamp();
        $signature = $this->buildSignature($operation->getName() . $timeStamp);

        return array(
            new \SoapHeader(
                'http://security.amazonaws.com/doc/2007-01-01/',
                'AWSAccessKeyId',
                $this->configuration->accessKey()
            ),
            new \SoapHeader(
                'http://security.amazonaws.com/doc/2007-01-01/',
                'Timestamp',
                $timeStamp
            ),
            new \SoapHeader(
                'http://security.amazonaws.com/doc/2007-01-01/',
                'Signature',
                $signature
            )
        );
    }

    /**
     * Builds the request parameters
     *
     * @param string $function
     * @param array  $params
     *
     * @return array
     */
    protected function buildRequestParams(OperationInterface $operation)
    {
        $associateTag = array('AssociateTag' => $this->configuration->associateTag());

        return array_merge(
            $associateTag,
            array(
                'AWSAccessKeyId' => $this->configuration->accessKey(),
                'Request' => array_merge(
                    array('Operation' => $operation->getName()),
                    $operation->getOperationParameter(),
                    array('ResponseGroup' => $operation->responseGroup())
        )));
    }

    /**
     * @param string $function Name of the function which should be called
     * @param array $params Requestparameters 'ParameterName' => 'ParameterValue'
     *
     * @return array The response as an array with stdClass objects
     */
    protected function performSoapRequest(OperationInterface $operation, $params)
    {
        $soapClient = new \SoapClient(
            $this->webserviceWsdl,
            array('exceptions' => 1)
        );

        $soapClient->__setLocation(str_replace(
            '%%COUNTRY%%',
            $this->configuration->country(),
            $this->webserviceEndpoint
        ));
        $soapClient->__setSoapHeaders($this->buildSoapHeader($operation));

        return $soapClient->__soapCall($operation->getName(), array($params));
    }

    /**
     * provides the signature
     *
     * @return string
     */
    final protected function buildSignature($request)
    {
        return base64_encode(hash_hmac("sha256", $request, $this->configuration->secretKey(), true));
    }
}