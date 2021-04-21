<?php

namespace Product\controller;

use Product\model\Product;

class ProductController
{
    public function index() //Get lists of products
    {
        $products =  (new  Product)->getData();
        //Return result
        header('Content-Type: application/json');
        echo json_encode(['response' => $products], true);
    }

    public function view() //View product
    {

        if (isset($_REQUEST['product_id']) && isset($_REQUEST['lang_id'])) 
        {
            $products =  (new  Product)->getData($_REQUEST['product_id'], $_REQUEST['lang_id']);
            header('Content-Type: application/json');
            if ($products) {
                echo json_encode(['response' => $products], true);
            } else {
                http_response_code(200);
                echo json_encode(['response' => []], true);
            }
        } else {
            http_response_code(422);
            header('Content-Type: application/json');
            echo json_encode(
                [
                    'response' => [
                        'product_id' => 'Product ID field is required!',
                        'lang_id' => 'Language id field is required!'
                    ]
                ],
                true
            );
        }
    }
}
