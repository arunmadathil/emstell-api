<?php

namespace Product\controller;

use DateTime;
use Product\model\Api;
use Product\model\ApiIp;
use Product\model\Cart;
use Product\model\Order;
use Product\model\OrderProduct;
use Product\model\OrderTotal;
use Product\model\Product;

class CartController
{
    public function add()
    {
        $product = (new Product);
        $quantity = 1;
        if (isset($_REQUEST['quantity'])) {
            $quantity = $_REQUEST['quantity'];
            if ($quantity < 1) {
                http_response_code(422);
                header('Content-Type: application/json');
                echo json_encode(
                    [
                        'status' => 'success',
                        'response' => [
                            'quantity' => 'Invalid Quantity!'
                        ]
                    ],
                    true
                );
                exit;
            }
        }
        if (
            isset($_REQUEST['product_id'])
            && isset($_REQUEST['lang_id'])
            &&  isset($_REQUEST['customer_id'])
        ) {
            $product_id = $_REQUEST['product_id'];
            if ($product->exists($product_id)) {
                $api = new Api;
                $api_data = $api->get();

                $product_data = $product->getData($product_id, $_REQUEST['lang_id']);
                $cart_params = [
                    'api_id' => $api_data['api_id'],
                    'customer_id' => 42,
                    'session_id' => 'ad20ca5864e93658c3' . time(), //Generate uinique session ID #### TO DO,
                    'product_id' => $product_data->product_id,
                    'recurring_id' => 0,
                    'option' => "[]",
                    'quantity' =>  $quantity,
                ];
                $cart = new Cart;
                $id = $cart->create($cart_params);
                // $cart_data = $cart->get($id);

                header('Content-Type: application/json');
                echo json_encode(
                    [
                        'status' => 'success',
                        'response' =>  []
                        // 'response' =>  $cart_data
                    ],
                    true
                );
            } else {
                http_response_code(422);
                header('Content-Type: application/json');
                echo json_encode(
                    [
                        'status' => 'failed',
                        'response' => [
                            'product_id' => 'Product doesnot exists!',
                        ]
                    ],
                    true
                );
            }
        } else {
            http_response_code(422);
            header('Content-Type: application/json');
            echo json_encode(
                [
                    'status' => 'failed',
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

    public function update()
    {
        $this->add();
    }

    public function checkout()
    {
        $product = (new Product);

        if (isset($_REQUEST['quantity'])) {
            $quantity = $_REQUEST['quantity'];
            if ($quantity < 1) {
                http_response_code(422);
                header('Content-Type: application/json');
                echo json_encode(
                    [
                        'status' => 'success',
                        'response' => [
                            'quantity' => 'Invalid Quantity!'
                        ]
                    ],
                    true
                );
                exit;
            }
        }
        print 1; exit;
        if (
            isset($_REQUEST['product_id'])
            && isset($_REQUEST['lang_id'])
            &&  isset($_REQUEST['customer_id'])
        ) {
            $product_id = $_REQUEST['product_id'];
            if ($product->exists($product_id)) {
               
                ##Cart
                $cart = new Cart;
                $cart_count = $cart->count($product_id, $_REQUEST['customer_id']);

                ##Product
                $product_data = $product->getData($product_id, $_REQUEST['lang_id']);

                ## Order
                ## Sample DATA
                 $order_params = [
                    '0', 'INV-2020-00', '0', '0', 'Raw Honey', 'rawhoney-kw.com/alpha/',
                    '1', '1', 'gulffoodkw', '', 'gulffoodkw@gmail.com', '+96566603944', '',
                    NULL, 'gulffoodkw', '', '', '', '', 'street 3', '', 'Hawalli', '', 'Kuwait',
                    '114', 'Hawalli', '1792', NULL, NULL, '7', 'Cod', 'gulffoodkw', '', '', '', 'street 3', '', 'Hawalli',
                    '', 'Kuwait', '114', 'Hawalli', '1792', NULL, NULL, 'Delivery Charge', 'flat.flat', NULL, '150.0000',
                    '1', '0', '0.0000', '0', '', '1', '4', 'KWD', '1.00000000', '', '', '', '', ''
                ];
                $order = new Order;
                $order_id = $order->create($order_params);
                // $order_data = $order->get($order_id);

                #order Product
                $order_product_parms = [
                    $order_id, $product_data->product_id,
                    'Iranian saffron', $product_data->model,
                    $cart_count[0],  $product_data->price,
                    ($cart_count[0] * $product_data->price),
                    '0.0000', '0'
                ];

                $order = new OrderProduct;
                $order->create($order_product_parms);

                #Order Total
                $order_total_parms = [
                    $order_id, 'sub_total', 
                    'Sub Total', ($cart_count[0] * $product_data->price), '0'
                ];
                $order = new OrderTotal;
                $order->create($order_total_parms);
                ////////Order Option table
                ##TO DO Store data order_option Table
                
                
                header('Content-Type: application/json');
                echo json_encode(
                    [
                        'status' => 'success',
                        'response' =>  []
                    ],
                    true
                );
            } else {
                http_response_code(422);
                header('Content-Type: application/json');
                echo json_encode(
                    [
                        'status' => 'failed',
                        'response' => [
                            'product_id' => 'Product doesnot exists!',
                        ]
                    ],
                    true
                );
            }
        }
    }

    public function view() //View product
    {   

        if (isset($_REQUEST['customer_id'])) 
        {
            $cart = (new Cart)->getCustomerCart($_REQUEST['customer_id']);
            header('Content-Type: application/json');
           
       
            if ($cart) {
              
                echo json_encode([ 'status' => 'sucess','response' => $cart], true);
            } else {
                http_response_code(200);
                echo json_encode([ 'status' => 'sucess','response' => []], true);
            }
        } else {
            http_response_code(422);
            header('Content-Type: application/json');
            echo json_encode(
                [
                    'status' => 'failed',
                    'response' => [
                        'customer_id' => 'Customer ID field is required!',
                    ]
                ],
                true
            );
        }
    }
}
