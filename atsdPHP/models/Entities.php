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

class Entities  extends AtsdClient {
    const ENTITIES_URI = '/entities?';
    const ENTITY_URI = '/entities/[[entity]]';
    const METRICS_FOR_ENTITY = '/entities/[[entity]]/metrics?';
    const PROPERTIES_FOR_ENTITY = '/entities/[[entity]]/property-types?';
    protected $queryUri;

    function findAll($getParameters = array()) {
        $this->queryUri = Entities::ENTITIES_URI;
        $this->applyGetParameters($getParameters);
        return $this->query($this->queryUri . $this->getParams);
    }

    function find($entity) {
        $this->queryUri = str_replace('[[entity]]', rawurlencode($entity), Entities::ENTITY_URI);
        return $this->query($this->queryUri);
    } 


    function findMetrics($entity, $getParameters = array()) {
        $this->queryUri = str_replace('[[entity]]', rawurlencode($entity), Entities::METRICS_FOR_ENTITY);
        $this->applyGetParameters($getParameters);
        return $this->query($this->queryUri . $this->getParams);
    }

    function findPropertyTypes($entity, $getParameters = array()) {
        $this->queryUri = str_replace('[[entity]]', rawurlencode($entity), Entities::PROPERTIES_FOR_ENTITY);
        $this->applyGetParameters($getParameters);
        return $this->query($this->queryUri . $this->getParams);
    }

    private function applyGetParameters($parameters) {
        $this->getParams = http_build_query($parameters);
    }
}