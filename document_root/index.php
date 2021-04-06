<?php
require("../app/library/BBFramework.php");
require("../app/library/BBRegistry.php");
require("../app/library/BBControllerAbstract.php");
require("../config/config.php"); 
require("../vendor/autoload.php"); // Composer
define("APP_DIR", dirname(__DIR__ . "..") . "/app");
spl_autoload_register('BBFramework::autoLoad',true,true);

$fw = new BBFramework();
// Connect to mysql, on failure re-route to DB error page
$mysqlConn = new mysqli(MYSQL_HOST,MYSQL_USER,MYSQL_PASS,MYSQL_DB);
if($mysqlConn->connect_error)
	$fw->route("/error/database");
BBRegistry::set("mysql", $mysqlConn); // save in global registry

// Connect to redis, on failure reroute to Redis error page
$redisConn = new Redis();
$redisConn->connect(REDIS_HOST,REDIS_PORT);
if(!$redisConn->ping())
	$fw->route("/error/redis");
BBRegistry::set("redis", $redisConn); // save in global registry

// Route request
$fw->route();  
