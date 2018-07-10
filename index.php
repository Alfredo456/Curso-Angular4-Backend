<?php

require_once 'vendor/autoload.php';

$app = new \Slim\Slim();

$db = new mysqli('localhost','root','','curso_angular4');

$app->get("/pruebas",function() use($app, $db){
	echo "Hola mundo desde Slim PHP";
	//var_dump($db);
});

$app->get("/probando",function() use($app){
	echo "OTRO TEXTO CUALQUIERA";
});
$app->post('/productos',function() use($app,$db)
{
	$json = $app->request->post('json');
	$data = json_decode($json,true);
	var_dump($json);
	var_dump($data);
});
$app->run();
