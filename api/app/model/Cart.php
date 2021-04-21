<?php

namespace Product\model;

use Database\Db;
use DateTime;

class Cart
{
    protected $table = "oc_cart";
    protected $db;
    protected $datetime;
    public function __construct()
    {
        $this->datetime = new DateTime();
        $this->db = (new Db())->connect_db();
    }
    public function create(array $params)
    {
        $datetime =  $this->datetime;
        $params['date_added'] = $datetime->format('Y-m-d H:i:s');

        $query = "INSERT INTO {$this->table} (`api_id`,`customer_id`,`session_id`,`product_id`,
        `recurring_id`,`option`,`quantity`,`date_added`)
        VALUES (:api_id, :customer_id, :session_id, :product_id,:recurring_id,:option,:quantity,:date_added)";

        $smt = $this->db->prepare($query);
        try {
            $smt_arr = array(
                ':api_id' => $params['api_id'], ':customer_id' =>  $params['customer_id'],
                ':session_id' => $params['session_id'], ':product_id' => $params['product_id'],
                ':recurring_id' => $params['recurring_id'], ':option' => $params['option'],
                ':quantity' => $params['quantity'], ':date_added' => $params['date_added']
            );
            $this->db->beginTransaction();
            $smt->execute($smt_arr);
            $db_id = $this->db->lastInsertId();
            $this->db->commit();
            return $db_id;
        } catch (\PDOExecption  $e) {
            $this->db->rollback();
            print "Error!: " . $e->getMessage() . "</br>";
        }
    }

    public function get($id)
    {
        $query = "SELECT * FROM {$this->table} where cart_id = :cart_id";
        $smt = $this->db->prepare($query);
        $smt->execute(['cart_id' => $id]);
        return $smt->fetchObject(__CLASS__);
    }

    public function count($product_id,$customer_id)
    {
        $query = "SELECT count(*) FROM {$this->table} where product_id = :product_id AND customer_id = :customer_id";
        $smt = $this->db->prepare($query);
        $smt->execute(['product_id' => $product_id,'customer_id' => $customer_id]);
        return $smt->fetch();
    }
    
    public function update(array $params)
    {
        $this->create($params);
    }

    public function delete($id = null, $product_id = null, $customer_id = null)
    {
        $query = "DELETE from {$this->table} where customer_id = :customer_id AND product_id = :product_id";
        try {
            $smt = $this->db->prepare($query);
            $this->db->beginTransaction();
            $smt->execute([':customer_id' => $customer_id, ':product_id' => $product_id]);
            if ($smt->rowCount() > 0) {
                $this->db->commit();
                return true;
            }
        } 
        catch (\PDOExecption $e) 
        {
            $this->db->rollback();
            print "Error!: " . $e->getMessage() . "</br>";
        }
    }
}
