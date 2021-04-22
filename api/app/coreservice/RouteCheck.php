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
            foreach ($routes as $url => $method) {
                if ((trim($url) == trim($uri[0])) && (trim($method) == $_SERVER['REQUEST_METHOD'])) {
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
