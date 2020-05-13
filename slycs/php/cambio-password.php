<!--  desde control-panel.php 		-->
<!--  desde gestion-usuarios.php 	-->

<?php
	session_start();
	if(!$_SESSION["autenticado"]) //con esto se evita el acceso a alguien que escriba directamente en el navegador a ruta a cambio-password.php
		header("Location: salir.php");
	else{
		echo "<fieldset>";
			echo "<h4>Bienvenido: ".($_SESSION["nombre_sesion"])."</h4>";
			
			if(empty($_POST["gestion_psswd_btn"])) //si se accede como admin o empleado desde control-panel vuelve a la misma control-panel
				echo "<a href='control-panel.php?home'><input type='submit' name='volver_btn' value='Volver'></a>";
			//si se accede sólo como admin desde gestion-usuarios.php vuelve a gestion-usuarios pasando el home por GET para que
			//se cargue por defecto, mostrando los usuarios, no las picadas
			if(!empty($_POST["gestion_psswd_btn"])) 
				echo "<a href='gestion-usuarios.php?home'><input type='submit' name='volver_btn' value='Volver'></a>";
			
			echo "<a href='salir.php'><input type='submit' value='Cerrar sesión'></a>";
		echo "</fieldset>";
		echo "<br>";

		$raiz="../";
		$titulo="Cambiar password";
		include($raiz."cabecera.php");
		include("conexion.php");
?>

<fieldset>
	<form action="cambio-password.php" id="cambiopassword" method="post" name="cambiopassword_frm">
 		<!-- Si el usuario tiene perfil administrador puede cambiar la contraseña de cualquier usuario-->
		<?php if($_SESSION["admin"]==true) include("select-usuario.php");?>
		<label for="cambiopassword">Password: </label>
		<input type="password" id="cambiopassword" name="cambiopassword_txt" required>
			
		<label for="confirmapassword">Repite Password: </label>
		<input type="password" id="confirmapassword" name="confirmapassword_txt" required>			
		<br>	
		<input type="submit" name="cambiopassword_btn" value="Cambiar contraseña">
	</form>
</fieldset>

<?php		
		if(!empty($_POST["cambiopassword_btn"])){
			if($_POST["cambiopassword_txt"]==null || $_POST["confirmapassword_txt"]==null)
				header("Location: ?mensaje=6");
			else{
				if($_POST["cambiopassword_txt"]!=$_POST["confirmapassword_txt"])
					header("Location: ?mensaje=7");
				else{
					$dnisesion=$_SESSION["dni_sesion"];
					$nuevopassword=md5($_POST["cambiopassword_txt"]);
					if ($_SESSION["admin"]==true){            //Si el usuario es administrador se recoge el valor del dni del usuario objeto de cambio
						$dnicambio=$_POST["dni_slc"];
						$consulta="UPDATE usuarios SET password='$nuevopassword' WHERE dni='$dnicambio'";
					}
					else // si el usuario no es admin se cambia el password de dicho usuario con la sesión iniciada
						$consulta="UPDATE usuarios SET password='$nuevopassword' WHERE dni='$dnisesion'";
					
					$ejecutar_consulta=$conexion->query($consulta);
					header("Location: ?mensaje=1");
				}
			}
		}
		$conexion->close();
		include ("mensajes.php");
	}
 ?>