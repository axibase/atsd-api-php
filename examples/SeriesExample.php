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
require_once '../atsdPHP/models/Series.php';
require_once '../atsdPHP/HttpClient.php';
require_once '../atsdPHP/Utils.php';
require_once '../atsdPHP/Constants.php';

$queryClient = new Series();
$queryClient->addDetailQuery('nurswgvml007', 'cpu_busy', 1424612226000, 1424612453000);

$aggregator = new Aggregator(array(AggregateType::AVG), array("count" => 1, "unit" => TimeUnit::HOUR));
$queryClient->addAggregateQuery('nurswgvml007', 'cpu_busy', 0, 1424612453000, $aggregator);
$queryClient->addQuery("nurswgvml007", "cpu_busy", array("startTime" => 0, "endTime" => 1424612453000, "limit" => "4"));
$response = $queryClient->execQueries();

$tables = array();
$tables[] = Utils::seriesAsHtml($response[0], "detail series");
$tables[] = Utils::seriesAsHtml($response[1], "aggregate series");
$tables[] = Utils::seriesAsHtml($response[2], "custom series");

Utils::render($tables);

