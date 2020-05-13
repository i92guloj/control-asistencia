<!--  como admin, desde cambio-password.php -->
<!--  como admin, desde tabla-usuarios.php -->
<!--  como admin, desde tabla-picadas.php -->
<!-- como admin, desde tabla-incidencias.php -->

<!-- script para que al seleccionar un usuario recarge la página pasando y recogiendo por GET el usuario seleccionado para que así quede marcado -->
<!-- select-usuario.php sirve tanto para mostrar los usuarios en gestion-usuarios.php, como las picadas en dicho archivo -->
<!-- para decir a gestion-usuarios.php por donde tiene que continuar, se crea la variable flag, que tomará distinto valor según venga -->
 <!-- de tabla-usuarios.php, tabla-picadas.php o tabla-incidencias.php y se pasa por GET-->
<script>
	window.onload=function(){
		var lista=document.getElementById("dni");
		var flag='<?php echo $envio;?>'
		lista.onchange=seleccionarContacto; 

		function seleccionarContacto(){
			window.location="?dni_slc="+lista.value+"&flag="+flag
		}
	}
</script>


<?php
	error_reporting(E_ERROR);
	if(!$_SESSION["autenticado"])
		header("Location: salir.php");
	else{
		$consulta_usuarios="SELECT * FROM usuarios ORDER BY apellidos";
		$ejecutar_consulta_usuarios=$conexion->query($consulta_usuarios);
?>
	<b><label for="dni">Buscar usuario: </label></b>
	<select name="dni_slc" id="dni" required>
		<option value=default>(Mostrar todos)</option>
<?php			
			while($registro_usuarios=$ejecutar_consulta_usuarios->fetch_assoc()){
				$dni=$registro_usuarios["dni"];
				$nombrecompleto=$registro_usuarios["apellidos"].", ".$registro_usuarios["nombre"];
				echo "<option value='$dni'";
				if($dni==$_GET["dni_slc"])
					echo " selected>$nombrecompleto</option>";
				else
					echo ">$nombrecompleto</option>";
			}
?>
	</select>
<?php 
	}
?>