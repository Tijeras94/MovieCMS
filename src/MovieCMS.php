<?php
namespace MovieCMS;
use Medoo\Medoo; 
class MovieCMS
{
	function __construct(Router $router,  Medoo $db) {

		$router->setNamespace('MovieCMS\Controllers');

		$router->mount('/auth', function() use ($router) {
		    $router->post('/userLogin', 'Auth@userLogin');
		    $router->post('/userRegister', 'Auth@userRegister');
		});
 
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