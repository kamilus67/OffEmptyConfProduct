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
        
        $qtyProducts = $this->getQty();
        $query = "(SELECT attribute_id FROM
                   ".$this->getTable('eav_attribute')."
                   WHERE attribute_code LIKE 'status')";
        $resultsAttId = $readConnection->fetchAll($query)[0]['attribute_id'];
        $j = 0;
        $k = 0;
        foreach($qtyProducts as $row)
        {
            if($row['qty'] == 0)
            {
                $query = "UPDATE ".$this->getTable('catalog_product_entity_int')." 
                          SET value=2
                          WHERE attribute_id=$resultsAttId AND
                          entity_type_id=4 AND
                          value=1 AND
                          entity_id=".$row['product_conf'];
                $results[$j] = $readConnection->prepare($query);
                $results[$j]->execute();
                $updateRow = $results[$j]->rowCount();
                
                if($updateRow == 1)
                {
                    $this->addLog($row['product_conf'], 'disabled');
                }
                
                $j++;
            }
            elseif($row['qty'] > 0)
            {
                $query = "UPDATE ".$this->getTable('catalog_product_entity_int')." 
                          SET value=1
                          WHERE attribute_id=$resultsAttId AND
                          entity_type_id=4 AND
                          value=2 AND
                          entity_id=".$row['product_conf'];
                $results[$k] = $readConnection->prepare($query);
                $results[$k]->execute();
                $updateRow = $results[$k]->rowCount();
                
                if($updateRow == 1)
                {
                    $this->addLog($row['product_conf'], 'enabled');
                }
                
                $k++;
            }
        }
    }
    
    private function getQty()
    {
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        
        $query = "SELECT a.entity_id as conf_products,
                  GROUP_CONCAT(DISTINCT b.child_id SEPARATOR ',') as simple_products
                  FROM ".$this->getTable('catalog_product_entity')." a
                  INNER JOIN ".$this->getTable('catalog_product_relation')." b
                  ON a.entity_id = b.parent_id
                  WHERE a.type_id = 'configurable'
                  GROUP BY a.entity_id";
        $results = $readConnection->fetchAll($query);
        
        $query = "(SELECT attribute_id FROM
                   ".$this->getTable('eav_attribute')."
                   WHERE attribute_code LIKE 'status')";
        $resultsAttId = $readConnection->fetchAll($query)[0]['attribute_id'];
        
        $j = 0;
        foreach($results as $row)
        {
            $query = "SELECT SUM(a.qty) as qty
                      FROM ".$this->getTable('cataloginventory_stock_item')." a
                      INNER JOIN ".$this->getTable('catalog_product_entity_int')." b
                      ON a.product_id = b.entity_id
                      WHERE 
                      b.entity_type_id = 4 AND
                      b.attribute_id = $resultsAttId AND
                      b.value = 1 AND
                      a.product_id IN (".$row['simple_products'].")";
            $resultsQty[$j] = $readConnection->fetchAll($query)[0];
            $resultsQty[$j]['product_conf'] = $row['conf_products'];
            $j++;
        }
        
        return $resultsQty;
    }
}