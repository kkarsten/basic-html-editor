<?php
	// Initialization
	require __DIR__.'/config/settings.php';
	require __DIR__.'/config/constants.php';

	// Dependencies by Composer
	$autoloader = require __VENDOR__.'/autoload.php';
	$autoloader->add('', __DIR__.'/models/');
	$autoloader->add('', __DIR__.'/controllers/');

	// Database by Spot ORM
	$db_config = new \Spot\Config();
	$db_config->addConnection('mysql', __DATABASE__);
	$db = new \Spot\Locator($db_config);

	// Templating by Twig
	$loader = new Twig_Loader_Filesystem(__DIR__ . '/views');
	$twig = new Twig_Environment($loader, array(
		'cache' => false
	));

	// Routing by AltoRouter
	$router = new AltoRouter();
	$routes = Symfony\Component\Yaml\Yaml::parse(file_get_contents("routing.yaml"));
	foreach ($routes as $route_name => $params) {
		$router->map($params[0],$params[1], $params[2], $route_name);
	}

	$match = $router->match();
	if($match && is_callable(explode("#", $match['target']))) {
		// Get the page's file and data
		$target = call_user_func_array( explode("#", $match['target']), array("data" =>$match['params']) );
		echo $twig->render($target["file"], array('data' => $target["data"], 'params' => $match["params"]));
	} else {
		// no route was matched
		header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
	}

	// De-initialization
	exit();
?>