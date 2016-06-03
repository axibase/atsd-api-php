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
class HttpClient
{
    const CONFIG = 'atsd.ini';
    private static $instance = null;
    private static $curlOpts = array(
        CURLOPT_HTTPHEADER => array('content-Type: application/json', 'charset=utf-8', 'Connection: keep-alive'),
        CURLOPT_RETURNTRANSFER => true
    );
    private $url;
    private $username;
    private $password;
    private $curlHandler;


    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new HttpClient();

        }
        return self::$instance;
    }

    private function __construct() {

        if (!function_exists('curl_version')) {
            echo "ERROR: can not find curl extension.";
            die();
        }
        $iniArray = parse_ini_file(self::CONFIG);
        if (array_key_exists('url', $iniArray) && array_key_exists('username', $iniArray) && array_key_exists('password', $iniArray)) {
            $this->url = $iniArray["url"];
            $this->username = $iniArray["username"];
            $this->password = $iniArray["password"];
        } else {
            throw new \Exception("url, username or password is not set.");
        }
        $this->curlHandler = curl_init();
        curl_setopt_array($this->curlHandler, self::$curlOpts);
        curl_setopt($this->curlHandler, CURLOPT_USERPWD, "$this->username:$this->password");
        register_shutdown_function(function(){
            curl_close($this->curlHandler);
            $this->curlHandler = null;
        });
    }

    public function query($uri, $postdata = null) {
        if ($this->curlHandler == null) {
            throw new \Exception("Need to connect first.");
        }
        if ($postdata === null) {
            curl_setopt($this->curlHandler, CURLOPT_POST, false);
            curl_setopt($this->curlHandler, CURLOPT_URL, $this->url . $uri);
        } else {
            curl_setopt($this->curlHandler, CURLOPT_POST, true);
            curl_setopt($this->curlHandler, CURLOPT_URL, $this->url . $uri);
            curl_setopt($this->curlHandler, CURLOPT_POSTFIELDS, json_encode($postdata));
        }

        $response = curl_exec($this->curlHandler);

        $responseContentType = curl_getinfo($this->curlHandler, CURLINFO_CONTENT_TYPE);
        if (strpos($responseContentType, "json") !== false) {
            $response = json_decode($response, true);

            if ($response === null) {
                throw new \ErrorException("ERROR: " . var_export(curl_getinfo($this->curlHandler), true));
            }
            if (array_key_exists("error", $response) && isset($response["error"])) {
                throw new \ErrorException('ERROR: ' . $response['error']);
            }
        }
        return $response;
    }
}


