<?php
class Usuario {

    //Constructor
    function __construct() {
        global $DATA;
        $this->DATA = $DATA;
    }

    function ingreso($usuario, $contrasenia)
    {
		//$cifradoHash = base64_encode($this->encriptar($contrasenia));
        $sql = "SELECT * FROM USUARIO "
             . "WHERE usuario = ? AND contrasena = ?";

        $rs = $this->DATA->Execute($sql, array($usuario, $contrasenia));
        if ( $rs->RecordCount() > 0 ) {
            session_start();
            $idUsuario            = $rs->fields['id_usuario'];
            $usuario              = $rs->fields['usuario'];
            $_SESSION['id']       = $idUsuario;
            $_SESSION['user']     = $usuario;
            $_SESSION['status']   = "authenticate";
            return true;
        } else {
            return false;
        }
    }

    function verSession()
    {
        session_start();
        if (isset($_SESSION['status'])) {
            $status = $_SESSION['status'];
            if ($status == "authenticate") {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function usuarios($opt = false, $inicio)
    {
        $sql = "SELECT id_usuario, nombre, usuario "
             . "FROM USUARIO";
        if ($opt) {
            $sql .= " WHERE id_usuario <> 1";
        }
			$sql .= " LIMIT $inicio, 10";

        $rs = $this->DATA->Execute($sql);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){
                $id                       = $rs->fields['id_usuario'];
                $info[$id]['nombre']      = $rs->fields['nombre'];
                $info[$id]['usuario']     = $rs->fields['usuario'];
                $rs->MoveNext();
            }
            $rs->Close();
            return $info;
        } else {
            return false;
        }
    }
	
	function getUsuario($id_usuario)
    {
        $sql = "SELECT id_usuario, nombre, apellido, usuario, contrasena, estado, id_privilegio "
             . "FROM USUARIO WHERE id_usuario = ?";

        $rs = $this->DATA->Execute($sql, $id_usuario);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){
                $id                             = $rs->fields['id_usuario'];
                $info[$id]['nombre']            = $rs->fields['nombre'];
                $info[$id]['apellido']          = $rs->fields['apellido'];
                $info[$id]['usuario']           = $rs->fields['usuario'];
                $info[$id]['contrasena']        = $rs->fields['contrasena'];
                $info[$id]['estado']            = $rs->fields['estado'];
                $info[$id]['id_privilegio']     = $rs->fields['id_privilegio'];
				//$info[$id]['passwd']      = trim($this->desencriptar(base64_decode($rs->fields['contrasenia'])));
                $rs->MoveNext();
            }
            $rs->Close();
            return $info;
        } else {
            return false;
        }
    }

    function nuevo($params) {
        $sql = "INSERT INTO USUARIO (nombre, apellido, usuario, contrasena, estado, id_privilegio) "
             . "VALUES(?, ?, ?, ?, ?, ?)";

        $save = $this->DATA->Execute($sql, $params);
        if ($save){
            return true;
        } else {
            return false;
        }
    }
	
	function modificar($params) {
        $sql = "UPDATE USUARIO SET nombre = ?, apellido = ?, usuario = ?, contrasena = ?, "
                    . "estado = ?, id_privilegio = ? WHERE id_usuario = ?;";

        $update = $this->DATA->Execute($sql, $params);
        if ($update){
            return true;
        } else {
            return false;
        }
    }

    function eliminar($idUsuario) {
        $sql = "DELETE FROM USUARIO WHERE id_usuario = ?";
        $delete = $this->DATA->Execute($sql, $idUsuario);
        if ($delete) {
            return true;
        } else {
            return false;
        }
    }
	
	function encriptar($cadena, $clave = "tfbf515t3m4")
    {
        $cifrado = MCRYPT_RIJNDAEL_256;
        $modo = MCRYPT_MODE_ECB;
        return mcrypt_encrypt($cifrado, $clave, $cadena, $modo,
            mcrypt_create_iv(mcrypt_get_iv_size($cifrado, $modo), MCRYPT_RAND)
        );
    }

    function desencriptar($cadena, $clave = "tfbf515t3m4")
    {
        $cifrado = MCRYPT_RIJNDAEL_256;
        $modo = MCRYPT_MODE_ECB;
        return mcrypt_decrypt($cifrado, $clave, $cadena, $modo,
            mcrypt_create_iv(mcrypt_get_iv_size($cifrado, $modo), MCRYPT_RAND)
        );
    }
}
?>