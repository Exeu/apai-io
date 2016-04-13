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

require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'tests'.DIRECTORY_SEPARATOR.'bootstrap.php';
require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Config.php';

use ApaiIO\ApaiIO;
use ApaiIO\Configuration\GenericConfiguration;

$conf = new GenericConfiguration();
$client = new \GuzzleHttp\Client();
$request = new \ApaiIO\Request\GuzzleRequest($client);

try {
    $conf
        ->setCountry('de')
        ->setAccessKey(AWS_API_KEY)
        ->setSecretKey(AWS_API_SECRET_KEY)
        ->setAssociateTag(AWS_ASSOCIATE_TAG)
        ->setRequest($request);
} catch (\Exception $e) {
    echo $e->getMessage();
}

$apaiIO = new ApaiIO($conf);

$search1 = new \ApaiIO\Operations\Search();
$search1->setCategory('DVD');
$search1->setActor('Bruce Willis');
$search1->setKeywords('Stirb Langsam');
$search1->setPage(3);

$search2 = new \ApaiIO\Operations\Search();
$search2->setCategory('DVD');
$search2->setActor('Arnold Schwarzenegger');
$search2->setKeywords('Terminator');

$batch = new \ApaiIO\Operations\Batch();
$batch->addOperation($search1);
$batch->addOperation($search2);

$formattedResponse = $apaiIO->runOperation($batch);

echo $formattedResponse;
