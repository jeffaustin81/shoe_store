<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Store.php";
    require_once __DIR__."/../src/Brand.php";
	
	use Symfony\Component\Debug\Debug;
    Debug::enable();
	
	use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app = new Silex\Application();
    
	$app['debug'] = true;
    
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
    
    $app->post("/delete_stores", function() use ($app) {
        Store::deleteAll();
        
        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'form_check' => false));

    });
    
    $app->get("/stores/{id}", function($id) use ($app) {
        $store = Store::find($id);
        
        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands' => $store->getBrands(), 'form_check' => false));
    });
    
    $app->get("/form_brand", function() use ($app) {
        $store = Store::find($_GET['store_id']);
        
        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands' => $store->getBrands(), 'form_check' => true));
    });
	
	return $app;
	
?>