<?php
namespace MovieCMS;
use Medoo\Medoo; 

class MovieCMS
{
	function __construct(Router $router,  Medoo $db) {
		$router->setNamespace('MovieCMS\Controllers');

		$router->mount('/api', function() use ($router) {
            $router->mount('/auth', function() use ($router) {
                $router->post('/userLogin', 'Auth@userLogin');
                $router->post('/userRegister', 'Auth@userRegister');
            });
		});
 
		$router->get('/', function() { echo 'Index'; });

		// 404 handler
	 	$router->set404(function() {
		    header('HTTP/1.1 404 Not Found');
		    echo MovieCMS::json_response("Invalid Entry Point :(");
		});

	 	//https://github.com/bramus/router
	 	$router->run();
	}

	static function json_response($message = null, $code = 200)
	{
	    // clear the old headers
	    header_remove();
	    // set the actual code
	    http_response_code($code);
	    // set the header to make sure cache is forced
	    header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
	    // treat this as json
	    header('Content-Type: application/json');
	    $status = array(
	        200 => '200 OK',
	        400 => '400 Bad Request',
	        422 => 'Unprocessable Entity',
	        500 => '500 Internal Server Error'
	        );
	    // ok, validation error, or failure
	    header('Status: '.$status[$code]);
	    // return the encoded json
	    return json_encode(array(
	        'status' => $code < 300, // success or not?
	        'message' => $message
	        ));
	}
}
?>