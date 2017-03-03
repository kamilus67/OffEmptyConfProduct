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
            case TRUE: $txt .= "Turning OFF product with ID "; break;
            case FALSE: $txt .= "Turning ON product with ID "; break;
            default: break;
        }
        $txt .= $id."\n";
        
        $src = "var/offproducts/log.txt";
        $fp = fopen($src, 'r');
        $data = fread($fp, filesize($src));
        fclose($fp);
        $data .= $txt;
        $fp = fopen($src, "w");
        fputs($fp, $data);
        fclose($fp);
    }
}