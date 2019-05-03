<?php
namespace MovieCMS;
use \Bramus\Router\Router;
class MovieCMS
{
	function __construct(Router $router) {



		// 404 handler
	 	$router->set404(function() {
		    header('HTTP/1.1 404 Not Found');
		});

	 	//https://github.com/bramus/router
	 	$router->run();
	}
}
?>