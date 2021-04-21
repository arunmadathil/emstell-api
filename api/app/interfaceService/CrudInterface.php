<?php

namespace Product\interfaceService;

interface CrudInterface
{
    public function getData($product_id = null, $lang_id = null);
}
