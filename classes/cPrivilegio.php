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
	                $info[$id]['privilegio']      	 = $rs->fields['privilegio'];
	                $rs->MoveNext();
	            }
	            $rs->Close();
	            return $info;
	        } else {
	            return false;
	        }
	    }
	}
?>