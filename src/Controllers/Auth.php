<?php
namespace MovieCMS\Controllers;
use Respect\Validation\Validator as v;

/**
 * 
 */
class Auth
{

	function userRegister( \Medoo\Medoo $db)
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

         if($db->count("users", [
                'username' => $_POST['username'],
            ]) > 0){
             $errors['username'] = "username already exists";
		}

        if($db->count("users", [
                'email' => $_POST['email'],
            ]) > 0){
            $errors['email'] = "email already exists";
        }

        if(\count($errors)> 0)
        {
            echo $this->json_response($errors);
            return;

        }

        $db->insert('users', [
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'password' => md5("MovieCMS*&^%$/" . $_POST['password'])
        ]);

        echo $this->json_response( array('username' => $_POST['username'] , 'token' =>  $this->makeToken( $db->id())));

    }

    function makeToken($userID)
    {
        $token = time() + (5 * 60 * 1000); // added 5 minutes
        $token = $token . "#" . $userID;
        $token = $token . "#" . md5("MovieCMS*&^%$/" . $token);
        return $token;
    }

    function userLogin( \Medoo\Medoo $db)
	{
        $res = $db->select("users", "*", [
            'AND' => [
                'OR' => [
                    'username' => $_POST['username'],
                    'email' => $_POST['username'],
                ],
                'password' => md5("MovieCMS*&^%$/" . $_POST['password'])
            ]
        ]);
        if(count($res) > 0)
        {
            $res = $res[0];
            echo $this->json_response( array('username' => $res['username'] , 'token' => $this->makeToken($res['id'])));
        }else{
            echo $this->json_response("Invalid credentials :(");
        }
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