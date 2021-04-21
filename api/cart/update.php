<?php

require "../vendor/autoload.php";

use Product\controller\CartController;
use Product\coreservice\RouteCheck;

if (!RouteCheck::checkHttpMethod()) {
    header('HTTP/1.1 405');
    exit;
}
$product = new CartController;
$product->update();
