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

    class StoreTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Store::deleteAll();
            // Brand::deleteAll();
        }

        function test_getName()
        {
            $name = "Foot Locker";
            $test_store = new Store($name);

            $result = $test_store->getName();

            $this->assertEquals($name, $result);
        }
       
       function test_setName()
        {
            $name = "Foot Locker";
            $test_store = new Store($name, $id);
            
            $test_store->setName("Foot Action");
            
            $result = $test_store->getName();
            
            $this->assertEquals("Foot Action", $result);
        }
        
        function test_getId()
        {
            $name = "Foot Locker";
            $id = 1;
            $test_store = new Store($name, $id);

            $result = $test_store->getId();

            $this->assertEquals(true, is_numeric($result));
        }
        
        function test_save()
        {
            $name = "Foot Locker";
            $test_store = new Store($name, $id);
            $test_store->save();

            $result = Store::getAll();

            $this->assertEquals($test_store, $result[0]);
        }
        
        function test_getAll()
        {
            $name = "Foot Locker";
            $test_store = new Store($name);
            $test_store->save();
            
            $name2 = "Foot Action";
            $test_store2 = new Store($name2);
            $test_store2->save();

            $result = Store::getAll();

            $this->assertEquals([$test_store2, $test_store], $result);
        }
        
        function test_deleteAll()
        {
            $name = "Foot Locker";
            $test_store = new Store($name);
            $test_store->save();
            
            $name2 = "Foot Action";
            $test_store2 = new Store($name2);
            $test_store2->save();

            Store::deleteAll();
            $result = Store::getAll();

            $this->assertEquals([], $result);
        }                
        
    }
?>