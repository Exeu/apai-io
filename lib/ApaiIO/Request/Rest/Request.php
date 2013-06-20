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

namespace ApaiIO\Request\Rest;

use ApaiIO\Configuration\ConfigurationInterface;
use ApaiIO\Request\Util;
use ApaiIO\Operations\OperationInterface;
use ApaiIO\Request\RequestInterface;

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
    protected $requestScheme = "http://webservices.amazon.%s/onca/xml?%s";

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
        $preparedRequestParams = $this->prepareRequestParams($operation);
        $queryString = $this->buildQueryString($preparedRequestParams);

        $result = file_get_contents(sprintf($this->requestScheme, $this->configuration->getCountry(), $queryString));

        return $result;
    }

    /**
     * Prepares the parameters for the request
     *
     * @param OperationInterface $operation
     *
     * @return array
     */
    protected function prepareRequestParams(OperationInterface $operation)
    {
        $baseRequestParams = array(
            'Service' => 'AWSECommerceService',
            'AWSAccessKeyId' => $this->configuration->getAccessKey(),
            'AssociateTag' => $this->configuration->getAssociateTag(),
            'Operation' => $operation->getName(),
            'Version' => '2011-08-01',
            'Timestamp' => Util::getTimeStamp()
        );

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
     * @param array $params
     *
     * @return string
     */
    protected function buildQueryString(array $params)
    {
        $parameterList = array();
        foreach ($params as $key => $value) {
            $parameterList[] = sprintf('%s=%s', $key, rawurlencode($value));
        }

        $parameterList[] = 'Signature=' . rawurlencode($this->buildSignature($parameterList));

        return implode("&", $parameterList);
    }

    /**
     * Calculates the signature for the request
     *
     * @param array $params
     *
     * @return string
     */
    protected function buildSignature(array $params)
    {
        $template = "GET\nwebservices.amazon.%s\n/onca/xml\n%s";

        return Util::buildSignature(sprintf($template, $this->configuration->getCountry(), implode('&', $params)), $this->configuration->getSecretKey());
    }
}
