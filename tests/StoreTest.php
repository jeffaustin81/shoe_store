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

        // protected function tearDown()
        // {
        //     Store::deleteAll();
        //     Brand::deleteAll();
        // }

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
        
    }
?>