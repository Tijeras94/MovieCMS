<?php
namespace MovieCMS\Controllers;
use Respect\Validation\Validator as v;

/**
 * 
 */
class Auth
{
	
	function __construct()
	{
		
	}

	function userRegister(Medoo $db)
	{
		$usernameValidator = v::alnum()->noWhitespace()->length(1, 15);
		
		$errors = [];
		if(!$usernameValidator->validate(@$_POST['username']))
		{
			$errors['username'] = "invalid username";
		}
		if(!v::email()->validate(@$_POST['email']))
		{
			$errors['email'] = "invalid email address";
		}

		if(@$_POST['password'] != @$_POST['password_confirm'])
		{
			$errors['password'] = "password not the same";
		}



		echo $this->json_response($errors);
	}

	function userLogin()
	{	
		$userID = 132;
		$token = time() + (5 * 60 * 1000); // added 5 minutes
		$token = $token . "#" . $userID;
		$token = $token . "#" . md5("MovieCMS*&^%$/" . $token);
		echo $this->json_response( array('username' => $_POST['username'] , 'token' =>  $token));
	}

	function json_response($message = null, $code = 200)
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