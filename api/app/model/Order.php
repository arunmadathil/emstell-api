<?php

namespace Product\model;

use Database\Db;
use DateTime;

class Order
{
    protected $table = "oc_order";
    protected $db;
    protected $datetime;
    protected $primaryKey = "order_id";
    public function __construct()
    {
        $this->datetime = new DateTime();
        $this->db = (new Db())->connect_db();
    }

    public function create(array $params)
    {
        $datetime =  $this->datetime;
        $params[] = $datetime->format('Y-m-d H:i:s');
        $params[] = $datetime->format('Y-m-d H:i:s');
    
        $query = "INSERT INTO `oc_order` (`invoice_no`, `invoice_prefix`, `paydo_invoice_id`, `store_id`,
            `store_name`, `store_url`, `customer_id`, `customer_group_id`, `firstname`, `lastname`, `email`, 
            `telephone`, `fax`, `custom_field`, `payment_firstname`, `payment_lastname`, `payment_company`,
            `payment_unit_type`, `address_name`, `payment_address_1`, `payment_address_2`, `payment_city`, 
            `payment_postcode`, `payment_country`, `payment_country_id`, `payment_zone`, `payment_zone_id`,
            `payment_address_format`, `payment_custom_field`, `payment_method`, `payment_code`, `shipping_firstname`, 
            `shipping_lastname`, `shipping_company`, `shipping_unit_type`, `shipping_address_1`, `shipping_address_2`, 
            `shipping_city`, `shipping_postcode`, `shipping_country`, `shipping_country_id`, `shipping_zone`, `shipping_zone_id`,
            `shipping_address_format`, `shipping_custom_field`, `shipping_method`, `shipping_code`, `comment`, `total`,
            `order_status_id`, `affiliate_id`, `commission`, `marketing_id`, `tracking`, `language_id`, `currency_id`,
            `currency_code`, `currency_value`, `ip`, `weight`, `forwarded_ip`, `user_agent`, `accept_language`, `date_added`, `date_modified`)
        VALUES (?, ?, ?, ?,?, ?, ?, ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, ?,?, ?, ?, ?,?,?, ?, ?,?, ?, ?, ?, ?, ?, 
                    ?, ?,?, ?,?,?,?,?,?,?,?,?,?,?,?, ?, ?,?, ?,?,?,?,?, ?, ?, ?,?, ?)";

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

    public function get($id)
    {
        $query = "SELECT * FROM {$this->table} where {$this->primaryKey} = :{$this->primaryKey}";
        $smt = $this->db->prepare($query);
        $smt->execute(["{$this->primaryKey}" => $id]);
        return $smt->fetchObject(__CLASS__);
    }
}
