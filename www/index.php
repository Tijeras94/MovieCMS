<?php
include_once "../vendor/autoload.php"; 
use Medoo\Medoo;

$container = new MovieCMS\Container;


$container->addDefinitions([
    Medoo::class => function () {
    $d = new Medoo([
            // required
            'database_type' => 'mysql',
            'database_name' => 'MovieCMS',
            'server' => 'localhost',
            'username' => 'root',
            'password' => 'toor'
        ]);
    	return $d;
    },
    \MovieCMS\Router::class => function() use ($container)
    {
        return new \MovieCMS\Router($container);
    }
    ]);

//init entry point
$m = $container->get("\MovieCMS\MovieCMS");

?>