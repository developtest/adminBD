<?php
	//Data
	include_once "../data/dataBase.php";

	//Clases
	include_once "../classes/Usuario.php";
	
	$usuario = new Usuario();
	
	$option  = "";
	$nombre  = "";
	$usuarin = "";
	$passwd  = "";
		
	if (isset($_GET['opt'])) {
		$option    = $_GET['opt'];
		$idUsuario = $_GET['idUsuario'];
	}
	
	if ($option == "mUsuario") {
		$vUsuario = $usuario->getUsuario($idUsuario);
		foreach ($vUsuario AS $id => $info) {
			$nombre  = $info["nombre"];
			$usuarin = $info["usuario"];
			$passwd  = $info["passwd"];
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
		$( "#users" ).each(function(){
		var link = 'pages/tables/vUsuario.php';
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
		var pwd1      = form.password.value;
		var pwd2      = form.cpassword.value;

		$("#msg").removeClass();
		//$('#submit-msg').hide().text('');
		$("#msg").hide().text('');

		if (!form.name.value){
			msg = 'Please, Type the name of the user.';
			is_error = true;
		}else if(!form.user.value){
			msg = 'Please, Fill the nick name field.';
			is_error=true;
		}else if(!form.password.value){
			msg = 'Please, Type a password';
			is_error=true;
		}else if(!form.cpassword.value){
			msg = 'Please, confirm the password.';
			is_error=true;
		}else if(pwd1 != pwd2){
			msg = 'The password are diferent.';
			is_error=true;
		}
			
		if (is_error == true) {
			$('#msg').text(msg).addClass('message warning').fadeIn('slow');
			return false;
		} else {
			msg = "Loading information...";
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
			$("#main").load('pages/usuario.php');
		} else  {
			$("#msg").removeClass();
			msg = "ERROR. PLEASE TRY AGAIN.";
			$('#msg').text(msg).addClass('message error').fadeIn('slow');
		}
	}
</script>
<div>
	<div id="msg" class="message info">Please, Fill all the fields</div>
	<br>
	<form id="form" name="form" action="classes/action.php" method="post">
		<?php
			if ($option == "mUsuario") {
				echo '<input type="hidden" name="idUsuario" value="'.$idUsuario.' "/>';
				echo '<input type="hidden" name="opt" value="mUsuario" />';
			}else{
				echo '<input type="hidden" name="opt" value="nUsuario" />';
			}
		?>
		Name:<br>
		<input id="name" type="text" name="name" value="<?=$nombre;?>" /><br>
		Nick Name:<br>
		<input id="user" type="text" name="user" value="<?=$usuarin;?>" /><br>
		Password:<br>
		<input id="password" type="password" name="password" value="<?=$passwd;?>" /><br>
		Confirm the Password:<br>
		<input id="cpassword" type="password" name="cpassword" value="<?=$passwd;?>" />
		<br>
		<?php
			if ($option == "mUsuario") {
				echo '<input type="submit" value="UPDATE"/>';
			}else{
				echo '<input type="submit" value="SAVE"/>';
			}
		?>
		<input id="users" type="button" value="USERS"/>
	</form>
</div>	