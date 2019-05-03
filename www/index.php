<?php
include_once "../vendor/autoload.php";

$builder = new DI\ContainerBuilder();
//$builder->...
$container = $builder->build();

$m = $container->get('MovieCMS\MovieCMS');
?>