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
require_once(dirname(__FILE__) . '/../atsdPHP/BasicApiProxy.php');

class ApiProxy extends BasicApiProxy {
    function validateSeries($string) {
        $data = json_decode($string, true); //check that cached entities contains each of the entities in the request.
	if(!is_array($data)) {
		return false;
	}
        foreach($data as $query) {
            if(!in_array($query['entity'], $_SESSION['entities'])) {
                return false;
            }
        }
        return true;
    }

    function validateProperties($string) {
        $data = json_decode($string, true); //check that cached entities contains each of the entities in the request.
	if(!is_array($data)) {
		return false;
	}
        foreach($data as $query) {
            if(!in_array($query['entity'], $_SESSION['entities'])) {
                return false;
            }
        }
        return true;
    }
}

session_start();
if(!array_key_exists('user', $_SESSION)) {
    exit("Authentication required.");
}
session_commit();
$proxy = new ApiProxy();
$query = $proxy->getPost();
if(strlen($query) == 0) {
    return "query is not set.";
}

$type = array_key_exists('type', $_GET)?$_GET['type']:'default';
switch ($type) {
    case 'series':
        $response = $proxy->seriesJsonQuery($query);
        break;

    case 'properties':
        $response = $proxy->propertiesJsonQuery($query);
        break;

    default:
        $response = "";
        break;
}

header('Content-Type: application/json; charset=UTF-8;');
ob_start('ob_gzhandler');
echo json_encode($response);
ob_end_flush();

exit();

