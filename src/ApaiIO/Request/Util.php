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

/**
 * A collection of misc functions helping to build the request
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class Util
{
    /**
     * Provides the current timestamp according to the requirements of amazon
     *
     * @return string
     */
    public static function getTimeStamp()
    {
        return gmdate("Y-m-d\TH:i:s\Z");
    }

    /**
     * Provides the signature
     *
     * @param string $stringToSign The string to be signed
     * @param string $secretKey    The paapi secret key
     *
     * @return string
     */
    public static function buildSignature($stringToSign, $secretKey)
    {
        return base64_encode(hash_hmac("sha256", $stringToSign, $secretKey, true));
    }
}
