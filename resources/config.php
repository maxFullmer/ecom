<?php

// output buffering
ob_start();
session_start();

// defining application paths
defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR);
defined("TEMPLATE_FRONT") ? null : define("TEMPLATE_FRONT", __DIR__ . DS . "templates/front");
defined("TEMPLATE_BACK") ? null : define("TEMPLATE_BACK", __DIR__ . DS . "templates/back");

// defining database connections
defined("DB_HOST") ? null : define("DB_HOST", "localhost");
defined("DB_USER") ? null : define("DB_USER", "root");
defined("DB_PASS") ? null : define("DB_PASS", "");
defined("DB_NAME") ? null : define("DB_NAME", "ecom_db");

$connection = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

// store functionality
require_once("store_functions.php");
?>