<?php
/*
 * Actions Method for all forms
 */

// DataBase
include_once '../data/dataBase.php';
// Classes
include_once '../classes/Usuario.php';
//Abriendo Sesiones
session_start();

// Params    
$usuario     = new Usuario();

if (isset($_POST['opt'])) {
  $option = $_POST['opt'];
}

if (isset($_GET['opt'])) {
  $option = $_GET['opt'];
}

/* ---- Usuario ---- */

//Guarda Nuevo Usuario
if ( $option == 'nUsuario' ) {
	//parametros
	$nombre   		= $_POST['name'];
	$apellido 		= $_POST['apellido'];
	$user	 		= $_POST['user'];
    $password 		= $_POST['password'];
    $estado   		= $_POST['estado'];
    $id_privilegio	= $_POST['id_privilegio'];
	//$password  = base64_encode($usuario->encriptar($password));
	
	$params = array($nombre, $apellido, $user, $password, $estado, $id_privilegio);
	$save   = $usuario->nuevo($params);
	if ( $save ) {
		echo "done";
	} else {
		echo "error";
	}
}

if ( $option == 'mUsuario' ) {
	//parametros
	$idUsuario = $_POST['idUsuario'];
	$nombre    = $_POST['name'];
	$usuarion  = $_POST['user'];
    $password  = $_POST['password'];
	$password  = base64_encode($usuario->encriptar($password));
	
	$params = array($nombre, $usuarion, $password, $idUsuario);
	$update = $usuario->modificar($params);
	if ( $update ) {
		echo "done";
	} else {
		echo "error";
	}
}

//Eliminar Usuario
if ( $option == 'eUsuario' ) {
    //parametros
    $idUsuario = $_GET['idUsuario'];
    $delete    = $usuario->eliminar($idUsuario);
    if ( $delete ) {
        echo "done";
    } else {
        echo "error";
    }
}

/* -----Usuario----- */

?>
