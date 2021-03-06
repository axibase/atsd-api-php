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
require_once '../atsdPHP/models/Metrics.php';
require_once '../atsdPHP/HttpClient.php';
require_once '../atsdPHP/Utils.php';

$expression = 'name like \'nmon*\'';
$limit = 10;

$queryClient = new Metrics();

$params = array('limit' => $limit, 'expression' => $expression);
$responseMetrics = $queryClient->findAll($params);

$viewConfig = new ViewConfiguration('Metrics for expression: ' . $expression . "; limit: " . $limit, 'metrics', array('lastInsertTime' => 'unixtimestamp'));
$MetricsTbl = Utils::arrayAsHtmlTable($responseMetrics, $viewConfig);

$metric = "disk_used_percent";
$entity = "nurswgvml006";

$responseMetric = $queryClient->find($metric, array("entity" => $entity));

$viewConfig = new ViewConfiguration('Metric:' . $metric . ', entity: ' . $entity, 'metric', array('lastInsertTime' => 'unixtimestamp'));
$eattableEntity = Utils::arrayAsHtmlTable(array($responseMetric), $viewConfig);

$responseEntityAndTags = $queryClient->findEntityAndTags($metric);

$viewConfig = new ViewConfiguration('Entity and Tags for metric: ' . $metric, 'entAndTags');
$entityAndTagsTable = Utils::arrayAsHtmlTable($responseEntityAndTags, $viewConfig);

Utils::render(array($MetricsTbl, $eattableEntity, $entityAndTagsTable));
