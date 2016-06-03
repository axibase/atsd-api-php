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
require_once '../atsdPHP/models/Alerts.php';
require_once '../atsdPHP/HttpClient.php';
require_once '../atsdPHP/Utils.php';

$entity = "nurswgvml007";

$queryClient = new Alerts();

$jsonObj = json_decode('{"queries": [{"entities": ["' . $entity . '"]}]}');
$response = $queryClient->find($jsonObj);

$viewConfig = new ViewConfiguration("Alerts for entity: " . $entity, "alerts", array('severity' => 'severity', 'openTime' => 'unixtimestamp', 'lastEventTime' => 'unixtimestamp'));
$tbl = Utils::arrayAsHtmlTable($response, $viewConfig);

Utils::render(array($tbl));
