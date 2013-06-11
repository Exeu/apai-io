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

namespace ApaiIO\ResponseTransformer;

use ApaiIO\Configuration\ConfigurationInterface;

/**
 * A responsetransformerfactory which creates a new responsetransformerobjects depending on the class name you provide
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class ResponseTransformerFactory
{
    /**
     * Storage for the responsetransformerobjects
     *
     * @var array
     */
    private static $responseTransformerObjects = array();

    /**
     * Private constructor
     */
    private function __construct()
    {
    }

    /**
     * Private clone
     */
    private function __clone()
    {
    }

    /**
     * Creates a new ResponseTransformer-object
     *
     * @param ConfigurationInterface $configuration
     *
     * @return \ApaiIO\ResponseTransformer\ResponseTransformerInterface
     */
    public static function createResponseTransformer(ConfigurationInterface $configuration)
    {
        $class = $configuration->getResponseTransformer();

        if (true === is_string($class) && true == array_key_exists($class, self::$responseTransformerObjects)) {
            return self::$responseTransformerObjects[$class];
        }

        if (true === is_object($class) && $class instanceof \ApaiIO\ResponseTransformer\ResponseTransformerInterface) {
            return $class;
        }

        try {
            $reflectionClass = new \ReflectionClass($class);
        } catch (\ReflectionException $e) {
            throw new \InvalidArgumentException(sprintf("Responsetransformerclass not found: %s", $class));
        }

        if ($reflectionClass->implementsInterface('\\ApaiIO\\ResponseTransformer\\ResponseTransformerInterface')) {
            $responseTransformer = new $class();

            return self::$responseTransformerObjects[$class] = $responseTransformer;
        }

        throw new \LogicException(sprintf("Responsetransformerclass does not implements the ResponseTransformerInterface: %s", $class));
    }
}
