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

/**
 * A requestfactory which creates a new requestobjects depending on the class name you provide
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class RequestFactory
{
    /**
     * Storage for the requestobjects
     *
     * @var array
     */
    private static $requestObjects = array();

    /**
     * Private constructor
     * @codeCoverageIgnore
     */
    private function __construct()
    {
        // noop
    }

    /**
     * Private clone
     * @codeCoverageIgnore
     */
    private function __clone()
    {
        // noop
    }

    /**
     * Creates a new Requestobject
     *
     * @param ConfigurationInterface $configuration The configurationobject
     *
     * @return \ApaiIO\Request\RequestInterface
     */
    public static function createRequest(ConfigurationInterface $configuration)
    {
        $class = $configuration->getRequest();
        $factoryCallback = $configuration->getRequestFactory();

        if (true === is_object($class) && $class instanceof \ApaiIO\Request\RequestInterface) {
            $class->setConfiguration($configuration);

            return self::applyCallback($factoryCallback, $class);
        }

        if (true === is_string($class) && true == array_key_exists($class, self::$requestObjects)) {
            $request = self::$requestObjects[$class];
            $request->setConfiguration($configuration);

            return self::applyCallback($factoryCallback, $request);
        }

        try {
            $reflectionClass = new \ReflectionClass($class);
        } catch (\ReflectionException $e) {
            throw new \InvalidArgumentException(sprintf("Requestclass not found: %s", $class));
        }

        if ($reflectionClass->implementsInterface('\\ApaiIO\\Request\\RequestInterface')) {
            $request = new $class();
            $request->setConfiguration($configuration);

            return self::$requestObjects[$class] = self::applyCallback($factoryCallback, $request);
        }

        throw new \LogicException(sprintf("Requestclass does not implements the RequestInterface: %s", $class));
    }

    protected static function applyCallback($callback, $request)
    {
        if (false === is_null($callback) && is_callable($callback)) {
            $request = call_user_func($callback, $request);
            if ($request instanceof \ApaiIO\Request\RequestInterface) {
                return $request;
            }

            throw new \LogicException(
                sprintf(
                    "Requestclass does not implements the RequestInterface: %s",
                    get_class($request)
                )
            );
        }

        return $request;
    }
}
