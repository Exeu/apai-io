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

namespace ApaiIO;

use ApaiIO\Configuration\ConfigurationInterface;
use ApaiIO\Operations\OperationInterface;

/**
 * ApaiIO Core
 * Bundles all components
 *
 * http://www.amazon.com
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 *
 * @see https://github.com/Exeu/apai-io/wiki Wiki
 * @see https://github.com/Exeu/apai-io Source
 */
class ApaiIO
{
    const VERSION = "2.1.0";

    /**
     * Configuration.
     *
     * @var ConfigurationInterface
     */
    protected $configuration;

    /**
     * @param ConfigurationInterface $configuration
     */
    public function __construct(ConfigurationInterface $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * Runs the given operation.
     *
     * @param OperationInterface $operation The operationobject
     *
     * @return mixed
     */
    public function runOperation(OperationInterface $operation)
    {
        $request  = $this->configuration->getRequest();

        $response = $request->perform($operation, $this->configuration);

        return $this->applyResponseTransformer($response);
    }

    /**
     * Applies a responsetransformer.
     *
     * @param mixed $response The response of the request
     *
     * @return mixed
     */
    protected function applyResponseTransformer($response)
    {
        if (null === $responseTransformer = $this->configuration->getResponseTransformer()) {
            return $response;
        }

        return $responseTransformer->transform($response);
    }
}
