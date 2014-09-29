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

namespace ApaiIO\Operations;

/**
 * A base implementation of the OperationInterface
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
abstract class AbstractOperation implements OperationInterface
{
    protected $parameter = array();

    /**
     * {@inheritdoc}
     */
    public function setResponseGroup(array $responseGroup)
    {
        $this->parameter['ResponseGroup'] = $responseGroup;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOperationParameter()
    {
        return $this->parameter;
    }

    /**
     * Magic setter and getter functions
     *
     * @param string $methodName Methodname
     * @param string $parameter  Parameters
     *
     * @return \ApaiIO\Operations\AbstractOperation
     */
    public function __call($methodName, $parameter)
    {
        if (substr($methodName, 0, 3) == 'set') {
            $this->parameter[substr($methodName, 3)] = array_shift($parameter);

            return $this;
        }

        if (substr($methodName, 0, 3) == 'get') {
            $keyName = substr($methodName, 3);

            return isset($this->parameter[$keyName]) ? $this->parameter[$keyName] : null;
        }

        throw new \BadFunctionCallException(sprintf('The function "%s" does not exist!', $methodName));
    }
}
