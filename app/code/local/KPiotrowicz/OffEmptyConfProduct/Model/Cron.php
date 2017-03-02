<?php
/*
 *  Author: Kamil Piotrowicz
 *  Date: 02.03.2017
 *  Website: www.kamilpiotrowicz.pl
 *  Location: Warsaw, Poland
 *  
 *  Plugin: OffEmptyConfProduct 1.0
 *  Plugin description: Turning off the empty configurable products
 */

class KPiotrowicz_OffEmptyConfProduct_Model_Cron extends KPiotrowicz_OffEmptyConfProduct_Helper_Data
{
    public function __construct()
    {
        $this->offconfigurable();
    }
    
    public function offconfigurable()
    {
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        //$this->getTable("catalog_product_entity");
        //$results = $readConnection->fetchAll($query);
    }
}