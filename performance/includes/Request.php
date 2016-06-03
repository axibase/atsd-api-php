<?php
require_once(dirname(__FILE__)) . '/../../atsdPHP/HttpClient.php';
require_once(dirname(__FILE__)) . '/../../atsdPHP/models/EntityGroups.php';
require_once(dirname(__FILE__)) . '/../../atsdPHP/models/Entities.php';
use axibase\atsdPHP\HttpClient;
use axibase\atsdPHP\EntityGroups;
use axibase\atsdPHP\Entities;

class Request {
    const TIMEZONE = 'UTC';
    const APP_NAME = 'performance';
    private $selectedEntity;
    private $currentTab;
    private $timezone;
    private $propertyTypes;
    private $metrics;




    function __construct() {
        session_start();
        if(isset($_REQUEST['logout'])) {
            header('HTTP/1.1 401 Unauthorized');
        }
        if(!array_key_exists('PHP_AUTH_USER', $_SERVER)) {
            exit("Authentication required");
        }
        $this->timezone = new DateTimeZone(self::TIMEZONE);
        if(
            !array_key_exists('user', $_SESSION) ||
            $_SESSION['user'] != $_SERVER['PHP_AUTH_USER'] ||
            self::APP_NAME !=  $_SESSION['app']?:""
        ) {
            session_destroy();
            session_start();
            $_SESSION['user'] = $_SERVER['PHP_AUTH_USER'];
            $_SESSION['app'] = self::APP_NAME;
        }
        if(!array_key_exists('entities', $_SESSION) || isset($_REQUEST['refresh'])) {
            $this->cacheEntities();
        }
        $this->selectedEntity = null;
        $this->properties = array();
        $this->metrics = array();
        if(array_key_exists('entity', $_REQUEST)) {
            $this->selectedEntity = $_REQUEST['entity'];
            $this->metrics = $this->getAvailableMetrics($this->selectedEntity);
//            var_dump($this->metrics);
            $this->propertyTypes = $this->getAvailablePropertyTypes($this->selectedEntity);
        }
        $this->currentTab = "perf";
        if(array_key_exists('tab', $_REQUEST)) {
            $this->currentTab = $_REQUEST['tab'];
        }
    }

    function cacheEntities() {
        $user = $_SESSION['user'];
        $userToGroup = parse_ini_file('users-group.ini');
        if(!array_key_exists($user, $userToGroup) || $userToGroup[$user] == "") {
            exit("Can not find group for user " . $user);
        }
        $entities = array();
        $entityGroups = new EntityGroups();

        try {
            $response = $entityGroups->findEntities($userToGroup[$user]);
            if(!is_array($response)) {
                throw new Exception('Exception: "Can not execute findEntities query');
            }
            foreach($response as $entity) {
                $entities[] = $entity["name"];
            }
            $_SESSION['entities'] = $entities;
        } catch (Exception $e) {
            $matches = array();
            preg_match_all("/^.*Exception: (.*$)/", $e->getMessage(), $matches);
            trigger_error("Can not get entities for group <b>" . $userToGroup[$user] . "<b> from ATSD server with the following message: " . $matches[1][0]);
        }
    }


    function getAvailableMetrics($entity) {
        $entitiesClient = new Entities();
        $metrics = array();
        try {
            $response = $entitiesClient->findMetrics($entity);
            if(!is_array($response))
                throw new Exception('Exception: "Can not execute findMetrics query".');
            foreach($response as $metric) {
                $metrics[] = $metric['name'];
            };
        } catch (Exception $e) {
            $matches = array();
            preg_match_all("/^.*Exception: (.*$)/", $e->getMessage(), $matches);
            trigger_error("Can not get metrics for entity <b>" . $entity . "</b> from ATSD server with the following message: " . $matches[1][0]);

        }
        return $metrics;
    }



    function getAvailablePropertyTypes($entity) {
        $entitiesClient = new Entities();
        try {
            $properties = $entitiesClient->findPropertyTypes($entity);
            sort($properties);

        } catch (Exception $e) {
            $matches = array();
            preg_match_all("/^.*Exception: (.*$)/", $e->getMessage(), $matches);
            trigger_error("Can not get property types for entity <b>" . $entity . "</b> from ATSD server with the following message: " . $matches[1][0]);
            $properties = array();
        }
        return $properties;
    }


    public function __get($property) {
        if(!property_exists($this, $property)) {
            throw new Exception('property "' . $property . '" does not exist.');
        }
        return $this->$property;
    }


}
