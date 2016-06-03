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
require_once(dirname(__FILE__)) . '/../atsdPHP/HttpClient.php';
require_once(dirname(__FILE__)) . '/../atsdPHP/models/Csv.php';
session_start();
if(!array_key_exists('user', $_SESSION)) {
    exit("Authentication required.");
}

export();

function export() {
    $errors = validateRequest();
    if($errors != "") {
        exit($errors);
    }
    $entity = $_REQUEST['entity'];
    if(array_key_exists('entities', $_SESSION) && in_array($entity, $_SESSION['entities'])) {
        $metric = $_REQUEST['metric'];
        $endDate = $_REQUEST['endDate'];
        $period = $_REQUEST['period'];
        $csv = getCsv($entity, $metric, $endDate, $period);
        header("Content-type: text/csv; charset=UTF-8");
        header("Content-Disposition: attachment; filename=series.csv");
        echo $csv;
    } else {
        header("Content-type: text/plain; charset=UTF-8");
        echo "entity " . $entity . " is not allowed to current user.";
    }
}

function getCsv($entity, $metric, $endDate, $period) {
    $csv = new Csv();

    $options = array();
    if($period != '1-DAY') {
        $options['a'] = array("SUM");
    }
    if($period == '1-WEEK') {
        $options['ai'] = '1-HOUR';
    } else if ($period == '1-MONTH') {
        $options['ai'] = '1-DAY';
    }
    $response = $csv->export($entity, $metric, $endDate, $period, $options);
    return $response;
}

function validateRequest() {
    $errorMsg = "";
    if(!array_key_exists('entity', $_REQUEST)) {
        $errorMsg .= "ERROR: entity did not set.";
    }
    if(!array_key_exists('metric', $_REQUEST)) {
        $errorMsg .= "ERROR: metric did not set.";
    }
    if(!array_key_exists('endDate', $_REQUEST)) {
        $errorMsg .= "ERROR: endDate did not set.";
    }
    if(!array_key_exists('period', $_REQUEST)) {
        $errorMsg .= "ERROR: period did not set.";
    }
    return $errorMsg;
}
