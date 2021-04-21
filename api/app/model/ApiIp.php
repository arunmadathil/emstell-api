<?php

namespace Product\model;

use Database\Db;
use PDO;

class ApiIp
{
    protected $table = "oc_api_ip";
    protected $db;
    public function __construct()
    {
        $this->db = (new Db())->connect_db();
    }

    public function create($api_id = null, $clientip = null)
    {
        $query = "INSERT INTO {$this->table} (api_id,ip)
          VALUES (:api_id, :ip)";
        $smt = $this->db->prepare($query);

        try {
            $this->db->beginTransaction();
            $smt->execute(array(':api_id' => $api_id, ':ip' =>  $clientip));
            $this->db->commit();
            return $this->db->lastInsertId();
        } catch (\PDOExecption  $e) {
            $this->db->rollback();
            print "Error!: " . $e->getMessage() . "</br>";
        }
    }
    public function update()
    {
        
    }
}
