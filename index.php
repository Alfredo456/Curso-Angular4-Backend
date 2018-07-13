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

//LISTAR TODOS LOS PRODUCTOS
$app->get('/productos',function() use($db, $app){
	$sql = 'SELECT * FROM productos ORDER BY id DESC;';
	$query = $db->query($sql);

	$productos = array();
	while($producto = $query->fetch_assoc())
	{
		$productos[] = $producto;
	}

	$result = array(
		'status'=> 'success',
		'code'=> 200,
		'data'=>$productos
	);
	//var_dump($query->fetch_all());
	echo json_encode($result);
});

//DEVOLVER UN SOLO PRODUCTO
$app->get('/producto/:id',function($id) use($db, $app){
	$sql = 'SELECT * FROM productos WHERE id = ' .$id;

	$query = $db->query($sql);

	$result = array(
		'status'=> 'error',
		'code'=> 404,
		'data'=>'Producto NO disponible'
	);

	if($query->num_rows == 1){
		$producto = $query -> fetch_assoc();
		$result = array(
			'status'=> 'success',
			'code'=> 200,
			'data'=>$producto
		);
	}
	else
	{

	}
	echo json_encode($result);
});

//ELIMINAR UN PRODUCTO
$app->get('/delete-producto/:id',function($id) use($db, $app){
	$sql = 'DELETE FROM productos WHERE id = '.$id;
	$query = $db->query($sql);

    $result = array(
		'status'=> 'error',
		'code'=> 404,
		'data'=>'Producto NO se ha eliminado'
	);
	if($query){
		$result = array(
			'status'=> 'success',
			'code'=> 200,
			'data'=>'Producto Eliminado'
		);
	}
	echo json_encode($result);
});

//ACTUALIZAR UN PRODUCTO
$app->post('/update-producto/:id',function($id) use($app,$db)
{
	$json = $app->request->post('json');
	$data = json_decode($json,true);

	if(!isset($data['imagen'])){
		$data['imagen']=null;
	}
	if(!isset($data['nombre'])){
		$data['nombre']=null;
	}
	if(!isset($data['descripcion'])){
		$data['descripcion']=null;
	}
	if(!isset($data['precio'])){
		$data['precio']=null;
	}

	$sql ="UPDATE productos SET ".
	"nombre = '{$data['nombre']}',".
	"descripcion = '{$data['descripcion']}',".
	"precio = '{$data['precio']}' WHERE id = {$id}";

	$query = $db->query($sql);

	//var_dump($sql);
	
	$result = array(
		'status'=> 'error',
		'code'=> 404,
		'message'=>'Producto No Actualizado'
	);

	if($query){
		$result = array(
			'status'=> 'success',
			'code'=> 200,
			'message'=>'Producto actualizado correctamente'
		);
	}

	echo json_encode($result);
});

//SUBIR UNA IMAGEN A UN PRODUCTO
$app->post('/upload-file',function() use($app, $db){
	$result = array(
		'status'=> 'error',
		'code'=> 404,
		'message'=>'El Archivo no ha podido subirse'
	);
	if(isset($_FILES['uploads'])){
		$piramideUploader = new PiramideUploader();
		$upload = $piramideUploader->upload('image',"uploads","uploads",array('image/jpeg','image/gif','image/png'));
		$file = $piramideUploader->getInfoFile();
		$file_name = $file['complete_name'];

		var_dump($file);

		if(isset($upload)&& $upload["uploaded"]==false)
		{
			$result = array(
				'status'=> 'error',
				'code'=> 404,
				'message'=>'El Archivo no ha podido subirse'
			);
		}
		else
		{
			$result = array(
				'status'=> 'success',
				'code'=> 200,
				'message'=>'El Archivo se ha subido'
			);
		}

	}

	echo json_encode($result);
});

//GUARDAR PRODUCTOS
$app->post('/productos',function() use($app,$db)
{
	$json = $app->request->post('json');
	$data = json_decode($json,true);
	//var_dump($json);
	//var_dump($data);

	if(!isset($data['imagen'])){
		$data['imagen']=null;
	}
	if(!isset($data['nombre'])){
		$data['nombre']=null;
	}
	if(!isset($data['descripcion'])){
		$data['descripcion']=null;
	}
	if(!isset($data['precio'])){
		$data['precio']=null;
	}
	$query="INSERT INTO productos VALUES(NULL,".
	"'{$data['nombre']}',".
	"'{$data['descripcion']}',".
	"'{$data['precio']}',".
	"'{$data['imagen']}'".
	");";

	//var_dump($query);

	$insert = $db->query($query);
	$result = array(
		'status'=> 'error',
		'code'=> 404,
		'message'=>'Producto No creado'
	);

	if($insert){
		$result = array(
			'status'=> 'success',
			'code'=> 200,
			'message'=>'Producto creado correctamente'
		);
	}

	echo json_encode($result);
});
$app->run();
