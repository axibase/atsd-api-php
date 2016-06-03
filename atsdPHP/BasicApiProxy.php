<?php
/*
* Copyright 2015 Axibase Corporation or its affiliates. All Rights Reserved.
*
* Licensed under the Apache License, Version 2.0 (the "License").
* You may not use this file except in compliance with the License.
* A copy of the License is located at
*
* https://www.axibase.com/atsd/axibase-apache-2.0.pdf
*
* or in the "license" file accompanying this file. This file is distributed
* on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
* express or implied. See the License for the specific language governing
* permissions and limitations under the License.
*/

namespace axibase\atsdPHP;
require_once '../atsdPHP/HttpClient.php';
require_once '../atsdPHP/models/Series.php';
require_once '../atsdPHP/models/Properties.php';
class BasicApiProxy {

    public function __construct() {
    }
    protected function validateSeries($string) {
        return true;
    }

    protected function validateProperties($string) {
        return true;
    }

    public function seriesJsonQuery($string) {
        $seriesClient = new Series();
        if(!$this->validateSeries($string)) {
            return "";
        }
        $response = $seriesClient->simpleQuery($string);
        return $response;

    }

    public function propertiesJsonQuery($string) {
        $propertiesClient = new Properties();
        if(!$this->validateProperties($string)) {
            return "";
        }
        $response = $propertiesClient->find($string);
        return $response;
    }

    public function getPost() {
        $input = file_get_contents("php://input");
        return $input;
    }

}

