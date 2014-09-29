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

namespace ApaiIO;

use ApaiIO\Configuration\ConfigurationInterface;
use ApaiIO\Operations\OperationInterface;
use ApaiIO\Request\RequestFactory;
use ApaiIO\ResponseTransformer\ResponseTransformerFactory;

/**
 * ApaiIO Core
 * Bundles all components
 *
 * http://www.amazon.com
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 *
 * @see    https://github.com/Exeu/apai-io/wiki Wiki
 * @see    https://github.com/Exeu/apai-io Source
 */
class ApaiIO
{
    const VERSION = "2.0.0-DEV";

    /**
     * Configuration
     *
     * @var ConfigurationInterface
     */
    protected $configuration;

    /**
     * @param ConfigurationInterface $configuration
     */
    public function __construct(ConfigurationInterface $configuration = null)
    {
        $this->configuration = $configuration;
    }

    /**
     * Runs the given operation
     *
     * @param OperationInterface     $operation     The operationobject
     * @param ConfigurationInterface $configuration The configurationobject
     *
     * @return mixed
     */
    public function runOperation(OperationInterface $operation, ConfigurationInterface $configuration = null)
    {
        $configuration = is_null($configuration) ? $this->configuration : $configuration;

        if (true === is_null($configuration)) {
            throw new \Exception('No configuration passed.');
        }

        $requestObject = RequestFactory::createRequest($configuration);

        $response = $requestObject->perform($operation);

        return $this->applyResponseTransformer($response, $configuration);
    }

    /**
     * Applies a responsetransformer
     *
     * @param mixed                  $response      The response of the request
     * @param ConfigurationInterface $configuration The configurationobject
     *
     * @return mixed
     */
    protected function applyResponseTransformer($response, ConfigurationInterface $configuration)
    {
        if (true === is_null($configuration->getResponseTransformer())) {
            return $response;
        }

        $responseTransformer = ResponseTransformerFactory::createResponseTransformer($configuration);

        return $responseTransformer->transform($response);
    }
}
