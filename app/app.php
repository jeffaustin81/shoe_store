<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Store.php";
    require_once __DIR__."/../src/Brand.php";
	
    // This enables debug for silex to 
    // to display more information about
    // any errors
	use Symfony\Component\Debug\Debug;
    Debug::enable();
	
    // This enables the use of patch and delete
    // on your silex routes
	use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app = new Silex\Application();
    
	$app['debug'] = true;
    
    // Database setup
	$server = 'mysql:host=localhost:8889;dbname=shoes';
    $username = 'root';
    $password = 'root';
    
	$DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));
	
	$app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'form_check' => false));
    });
    
    $app->get("/form_store", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'form_check' => true));
    });
    
    $app->post("/add_store", function() use ($app) {
        $store = new Store($_POST['type']);
        $store->save();

        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'form_check' => false));
    });
    
    $app->get("/form_store_update", function() use ($app) {
        $store = Store::find($_GET['store_id']);
        
        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands' => $store->getBrands(), 'store_update' => true, 'form_check' => false));
    });
    
    // This route updates a specific store
    $app->patch("/update_store", function() use ($app) {
        $name = $_POST['name'];
        $store_id = $_POST['store_id'];

        $store = Store::find($store_id);
        $store->updateName($name);

        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands' => $store->getBrands(), 'store_update' => false, 'form_check' => false));
    });
        
    $app->post("/delete_stores", function() use ($app) {
        Store::deleteAll();
        
        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'form_check' => false));

    });
    
    $app->get("/stores/{id}", function($id) use ($app) {
        $store = Store::find($id);
        
        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands' => $store->getBrands(), 'form_check' => false, 'store_update' => false));
    });
    
    // This route deletes specific store
    $app->delete("/delete_store/{id}", function($id) use ($app) {
        
        $id = $_POST['store_id'];
        $store = Store::find($id);
        $store->delete();

        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'form_check' => false));
    });
    
    $app->get("/form_brand", function() use ($app) {
        $store = Store::find($_GET['store_id']);
        
        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands' => $store->getBrands(), 'form_check' => true, 'store_update' => false));
    });
    
    $app->post("/add_brand", function() use ($app) {
        $name = $_POST['name'];
        $brand = new Brand($name, $id = null);
        $brand->save();
        
        $store_id = $_POST['store_id'];
        $store = Store::find($store_id);
        $store->addBrand($brand->getId());
        
        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands' => $store->getBrands(), 'form_check' => false, 'store_update' => false));
    });
    
    // This route deletes a specific brand from a store
    $app->delete("/delete_brand/{id}", function($id) use ($app) {
        
        $id = $_POST['brand_id'];
        $store_id = $_POST['store_id'];
        
        $store = Store::find($store_id);
        $store->deleteBrand($id);

        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands' => $store->getBrands(), 'form_check' => false, 'store_update' => false));
    });
    
    
	
	return $app;
	
?>