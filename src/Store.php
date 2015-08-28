<?php

    class Store
    {
        private $name;
        private $id;

        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
        }

        function getName()
        {
            return $this->name;
        }
        
        function setName($new_name)
        {
            $this->name = $new_name;
        }
        
        function updateName($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE stores SET name = '{$new_name}'
                WHERE id = {$this->getId()}");
            $this->setName($new_name);
        }
        
        function getId()
        {
            return $this->id;
        }
        
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO stores (name) VALUES ('{$this->getName()}')");
            
            $this->id=$GLOBALS['DB']->lastInsertId();
        }
        
        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM stores_brands WHERE store_id = {$this->getId()};");
        } 
        
        static function getAll()
        {
            $returned_stores = $GLOBALS['DB']->query("SELECT * from stores ORDER BY name;");
            
            $stores = array();
            
            foreach($returned_stores as $store) {
                $name = $store['name'];
                $id = $store['id'];
                $new_store = new Store($name, $id);
                array_push($stores, $new_store);
            }
            return $stores;
        }
        
        function addBrand($brand_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO stores_brands (store_id, brand_id) VALUES ({$this->getId()}, {$brand_id});");
        }
        
        function getBrands()
        {
            $returned_brands = $GLOBALS['DB']->query("SELECT brands.* FROM
                brands JOIN stores_brands ON (brands.id = stores_brands.brand_id)
                JOIN stores ON (stores.id = stores_brands.store_id)
                WHERE stores.id = {$this->getId()}");

            $brands = array();
            foreach($returned_brands as $brand)
            {
                $name = $brand['name'];
                $id = $brand['id'];
                $new_brand = new Brand($name, $id);
                array_push($brands, $new_brand);
            }

            return $brands;
        }
        
        function deleteBrand($brand_id)
        {
            $GLOBALS['DB']->exec("DELETE FROM stores_brands WHERE brand_id = {$brand_id} AND store_id = {$this->id}");
        }
        
        function deleteAllBrands()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores_brands WHERE store_id = {$this->id}");
        }
        
        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores;");
        }
        
        static function find($search_id)
        {
            $found_store = null;
            $stores = Store::getAll();
            foreach($stores as $store) {
                $store_id = $store->getId();
                if ($store_id == $search_id) {
                  $found_store = $store;
                }
            }
            return $found_store;
        }
        
	}
?>