<?php

$string = "test/test/test/fff/option1/value1/option5/value2";
$matches = explode("/",$string);
require("./library/BBFramework.php");
testUrl("test/test");
testUrl("test/test/index");
testUrl($string);
function testUrl($url)
{
	$fw = new BBFramework();
	print_r($fw->route($url));
}
