<?php
/*
 * Actions Method for all forms
 */

// DataBase
include_once '../data/dataBase.php';

// Classes
include_once '../classes/Usuario.php';
include_once '../classes/cPrivilegio.php';

//Abriendo Sesiones
session_start();

// Params    
$usuario     = new Usuario();
$oPrivilegio = new Privilegio();	

if (isset($_POST['opt'])) {
  $option = $_POST['opt'];
}

if (isset($_GET['opt'])) {
  $option = $_GET['opt'];
}

/* 
	----------------------
	 	USUARIO -> CRUD
	----------------------
*/

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

		// Modificar usuario
		if ( $option == 'mUsuario' ) 
		{
			//parametros
			 
			$nombre   		= $_POST['name'];
			$apellido 		= $_POST['apellido'];
			$user	 		= $_POST['user'];
		    $password 		= $_POST['password'];
		    $estado   		= $_POST['estado'];
		    $id_privilegio	= $_POST['id_privilegio'];
		    $id_usuario		= $_POST['id_usuario'];
			//$password  = base64_encode($usuario->encriptar($password));
			
			$params = array($nombre, $apellido, $user, $password, $estado, $id_privilegio, $id_usuario);
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
		    $idUsuario = $_GET['id_usuario'];
		    $delete    = $usuario->eliminar($idUsuario);
		    if ( $delete ) {
		        echo "done";
		    } else {
		        echo "error";
		    }
		}

/* 
	----------------------
	 	PRIVILEGIO -> CRUD
	----------------------
*/
		// Guardar Privilegio
		if($option=="nPrivilegio")
		{
			$privilegio = $_POST['privilegio'];

			$pack =  array($privilegio);

			$save = $oPrivilegio->nuevo($pack);
			if ($save) 
			{
				echo "done";
			} else {
				echo "error";
			}

		}

		// Modificar privilegio 
		if ( $option == 'mPrivilegio' ) 
		{
			//parametros 
			$privilegio 	= $_POST['privilegio']; 
			$id_privilegio	= $_POST['id_privilegio'];

			$pack = array($privilegio, $id_privilegio);
			$update = $oPrivilegio->modificar($pack);	
			if ( $update ) {
				echo "done";
			} else {
				echo "error";
			} 
		}

		//Eliminar Usuario
		if ( $option == 'ePrivilegio' ) {
		    //parametros
		    $id_privilegio = $_GET['id_privilegio'];
		    $delete    = $oPrivilegio->eliminar($id_privilegio);
		    if ( $delete ) {
		        echo "done";
		    } else {
		        echo "error";
		    }
		}


?>
