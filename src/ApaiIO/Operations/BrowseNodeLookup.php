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
 * A browse node lookup operation
 *
 * @see    http://docs.aws.amazon.com/AWSECommerceService/2011-08-01/DG/BrowseNodeLookup.html
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class BrowseNodeLookup extends AbstractOperation
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'BrowseNodeLookup';
    }

    /**
     * Returns the nodeid
     *
     * @return string
     */
    public function getNodeId()
    {
        return $this->getSingleOperationParameter('BrowseNodeId');
    }

    /**
     * Sets the nodeid in which should be looked up
     *
     * @param string $nodeId
     *
     * @return \ApaiIO\Operations\BrowseNodeLookup
     */
    public function setNodeId($nodeId)
    {
        $this->parameters['BrowseNodeId'] = $nodeId;

        return $this;
    }
}
