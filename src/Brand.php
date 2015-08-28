<?php

    class Brand
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
            $this->name = (string) $new_name;
        }
        
        function getId()
        {
            return $this->id;
        }
        
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO brands (name)
            VALUES ('{$this->getName()}')");
            
            $this->id = $GLOBALS['DB']->lastInsertID();
        }
        
        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM stores_brands WHERE brand_id = {$this->getId()};");
        }
        
        static function deleteAll()
        {
            $GLOBALS ['DB']->exec("DELETE FROM brands;");
        }
        
        static function getAll()
        {
            $returned_brands = $GLOBALS['DB']->query("SELECT * from brands ORDER BY name;");
            
            $brands = array();
            
            foreach($returned_brands as $brand) {
                $name = $brand['name'];
                $id = $brand['id'];
                $new_brand = new brand($name, $id);
                array_push($brands, $new_brand);
            }
            return $brands;
        }
	}
?>