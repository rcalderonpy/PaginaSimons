<?php
require 'connect.php';
	
	$id=$_GET['id'];
	
	function utf8_converter($array)
	{
	array_walk_recursive($array, function(&$item, $key){
		if(!mb_detect_encoding($item, 'utf-8', true)){
			$item = utf8_encode($item);
		}
	});

	return $array;
	}

	// consulta
	$query = $conexion->prepare('SELECT * FROM empleados WHERE idempleado=:id');
	$query->execute(array(':id'=>$id));
	$resultados=$query->fetch(PDO::FETCH_ASSOC);
	if($resultados!==false){
		$resultados=utf8_converter($resultados);
		print_r(json_encode($resultados));
	} else {
		$resultados=false;
	}

?>