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

namespace ApaiIO\Common;

/**
 * This trait allows you to add the basic operation functions to your class.
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
trait OperationTrait
{
    protected $parameters = [];

    /**
     * Sets the responsegroups for the current operation
     * Which responsegroups are available depends on the Operation you perform
     *
     * @param array $responseGroup The responsegroup as an array
     *
     * @see http://docs.aws.amazon.com/AWSECommerceService/latest/DG/CHAP_ResponseGroupsList.html
     */
    public function setResponseGroup(array $responseGroup)
    {
        $this->parameters['ResponseGroup'] = $responseGroup;

        return $this;
    }

    /**
     * Returns all paramerters belonging to the current operation
     *
     * @return array
     */
    public function getOperationParameter()
    {
        return $this->parameters;
    }
}
