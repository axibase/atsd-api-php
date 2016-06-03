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

class Series extends AtsdClient {
    const URL = "/series/query";
    protected $queryUri;
    private $queries = array();
    private $currentQuery = array();
    private $series;

    public function addAggregateQuery($entity, $metric, $startTime, $endTime, $aggregator, $tags = array()) {
        $optional["aggregate"] = $aggregator->asArray();
        $optional["tags"] = $tags;
        $optional["startTime"] = $startTime;
        $optional["endTime"] = $endTime;
        $this->addQuery($entity, $metric, $optional);
        return $this;
    }

    public function addDetailQuery($entity, $metric, $startTime, $endTime, $tags = array()) {
        $optional = array();
        $optional["tags"] = $tags;
        $optional["startTime"] = $startTime;
        $optional["endTime"] = $endTime;
        $this->addQuery($entity, $metric, $optional);
        return $this;
    }

    public function addQuery($entity, $metric, $optional = array()) {
        if(array_key_exists("tags", $optional)) {
            if(count($optional["tags"]) == 0) {
                unset($optional["tags"]);
            }
        }
        $this->currentQuery["requestId"] = count($this->queries);
        $this->currentQuery["entity"] = rawurlencode($entity);
        $this->currentQuery["metric"] = rawurlencode($metric);
        foreach($optional as $key => $option) {
            $this->currentQuery[$key] = $option;
        }
        $this->queries[] = $this->currentQuery;
        $this->currentQuery = array();
        return $this;
    }

    public function execQueries() {
        $this->postParams = array("queries" => $this->queries);
        $response = $this->query(Series::URL);
        foreach($response['series'] as $value) {
            $this->series[$value["requestId"]][] = $value;
        }
        $this->queries = array();
        return $this->series;
    }

    public function getSeries($key) {
        if(array_key_exists($key, $this->series)) {
            return $this->series[$key];
        } else {
            return null;
        }
    }

    public function simpleQuery($query) {
        $this->postParams = json_decode($query);
        $response = $this->query(Series::URL);
        return $response;
    }

}

class Aggregator {
    public $types;
    public $period;
    public $interpolate;
    public $threshold;
    public $calendar;
    public $workingMinutes;

    function __construct($types, $period, $interpolate = "", $threshold = "", $calendar = "", $workingMinutes = "") {
        $this->types = $types;
        $this->period = $period;
        $this->interpolate = $interpolate;
        $this->threshold = $threshold;
        $this->calendar = $calendar;
        $this->workingMinutes = $workingMinutes;
    }

    function asArray() {
        $arr = array();
        foreach($this as $key => $value) {
            if("" != $value) {
                $arr[$key] = $value;
            }
        }
        return $arr;
    }


}

