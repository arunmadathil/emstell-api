<?php

namespace Product\coreservice;

class PreapareStatement
{
    public function insert(array $attributes, $table)
    {
        $query = "INSERT INTO {$table} (api_id,ip)";
        $colum_arr = [];
        $prepared_colum = "";
        $prepared_values = "";
        $values_arr = "";
        foreach ($attributes as $colum => $value) {
            $colum_arr[] = $colum;
            $values_arr[] = ':'.$colum;
        }
        $prepared_colum=  implode(",", $colum_arr);
    }
}
