<?php
namespace MovieCMS;
use \Bramus\Router\Router;
use Medoo\Medoo;

class MovieCMS
{
	function __construct(Router $router,  Medoo $db) {

		$router->get('/', function() { echo 'Index'; });

		// 404 handler
	 	$router->set404(function() {
		    header('HTTP/1.1 404 Not Found');
		});

	 	//https://github.com/bramus/router
	 	$router->run();
	}
}
?>