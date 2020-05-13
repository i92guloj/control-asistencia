<!--  desde tabla-usuarios.php -->

<?php
	session_start();
	if(!$_SESSION["autenticado"] || !$_SESSION["admin"])
			header("Location: salir.php");
	else{
		$raiz="../";
		$titulo="Datos de usuario";
		include_once($raiz."cabecera.php");
		include ("conexion.php");
		$dni=$_SESSION["dni_sesion"];
		echo "<fieldset><h4>Bienvenido: ".($_SESSION["nombre_sesion"])."</h4>";
		// si se le da a volver, se pasa por GET el home para que gestion-usuarios.php muestre todos los usuarios, no las picadas
		echo "<div id='div-izquierdo'><form action='gestion-usuarios.php?home' method='POST'><input type='submit' name='volver_btn' value='Volver'></form></div>";
		echo "<div id='div-derecho'><form action='salir.php'><input type='submit' value='Cerrar sesión'></form></div></fieldset>";
?>

	<div class="div-adduser">
		<br>
		<img src="../img/new-user.jpg" height=auto width="20%">
		<form action="grabar-usuario.php" method="post" name="addusuario_frm">
		 		
			<label for="nuevo_dni">DNI (sin letra) </label>
			<input type="text" class="input-adduser" id="dni" name="nuevo_dni_txt" minlength="8" maxlength="8" autocomplete="off" required pattern="[0-9]{8}">
			<br>
			<label for="nuevo_nombre">Nombre </label>
			<input type="text" class="input-adduser" id="nombre" name="nuevo_nombre_txt" autocomplete="off" required>
			<br>
			<label for="nuevos_apellidos">Apellidos </label>
			<input type="text" class="input-adduser" id="apellidos" name="nuevos_apellidos_txt" autocomplete="off" required>
			<br>
			<label for="password">Password </label>
			<input type="password" class="input-adduser" id="paswword" name="nuevo_password_txt" autocomplete="off" required>
			<br>
			<label for="confirmapassword">Repite Password </label>
			<input type="password" class="input-adduser" id="r-paswword" name="confirma_nuevo_password_txt" autocomplete="off" required>
			<br>
			<label for="fecha">Fecha de alta </label>
			<input type="date" class="input-adduser" id="fecha-alta" name="fecha_alta" autocomplete="off" required>
			<div>
	      		<input type="radio" value="0" id="radioOne" name="gender" checked>
	      		<label for="radioOne" class="radio">Empleado</label>
	      		<input type="radio" value="1" id="radioTwo" name="gender">
	      		<label for="radioTwo" class="radio">Administrador</label>
	    	</div>
			<input type="submit" name="addusuario_btn" value="Grabar usuario">
		</form>	
		</div>
<?php 
		include("mensajes.php");
		$conexion->close();
	}
?>

