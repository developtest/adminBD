<?php 
	class Privilegio 
	{
		 //Constructor
	    function __construct() {
	        global $DATA;
	        $this->DATA = $DATA;
	    }

	    function privilegios()
	    {
	    	$sql = "select * from PRIVILEGIO;";
	    	$rs = $this->DATA->Execute($sql);
	        if ( $rs->RecordCount()) {
	            while(!$rs->EOF){
	                $id                      	 = $rs->fields['id_privilegio'];
	                $info[$id]['id_privilegio']  = $rs->fields['id_privilegio'];
	                $info[$id]['privilegio']  	 = $rs->fields['privilegio'];
	                $rs->MoveNext();
	            }
	            $rs->Close();
	            return $info;
	        } else {
	            return false;
	        }
	    }

	    function getPrivilegio($id_privilegio)
	    {
	    	$sql = "select * from PRIVILEGIO WHERE id_privilegio = ?;";
	    	$rs = $this->DATA->Execute($sql, $id_privilegio);
	        if ( $rs->RecordCount()) {
	            while(!$rs->EOF){
	                $id                      	 = $rs->fields['id_privilegio'];
	                $info[$id]['id_privilegio']  = $rs->fields['id_privilegio'];
	                $info[$id]['privilegio']  	 = $rs->fields['privilegio'];
	                $rs->MoveNext();
	            }
	            $rs->Close();
	            return $info;
	        } else {
	            return false;
	        }
	    }

	    function tenPrivilegios($inicio)
	    {
	        $sql = "SELECT * FROM PRIVILEGIO LIMIT $inicio, 10";

	        $rs = $this->DATA->Execute($sql);
	        if ( $rs->RecordCount()) {
	            while(!$rs->EOF){
	                $id                       = $rs->fields['id_privilegio'];
	                $info[$id]['privilegio']  = $rs->fields['privilegio'];
	                
	                $rs->MoveNext();
	            }
	            $rs->Close();
	            return $info;
	        } else {
	            return false;
	        }
	    }

	    function nuevo($params) {
        $sql = "INSERT INTO PRIVILEGIO (privilegio) "
             . "VALUES(?)";

        $save = $this->DATA->Execute($sql, $params);
        if ($save){
            return true;
        } else {
            return false;
        }
    }
	
	function modificar($params) {
        $sql = "UPDATE PRIVILEGIO SET privilegio = ? WHERE id_privilegio = ?;";

        $update = $this->DATA->Execute($sql, $params);
        if ($update){
            return true;
        } else {
            return false;
        }
    }

    function eliminar($id_privilegio) {
        $sql = "DELETE FROM PRIVILEGIO WHERE id_privilegio = ?";
        $delete = $this->DATA->Execute($sql, $id_privilegio);
        if ($delete) {
            return true;
        } else {
            return false;
        }
    }
	}
?>