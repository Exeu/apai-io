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

class Batch implements OperationInterface
{
    /**
     * @var OperationInterface[]
     */
    private $operations = [];

    /**
     * @var string
     */
    private $operationName;

    /**
     * Batch constructor.
     *
     * @param OperationInterface[]
     */
    public function __construct(array $operations = [])
    {
        foreach ($operations as $operation) {
            $this->addOperation($operation);
        }
    }

    /**
     * Adds a single operation.
     * Note that only operations with the same operation name can be added.
     * First operation which is added will be the reference and the instance will let you only add
     * other operations with the same operation name.
     *
     * @param OperationInterface $operation
     *
     * @return void
     */
    public function addOperation(OperationInterface $operation)
    {
        if (null === $this->operationName) {
            $this->operationName = $operation->getName();
        }

        if ($this->operationName !== $operation->getName()) {
            return;
        }

        $this->operations[] = $operation;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->operationName;
    }

    /**
     * {@inheritdoc}
     */
    public function getOperationParameter()
    {
        $parameter = [];
        $index = 1;
        foreach ($this->operations as $operation) {
            foreach ($operation->getOperationParameter() as $key => $value) {
                $keyName = sprintf('%s.%s.%s', $this->operationName, $index, $key);
                $parameter[$keyName] = $value;
            }
            $index++;
        }

        return $parameter;
    }
}
