<?php

namespace Product\model;

use Database\Db;
use DateTime;

class OrderProduct
{
    protected $table = "oc_order_product";
    protected $db;
    protected $datetime;

    public function __construct()
    {
        // $this->datetime = new DateTime();
        $this->db = (new Db())->connect_db();
    }

    public function create(array $params)
    {
        $datetime =  $this->datetime;
        // $params[] = $datetime->format('Y-m-d H:i:s');
        // $params[] = $datetime->format('Y-m-d H:i:s');
    
        $query = "INSERT INTO `{$this->table}` ( `order_id`, `product_id`, `name`, `model`, `quantity`, `price`, `total`, `tax`, `reward`)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $smt = $this->db->prepare($query);
        try {
            $this->db->beginTransaction();
            $smt->execute($params);
            $db_id = $this->db->lastInsertId();
            $this->db->commit();
            return $db_id;
        } catch (\PDOExecption  $e) {
            $this->db->rollback();
            print "Error!: " . $e->getMessage() . "</br>";
        }
    }
}
