<?php
/*
 *  Author: Kamil Piotrowicz
 *  Date: 01.03.2017
 *  Website: www.kamilpiotrowicz.pl
 *  Location: Warsaw, Poland
 *  
 *  Plugin: OffEmptyConfProduct 1.0
 *  Plugin description: Turning off the empty configurable products
 */

class KPiotrowicz_OffEmptyConfProduct_Helper_Data extends Mage_Core_Helper_Abstract
{
    private function getTable($table)
    {
        $resource = Mage::getSingleton('core/resource');
        return $resource->getTableName($table);
    }
}