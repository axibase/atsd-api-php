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
require_once(dirname(__FILE__) . '/../AtsdClient.php');

class Csv  extends AtsdClient {
    const EXPORT_URI = "/export?";
    protected $queryUri;

    public function export($entity, $metric, $endDate, $period, $optional = array() ) {
        $this->postParams = array();
        $this->postParams['e'] = $entity;
        $this->postParams['m'] = $metric;
        $this->postParams['t'] = 'HISTORY';
        $this->postParams['si'] = $period;
        $this->postParams['et'] = $endDate;
        $this->postParams['f'] = 'CSV';
        foreach($optional as $key => $value) {
            $this->postParams[$key] = $value;
        }
        $response = $this->client->query(self::EXPORT_URI, $this->postParams);
        return $response;
    }

}
