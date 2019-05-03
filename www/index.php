<?php
include_once "../vendor/autoload.php";
use Psr\Container\ContainerInterface;
use Medoo\Medoo;

$builder = new DI\ContainerBuilder();
//$builder->...
$builder->addDefinitions([
    Medoo::class => function (ContainerInterface $c) {
    $d = 	 new Medoo([
						// required
						'database_type' => 'mysql',
						'database_name' => 'MovieCMS',
						'server' => 'localhost',
						'username' => 'root',
						'password' => 'toor'
						 
					]);

    	return $d;
    }
]); 

$container = $builder->build();

$m = $container->get('MovieCMS\MovieCMS');
?>