<?php

namespace Product\coreservice;

class RouteCheck
{
    public static function checkHttpMethod()
    {
        $current_uri = $_SERVER["REQUEST_URI"];
        $uri = explode('?', $current_uri);
        if (isset($uri[0])) {
            $routes = include "../config/route.php";
            foreach ($routes as $key => $method) {
                if (($key == $uri[0]) && ($method == $_SERVER['REQUEST_METHOD'])) {
                    return true;
                }
            }
            return false;
        } else {
            echo "Somthing went wrong with url";
            exit;
        }
    }
}
