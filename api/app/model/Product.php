<?php

namespace Product\model;

use Database\Db;
use Product\interfaceService\CrudInterface;
use PDO;

class Product implements CrudInterface
{

    protected $db;
    protected $table = "oc_product";
    protected $jointable = "oc_product_attribute";
    public function __construct()
    {
        $this->db = (new Db())->connect_db();
    }

    public function getData($product_id = null, $lang_id = null)
    {
        $smt_array = [];
        $query = "SELECT * FROM {$this->table} as P";
        if ($product_id && $lang_id) {
            #JOIN QUERY
            $query .= " inner join {$this->jointable} as A on A.product_id = P.product_id";
            $query .= " WHERE P.product_id = :product_id AND A.language_id = :language_id";
            #prepare statment params
            $smt_array = array(':product_id' => $product_id, ':language_id' => $lang_id);
        }
        $smt = $this->db->prepare($query);
        $smt->execute($smt_array);
        return $smt->fetchObject(__CLASS__);
    }

    public function exists($product)
    {
        $query = "SELECT EXISTS(SELECT 1 FROM {$this->table} WHERE product_id= :product_id LIMIT 1)";
        $smt = $this->db->prepare($query);
        $smt->execute(array(':product_id' => $product));
        if ($smt->fetch()[0]) {//if exists return 1
            return true;
        } else {
            return false;
        }
    }
}
