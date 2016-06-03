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

class Metrics  extends AtsdClient {
    const METRICS_URI = '/metrics?';
    const METRIC_URI = '/metrics/[[metric]]?';
    const ENTITY_AND_TAGS_FOR_METRIC_URI = '/metrics/[[metric]]/entity-and-tags?';
    protected $queryUri;

    function findEntityAndTags($metric, $entity = null) {
        $this->queryUri = str_replace('[[metric]]', rawurlencode($metric), Metrics::ENTITY_AND_TAGS_FOR_METRIC_URI);
        if($entity) {
            $this->applyGetParameters(array("entity" => $entity));
        }
        return $this->query($this->queryUri . $this->getParams);

    }

    function findAll($getParameters = array()) {
        $this->queryUri = Metrics::METRICS_URI;
        $this->applyGetParameters($getParameters);
        return $this->query($this->queryUri . $this->getParams);
    }

    function find($metric, $getParameters = array()) {
        $this->queryUri = str_replace('[[metric]]', rawurlencode($metric), Metrics::METRIC_URI);
        $this->applyGetParameters($getParameters);
        return $this->query($this->queryUri . $this->getParams);

    }

    private function applyGetParameters($getParameters) {
        $this->getParams = http_build_query($getParameters);
    }

}