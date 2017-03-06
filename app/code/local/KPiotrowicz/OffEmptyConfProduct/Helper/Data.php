<?php
/*
 *  Author: Kamil Piotrowicz
 *  Date: 03.03.2017
 *  Website: www.kamilpiotrowicz.pl
 *  Location: Warsaw, Poland
 *  
 *  Plugin: OffEmptyConfProduct 1.0
 *  Plugin description: Turning off the empty configurable products
 */

class KPiotrowicz_OffEmptyConfProduct_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getTable($table)
    {
        $resource = Mage::getSingleton('core/resource');
        return $resource->getTableName($table);
    }
    
    public function addLog($id, $disabled)
    {
        $txt = date("d-m-Y H:i:s")." - ";        
        switch($disabled)
        {
            case 'disabled': $txt .= "Turning OFF product with ID "; break;
            case 'enabled': $txt .= "Turning ON product with ID "; break;
            default: break;
        }
        $txt .= $id."\n";
        
        $src = "var/offproducts/log.txt";
        $data = file_get_contents($src);
        $data .= $txt;
        file_put_contents($src, $data);
    }
}