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

class KPiotrowicz_OffEmptyConfProduct_IndexController extends Mage_Core_Controller_Front_Action
{
    public function IndexAction() 
    {
        echo "<pre>";
        $cronAction = Mage::getModel('offemptyconfproduct/Cron');
    }
}