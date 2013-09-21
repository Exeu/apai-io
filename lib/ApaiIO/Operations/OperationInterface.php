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

interface OperationInterface
{
    /**
     * Gets the name of the operation
     *
     * @see    http://docs.aws.amazon.com/AWSECommerceService/2011-08-01/DG/CHAP_OperationListAlphabetical.html
     *
     * @return string
     */
    public function getName();

    /**
     * Sets the responsegroups for the current operation
     * Which responsegroups are available depends on the Operation you perform
     *
     * @param array $responseGroup The responsegroup as an array
     *
     * @see http://docs.aws.amazon.com/AWSECommerceService/2011-08-01/DG/CHAP_ResponseGroupsList.html
     */
    public function setResponseGroup(array $responseGroup);

    /**
     * Returns all paramerters belonging to the current operation
     *
     * @return array
     */
    public function getOperationParameter();
}
