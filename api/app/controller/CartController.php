<?php

namespace Product\controller;

use Product\model\Api;
use Product\model\ApiIp;
use Product\model\Product;

class CartController
{
    public function add()
    {
        $product = (new Product);
     
        if(isset($_REQUEST['product_id']) && isset($_REQUEST['lang_id']) &&  isset($_REQUEST['customer_id']))
        {
            $product_id = $_REQUEST['product_id'];
            if( $product->exists( $product_id )){
               $clientip = $_SERVER['REMOTE_ADDR'];
                $api = new Api;
                $api->create();
            }
            else{
                http_response_code(422);
                header('Content-Type: application/json');
                echo json_encode(
                    [
                        'response' => [
                            'product_id' => 'Product doesnot exists!',
                        ]
                    ],
                    true
                );
            }
        }
        else{
            http_response_code(422);
            header('Content-Type: application/json');
            echo json_encode(
                [
                    'response' => [
                        'product_id' => 'Product ID field is required!',
                        'lang_id' => 'Language id field is required!',
                        'customer_id' => 'Customer id field is required!',
                    ]
                ],
                true
            );
        }
    }
}
