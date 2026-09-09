<?php
header("Pragma:no-cache",true);
header("Pragma-directive:no-cache",true);
header("cache-directive:no-cache",true);
header("Cache-Control:must-revalidate",true);
header("Cache-Control:max-age=0",true);
header("Expires:Tue, 01 Jan 1980 1:00:00 GMT",true);
header("Content-Language:pt-br",true);
//if ($_SERVER['SERVER_NAME'] == "localhost" || $_SERVER['SERVER_NAME'] == "pexinho" || $_SERVER['SERVER_ADDR'] == "127.0.0.1"):
if ($_SERVER['SERVER_ADDR'] == "192.168.1.249"):
	header("Content-Type:text/html;charset=UTF-8",true);
else:
	header("Content-Type:text/html;charset=ISO-8859-1",true);
endif;
?>