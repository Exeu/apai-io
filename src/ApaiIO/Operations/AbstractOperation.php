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

namespace ApaiIO\Operations;

/**
 * A base implementation of the OperationInterface
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
abstract class AbstractOperation implements OperationInterface
{
    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * Returns an array of responseGroups
     *
     * @return array
     */
    public function getResponseGroup()
    {
        return $this->getSingleOperationParameter('ResponseGroup');
    }

    /**
     * {@inheritdoc}
     */
    public function setResponseGroup(array $responseGroup)
    {
        $this->parameters['ResponseGroup'] = $responseGroup;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOperationParameter()
    {
        return $this->parameters;
    }

    /**
     * Returns a single operation parameter if set
     *
     * @param string $keyName
     *
     * @return mixed|null
     */
    public function getSingleOperationParameter($keyName)
    {
        return isset($this->parameters[$keyName]) ? $this->parameters[$keyName] : null;
    }

    /**
     * Magic setter and getter functions
     *
     * @param string $method    Methodname
     * @param string $parameter Parameters
     *
     * @return \ApaiIO\Operations\AbstractOperation
     */
    public function __call($method, $parameter)
    {
        if (substr($method, 0, 3) === 'set') {
            $this->parameters[substr($method, 3)] = array_shift($parameter);

            return $this;
        }

        if (substr($method, 0, 3) === 'get') {
            $key = substr($method, 3);

            return isset($this->parameters[$key]) ? $this->parameters[$key] : null;
        }

        throw new \BadFunctionCallException(sprintf('The function "%s" does not exist!', $method));
    }
}
