<?php

namespace Product\model;

use Database\Db;
use DateTime;
use PDO;
use Product\coreservice\PreapareStatement;

class Api extends PreapareStatement
{
    protected $table = "oc_api";
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
        $params['date_modified'] = $datetime->format('Y-m-d H:i:s');

        $query = "INSERT INTO {$this->table} (`username`,`key`,`status`,`date_added`,`date_modified`)
        VALUES (:username, :key, :status, :date_added,:date_modified)";

        $smt = $this->db->prepare($query);
        try {
            $smt_arr = array(
                ':username' => $params['username'], ':key' =>  $params['key'],
                ':status' => 1, ':date_added' => $params['date_added'],
                'date_modified' => $params['date_modified']
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

    public function get(){
        
        $query = "SELECT * FROM {$this->table} ORDER BY api_id ASC LIMIT 1 "; 
        $smt = $this->db->prepare($query);
        $smt->execute();
        return $smt->fetch();
    }
}
