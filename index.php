<?php
include_once("./core/database.php");
include_once("./core/routes.php");
include_once("./core/const.php");
include_once("./core/ResponseSerializer.php");


$urlFull = str_replace(DOMAIN,"",$_SERVER["REQUEST_URI"]);

if(DOMAIN == "/")
{
    $urlFull = ltrim($_SERVER["REQUEST_URI"], "/");
}

$param = _sanitizeGet($_GET);

$urlFull = strtok($urlFull, '?'); // remove get
$url = explode("/",$urlFull);


$page =  $url[0];
$object = sizeof($url) > 1 ? $url[1] : "";
$action = sizeof($url) > 2 ? $url[2] : "";
$param = sizeof($url) > 3 ? $url[3] : "";

//var_dump($object);
//var_dump($action);
//var_dump($param);


if(array_key_exists($object,$routes))
{
    $controllerName = $routes[$object];

    require_once("Controllers/{$controllerName}".".php");

    $controller = new $controllerName();

    if ($_SERVER['REQUEST_METHOD'] != 'GET')
    {
        ResponseSerializer::RaiseError("Method not supported");
    }

    $controller->handle($action,$param);
}
else
{
    ResponseSerializer::RaiseError("Route not found");
}


function _sanitizeGet($get)
{
    $sanitized = array();

    foreach($get as $key => $field)
    {
        if($key != "p")
            $sanitized[$key] = htmlspecialchars($field);
    }

    return $sanitized;
}