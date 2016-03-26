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

namespace ApaiIO\Test\Operations\Types;

use ApaiIO\Operations\Batch;
use ApaiIO\Operations\Lookup;
use ApaiIO\Operations\Search;

class BatchTest extends \PHPUnit_Framework_TestCase
{
    public function testAddOperation()
    {
        $op = new Search();
        $op->setTest('test');

        $batch = new Batch();
        $batch->addOperation($op);

        $this->assertSame('ItemSearch', $batch->getName());
        $this->assertSame(['ItemSearch.1.Test' => 'test'], $batch->getOperationParameter());

        $op2 = new Lookup();

        $batch->addOperation($op2);

        $this->assertSame('ItemSearch', $batch->getName());
        $this->assertSame(['ItemSearch.1.Test' => 'test'], $batch->getOperationParameter());

        $batch = new Batch([$op, $op2]);

        $this->assertSame('ItemSearch', $batch->getName());
        $this->assertSame(['ItemSearch.1.Test' => 'test'], $batch->getOperationParameter());

        $op3 = new Search();
        $op3->setTest2('test');

        $batch->addOperation($op3);

        $this->assertSame('ItemSearch', $batch->getName());
        $this->assertSame([
            'ItemSearch.1.Test' => 'test',
            'ItemSearch.2.Test2' => 'test'
        ], $batch->getOperationParameter());
    }
}
