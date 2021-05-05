<?php

#LOAD DEPENDENCIES
require_once(realpath(dirname(__DIR__) . "/vendor/autoload.php"));

#ROUTES HELPER
define("BASE_PATH", realpath(dirname(__DIR__) . "/app"));
const MODELS = BASE_PATH . '/Models/';
const DB = BASE_PATH . '/Database/connection.php';

#DATABASE CONFIG
const DB_CONFIG = [
    "hostname" => "localhost",
    "username" => "root",
    "password" => "",
    "db_name" => "contextus",
    "charset" => "utf8"
];
