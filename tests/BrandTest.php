<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Brand.php";
    require_once "src/Store.php";

    $server = 'mysql:host=localhost:8889;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    
	$DB = new PDO($server, $username, $password);

    class BrandTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Store::deleteAll();
            Brand::deleteAll();
        }

        function test_getName()
        {
            $name = "Nike";
            $test_brand = new Brand($name);

            $result = $test_brand->getName();

            $this->assertEquals($name, $result);
        }
       
       function test_setName()
        {
            $name = "Nike";
            $test_brand = new Brand($name, $id);
            
            $test_brand->setName("Foot Action");
            
            $result = $test_brand->getName();
            
            $this->assertEquals("Foot Action", $result);
        }
        
        function test_getId()
        {
            $name = "Nike";
            $id = 1;
            $test_brand = new Brand($name, $id);

            $result = $test_brand->getId();

            $this->assertEquals(true, is_numeric($result));
        }
        
        function test_save()
        {
            $name = "Nike";
            $test_brand = new brand($name, $id);
            $test_brand->save();

            $result = Brand::getAll();

            $this->assertEquals($test_brand, $result[0]);
        }
        
        function test_delete()
        {
            $name = "Nike";
            $test_brand = new Brand($name, $id);
            $test_brand->save();
            
            $name2 = "Adidas";
            $test_brand2 = new Brand($name2, $id);
            $test_brand2->save();
            
            $test_brand->delete();

            $this->assertEquals([$test_brand2], Brand::getAll());
        }
    }
?>