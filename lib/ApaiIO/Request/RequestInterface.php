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

namespace ApaiIO\Request;

use ApaiIO\Configuration\ConfigurationInterface;
use ApaiIO\Operations\OperationInterface;

interface RequestInterface
{
    /**
     * Sets the configurationobject
     *
     * @param ConfigurationInterface $configuration
     */
    public function setConfiguration(ConfigurationInterface $configuration);

    /**
     * Performs the request
     *
     * @param OperationInterface $operation
     *
     * @return mixed The response of the request
     */
    public function perform(OperationInterface $operation);
}
