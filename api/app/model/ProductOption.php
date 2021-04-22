<?php

namespace Product\model;

use Database\Db;
use DateTime;
use PDO;

class ProductOption
{
    protected $table = "oc_product_option";
    protected $db;
    protected $datetime;
    public function __construct()
    {
        $this->datetime = new DateTime();
        $this->db = (new Db())->connect_db();
    }
    

    public function get($product_id)
    {
        $query = "SELECT opd.option_id as opt_id ,opd.name as opt_name FROM {$this->table} po join oc_option_description AS opd on opd.option_id = po.option_id where po.product_id = :product_id ";
        $smt = $this->db->prepare($query);
        $smt->execute(['product_id' => $product_id]);

        $result_arr = [];
        $count = 0;
        while ($row = $smt->fetch()) {
            $result_arr[$count]['option_id'] = $row['opt_id'];
            $result_arr[$count]['option_name'] = $row['opt_name'];
            // ##TO DO Fetch option values
            $result_arr[$count]['option_values'] = [
                [
                "option_value_id" => "",
                "option_value_name" => "",
                "price" => "100",
                ],
                [
                    "option_value_id" => "",
                    "option_value_name" => "",
                    "price" => "150",
                ]
        ]; 

            $count++;
        }
        return $result_arr;
    }

   
}
