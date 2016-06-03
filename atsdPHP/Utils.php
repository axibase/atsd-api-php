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
class Utils {
    static $severities = array("undefined", "unknown", "normal", "warning", "minor", "major", "critical", "fatal");

    static function concat($str, $item) {
        $date = static::unixtimestamp($item['t']);
        $val = $item['v'];
        return $str . "<tr><td>{$date}</td><td>{$val}</td></tr>";
    }

    static function unixtimestamp($timestamp) {
        $timestamp = $timestamp / 1000;
        $date = new \DateTime();
        $date->setTimestamp($timestamp);
        return $date->format("Y-m-d H:i:s");
    }

    static function severity($sevetitycode) {
       return static::$severities[$sevetitycode];
    }

    static function seriesAsHtml($series, $header = "") {
        $output = '';
        foreach ($series as $series) {
            $body = array_reduce($series['data'], 'self::concat');
            if (count($series['data']) == 0) {
                $body = '<tr><td>Empty</td></tr>';
            }

            $output .= "<h2>" . $series['requestId'] . ": " . $header . "</h2>
            <table><thead><tr><th>time</th><th>value</th></tr></thead>" .
                "<tbody>{$body}</tbody>" .
                "</table>";
        }
        return $output;
    }

    static function arrayAsHtmlTable($dataArray = array(), $viewConfig) {
        $tbl = "<h2>" . $viewConfig->getTablename()  . "</h2>
        <table id='" . $viewConfig->getId() . "'>
        <thead>
        <tr>[[HEAD]]</tr>
        </thead>
        <tbody>[[BODY]]</tbody>
        </table>";
        $thead = "<th>Index</th>";
        $tbody = "";
        $uniqKeyList = array();
        foreach($dataArray as $dataset) {
            foreach($dataset as $key => $value) {
                if(!in_array($key, $uniqKeyList) && !is_array($value)) {
                    $uniqKeyList[] = $key;
                    $thead .= "<th>" . $key . "</th>";
                }
                if(is_array($value)) {
                    if(!array_key_exists($key, $uniqKeyList)) {
                        $uniqKeyList[$key] = array();
                    }
                    foreach($value as $tagskey => $tagsvalue) {
                        if(!in_array($tagskey, $uniqKeyList[$key])) {
                            $uniqKeyList[$key][] = $tagskey;
                            $thead .= "<th>" . $key . "." . $tagskey . "</th>";

                        }
                    }
                }
            }
        }
        $tbl = str_replace("[[HEAD]]", $thead, $tbl);
        $tbl = str_replace("[[COLSPANSIZE]]", count($uniqKeyList) + 1, $tbl);
        $i = 0;
        foreach($dataArray as $dataset) {
            $tbody .= "<tr><td>" . $i++ . "</td>";
            foreach($uniqKeyList as $keyname => $keyvalue) {
                $val = "";
                if(!is_array($keyvalue)) {
                   if(array_key_exists($keyvalue, $dataset)) {
                       $handler = $viewConfig->getHandler($keyvalue);
                       if(null == $handler) {
                           $val = $dataset[$keyvalue];
                       } else {
                           $val = call_user_func('self::' . $handler, $dataset[$keyvalue]);
                       }
                       $tbody .= "<td>" . $val . "</td>";
                   } else {
                       $tbody .= "<td></td>";
                   }
                } else {
                    foreach($keyvalue as $ifield) {
                        if(array_key_exists($keyname, $dataset)) {
                            if(array_key_exists($ifield, $dataset[$keyname])) {
                                $val .= "<td>" . $dataset[$keyname][$ifield] . "</td>";
                            } else {
                                $val .= "<td></td>";
                            }
                        } else {
                            $val .= "<td></td>";
                        }
                    }
                    $tbody .= $val;
                }
            }
            $tbody .= "</tr>";
        }
        $tbl = str_replace("[[BODY]]", $tbody, $tbl);

        return $tbl;

    }

    static function render($tables = array()) {
        $tpl = file_get_contents("example.tpl");
        $tablesHtml = "";
        foreach($tables as $table) {
            $tablesHtml .= $table;
        }
        $tpl = str_replace('[[TABLES]]', $tablesHtml, $tpl);
        echo $tpl;
    }

    static function propertyAsHtmlTable($propertiesArray, $viewConfig) {
        $tbl = "<h2>" . $viewConfig->getTablename() . "</h2>
        <table id='" . $viewConfig->getId() . "'>
        <thead><tr>[[HEAD]]</tr></thead>
        <tbody>[[BODY]]</tbody></table>";
        $thead = "<th>type</th><th>entity</th>";
        $tbody = "";
        $uniqHead = array();
        foreach($propertiesArray as $propertyArray) {
            foreach($propertyArray['key'] as $key => $propertyValues) {
                if($key != "keyValues") {
                    if (!array_key_exists($key, $uniqHead)) {
                        $uniqHead[] = $key;
                    }

                }
            }
        }
        foreach($uniqHead as $key) {
            $thead .= "<th>" . $key . "</th>";
        }
        $thead .= "<th>keyName</th><th>keyValue</th>";

        $tbl = str_replace('[[HEAD]]', $thead, $tbl);
        foreach($propertiesArray as $propertyArray) {
            foreach($propertyArray["tags"] as $key => $value) {
                $tbody .= "<tr><td>" . $propertyArray["type"] . "</td><td>" . $propertyArray["entity"] . "</td>";
                foreach($uniqHead as $hdr) {
                    $tbody .= "<td>" . $propertyArray["key"][$hdr] . "</td>";
                }
                $tbody .= "<td>" . $key . "</td>";
                $handler = $viewConfig->getHandler($key);
                if(null == $handler) {
                    $tbody .= "<td>" . $value . "</td>";
                } else {
                    $tbody .= "<td>" . call_user_func('self::' . $handler, $value) . "</td>";
                }
                $tbody .= "</tr>";
            }
        }
        $tbl = str_replace("[[BODY]]", $tbody, $tbl);
        return $tbl;

    }

}

class ViewConfiguration {
    private $id;
    private $keysHandlers;
    private $tablename;
    function __construct($tablename, $id, $keysHandlers = array()) {
        $this->tablename = $tablename;
        $this->id = $id;
        $this->keysHandlers = $keysHandlers;
    }

    function setHandler($key, $handler) {
        if(array_key_exists($key, $this->keysHandlers)) {
            $this->keysHandlers[$key] = $handler;
        } else {
            return null;
        }
    }

    function getId() {
        return $this->id;
    }

    function getTablename() {
        return $this->tablename;
    }

    function getHandler($key) {
        if(array_key_exists($key, $this->keysHandlers)) {
            return $this->keysHandlers[$key];
        } else {
            return "";
        }
    }


}


