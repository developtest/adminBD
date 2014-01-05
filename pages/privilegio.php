<?php
	//Data
	include_once "../data/dataBase.php";

	//Clases
	include_once "../classes/Usuario.php";
	include_once "../classes/cPrivilegio.php";
	
	$usuario 		= new Usuario();
	$oPrivilegio	= new Privilegio();

	$option  = "";
	 
	$privilegio = "";
		
	if (isset($_GET['opt'])) {
		$option    		= $_GET['opt'];
		$id_privilegio 	= $_GET['id_privilegio'];
	}
	
	if ($option == "mPrivilegio") {
		$vPrivilegio = $oPrivilegio->getPrivilegio($id_privilegio);
		foreach ($vPrivilegio AS $id => $info) {
			$privilegio	= $info["privilegio"];	
		 
		}
	}
?>
<script src="js/jquery.form.js" type="text/javascript"></script>
<script type="text/javascript">	
	$(document).ready(function() {	
		var options = {
			target:       '#msg',
			beforeSubmit: validate, //validar
			success:      successful,
			clearForm:    true,
			resetForm:    true
		};

		$('#form').submit(function() {
			$(this).ajaxSubmit(options);
			return false;
		});
		
		//links
		$( "#privilegios" ).each(function(){
		var link = 'pages/tables/vPrivilegio.php';
		$( this ).bind ("click", function(){
			$('#main').empty();
			$('#main').load(link);
			return false;
			});
		});
	});
	
	function validate() {
		var form      = document.form;
		var is_error  = false;
		var msg       = null; 

		$("#msg").removeClass();
		//$('#submit-msg').hide().text('');
		$("#msg").hide().text('');

		if (!form.privilegio.value){
			msg = 'Por favor, ingrese el nombre del privilegio.';
			is_error = true;
		} 
			
		if (is_error == true) {
			$('#msg').text(msg).addClass('message warning').fadeIn('slow');
			return false;
		} else {
			msg = "Cargando informacion...";
			$("#msg").text(msg).addClass('message info').fadeIn('slow');
		}
		return true;
	}
  
	function successful(responseText, statusText){
		var msg;
		responseText = responseText.replace(/^\s*|\s*$/g,"");
		if (responseText == 'done'){
			$("#msg").removeClass();
			<?php
				if ($option == "mUsuario") {
					echo 'msg = "The user has been updated.";';
				}else{
					echo 'msg = "The new user has been saved.";';
				}
			?>
			$('#msg').text(msg).addClass('message success').fadeIn('slow');
			$("#main").load('pages/privilegio.php');
		} else  {
			$("#msg").removeClass();
			msg = "ERROR. PLEASE TRY AGAIN.";
			$('#msg').text(msg).addClass('message error').fadeIn('slow');
		}
	}
</script>
<div>
	<div id="msg" class="message info">Por favor, llena los campos requeridos</div>
	<br>
		<form id="form" name="form" action="classes/action.php" method="post">
		
		<?php
			if ($option == "mPrivilegio") {
				echo '<input type="hidden" name="id_privilegio" value="'.$id_privilegio.' "/>';
				echo '<input type="hidden" name="opt" value="mPrivilegio" />';
			}else{
				echo '<input type="hidden" name="opt" value="nPrivilegio" />';
			}
		?>
		Privilegio:<br>
		<input id="privilegio" type="text" name="privilegio" value="<?=$privilegio;?>" /><br>
		 
		<?php
			if ($option == "mPrivilegio") {
				echo '<input type="submit" value="UPDATE"/>';
			}else{
				echo '<input type="submit" value="SAVE"/>';
			}
		?>
		<input id="privilegios" type="button" value="Privilegios"/>
	</form>
</div>	