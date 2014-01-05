 <?php
	//Base de Datos
	include_once '../../data/dataBase.php';
	//Clases
	include_once '../../classes/cPrivilegio.php';
	session_start();
	
	$oPrivilegio = new Privilegio();
	
	if (isset($_GET['inicio'])){
	  $inicio=$_GET['inicio'];
	}else{
	  $inicio=0;
	}
	
	$vPrivilegio  = $oPrivilegio->tenPrivilegios($inicio);
?>
<style type="text/css">
.question {
  color: #000;
	position: absolute;
	display: inline;
	text-align: center;
	width: 174px;
	height: 78px;
	font-size: 13px;
	line-height: 1.5em;
	background: url('images/confirm/bubble.png') left top no-repeat;
	padding: 10px 0 0 0;
	text-shadow: 0px 1px 0px #fff;
	margin-left: -7em;
	margin-top: -6em;
	opacity: 0;
}

.yes, .cancel {
	margin-top: .5em;
	margin-right: .5em;
	cursor: pointer;
	display: inline-block;
	width: 63px;
	height: 21px;
	color: #fff;
	text-shadow: 0px 1px 0px #000;
	background: url('images/confirm/button.png') left top no-repeat;
}
</style>

<script type="text/javascript">	
	$(document).ready(function() {	
		//links
		$( ".link" ).each(function(){
		var link = $(this).attr('href');
		$( this ).bind ("click", function(){
			$('#main').empty();
			$('#main').load(link);
			return false;
			});
		});
		
		//pagination
		$( ".pagination" ).each(function(){
		var link = $(this).attr('href');
		$( this ).bind ("click", function(){
			$('#main').empty();
			$('#main').load(link);
			return false;
			});
		});
		
		$('.ask').click(function(e) {
			e.preventDefault();
			href = $(this).attr('href');
			if($(this).next('div.question').length <= 0){
				$(this).after('<div class="question">Delete Row?<br/> <span class="yes">Si</span><span class="cancel">No</span></div>');
				$('.question').animate({opacity: 1}, 300);$('.yes').live('click', function(){
					$("#main").load(href, function(){
						$("#main").load('pages/tables/vPrivilegio.php');
					});
					return false;
				});
				$('.cancel').live('click', function(){
					$(this).parents('div.question').fadeOut(300, function() {
						$(this).remove();
					});
				});
			}
		});
	});
</script>
	<a href="pages/privilegio.php" class="link">Añadir Privilegio</a>
	<br>
<?php 
	$impresos = 0;
	if ($vPrivilegio) { ?>
		<table cellpadding="0" cellspacing="0" width="100%" id="myTable" class="sortable_list">
			<thead>
				<tr>
					<th width="10"></th>
					<th>PRIVILEGIO</th> 
					<th class="option">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach($vPrivilegio as $id => $info){
						echo 	"<tr class='rows'>";
						echo 	"<td></td>";
						echo	"<td>".$info['privilegio']."</td>"; 
						echo	"<td class='options'>
								<a href='pages/privilegio.php?opt=mPrivilegio&id_privilegio=$id' class='link'><img src='images/icons/bedit.png'></a>
								<img src='images/icons/phs.gif'>
								<a href='classes/action.php?opt=ePrivilegio&id_privilegio=$id' class='ask'><img src='images/icons/bdelete.png'></a></td>";
						echo	"</tr>";
						$impresos++;
					}
				?>	
			</tbody>
		</table>
<?php
		if ($inicio==0){
		  echo "<< Anterior";
		}else{
			$anterior=$inicio-10;
			echo "<a href=\"tables/vPrivilegio.php?inicio=$anterior\" class='pagination' style='text-decoration:none;'><< Anterior</a>";		  
		}
		if ($impresos>=10){
		  $proximo=$inicio+10;
		  echo "<a href=\"tables/vPrivilegio.php?inicio=$proximo\" class='pagination' style='text-decoration:none;float:right;'>Siguiente >></a>";		  
		}else{
			echo "<label style='text-decoration:none;float:right;'>Siguiente >></label>";
		}
	} else {
		echo "<p>There are no users in your list!!!</p>";
	}
?>
<br/>
<br/>