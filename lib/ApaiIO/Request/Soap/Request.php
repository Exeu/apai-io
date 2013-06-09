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
use ApaiIO\Request\RequestInterface;

/**
 * Basic implementation of the soap request
 *
 * @see    http://docs.aws.amazon.com/AWSECommerceService/2011-08-01/DG/MakingSOAPRequests.html
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class Request implements RequestInterface
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

    /**
     * {@inheritdoc}
     */
    public function setConfiguration(ConfigurationInterface $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function perform(OperationInterface $operation)
    {
        $requestParams = $this->buildRequestParams($operation);

        $result = $this->performSoapRequest($operation, $requestParams);

        return $result;
    }

    /**
     * Provides some necessary soap headers
     *
     * @param OperationInterface $operation
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
                $this->configuration->getAccessKey()
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
     * Builds the request parameters depending on the operation
     *
     * @param OperationInterface $operation
     *
     * @return array
     */
    protected function buildRequestParams(OperationInterface $operation)
    {
        $associateTag = array('AssociateTag' => $this->configuration->getAssociateTag());

        return array_merge(
            $associateTag,
            array(
                'AWSAccessKeyId' => $this->configuration->getAccessKey(),
                'Request' => array_merge(
                    array(
                        'Operation' => $operation->getName()),
                        $operation->getOperationParameter()
        )));
    }

    /**
     * Performs the soaprequest
     *
     * @param OperationInterface $operation The operation
     * @param array              $params    Requestparameters 'ParameterName' => 'ParameterValue'
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
            $this->configuration->getCountry(),
            $this->webserviceEndpoint
        ));
        $soapClient->__setSoapHeaders($this->buildSoapHeader($operation));

        return $soapClient->__soapCall($operation->getName(), array($params));
    }

    /**
     * Calculates the signature for the request
     *
     * @param string $request
     *
     * @return string
     */
    protected function buildSignature($request)
    {
        return Util::buildSignature($request, $this->configuration->getSecretKey());
    }
}
