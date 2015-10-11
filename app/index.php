<?php
	// Initialization
	require __DIR__.'/config/settings.php';
	require __DIR__.'/config/constants.php';

	// Dependencies
	$loader = require __VENDOR__.'/autoload.php';

	$router = new AltoRouter();

	$routes = Symfony\Component\Yaml\Yaml::parse(file_get_contents("routing.yaml"));
	foreach ($routes as $route_name => $params) {
		$router->map($params[0],$params[1], $params[2], $route_name);
	}

	$loader = new Twig_Loader_Filesystem(__DIR__ . '/views');
	$twig = new Twig_Environment($loader, array(
		// 'cache' => __CACHE__
		'cache' => false
	));

	$match = $router->match();
	// echo "<pre>";
	// var_dump($match);
	// echo "</pre>";
	
	// Load Template
	require 'controllers/ViewController.php';
	if($match && is_callable(explode("#", $match['target']))) {
		// Get the page's file and data
		$target = call_user_func_array( explode("#", $match['target']), array("data" =>$match['params']) ); 

		// Render the page, based on the file and data
		echo $twig->render($target["file"], array('data' => $target["data"], 'params' => $match["params"]));
	} else {
		// no route was matched
		header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
	}

	// De-initialization
?>