<!--  desde control-sesion.php -->
<?php 
	$raiz="../";
	$titulo="Panel de control";
	session_start();

	// si se intenta acceder por url sin estar autenticado, directamente vuelve a página de inicio, por lo que controlpanel.php queda protegido
	if(!$_SESSION["autenticado"]){
		header("Location: salir.php");
	}
	else{
		include ($raiz."cabecera.php");
		$dni=$_SESSION["dni_sesion"];
		
		echo "<fieldset><h4>Bienvenido: ".($_SESSION["nombre_sesion"])."</h4>";
		echo "<a href='salir.php'><input type='submit' value='Cerrar sesión'></a></fieldset>";
?>
<ul class="menu">
	<?php
		if($_SESSION["admin"]==true)
			//hay que pasar por GET para que la opción por defecto en gestion-usuarios sea mostrar los usuarios, no las picadas
			echo "<li><a href='gestion-usuarios.php?home'><input type='submit' value='Gestión de usuarios'></a></li>";
		
		echo "<li><a href='incidencias.php'><input type='submit' name='incidencias_btn' value='Mis incidencias'></a></li>";
		echo "<li><a href='cambio-password.php'><input type='submit' name='cambiarpwd_btn' value='Cambiar contraseña'></a></li>";
	?>
</ul>


<?php
		include ("conexion.php");
		//se comprueba si existen picadas del usuario de la sesión.
		include("select-fecha.php");
		//si no se ha seleccionado ninguna fecha, o se pulsa el siguiente enlace se muestran por defecto los últimos 30 registros
		echo "<a href='control-panel.php?home'>Mostrar últimos 30 registros</a>";
		if(empty($_POST["buscar_btn"])){
			$consulta_ver_picadas="SELECT * FROM picadas,usuarios WHERE picadas.picadas_dni='$dni' AND picadas.picadas_dni=usuarios.dni ORDER BY picadas_fecha DESC LIMIT 30";
		}	
		//si se ha seleccionado una fecha y se ha pulsado el botón Buscar...
		else{
			$mes=$_POST["mes_slc"];
			$anyo=$_POST["anyo_slc"];
			$consulta_ver_picadas="SELECT * FROM picadas,usuarios WHERE picadas.picadas_dni='$dni' AND picadas.picadas_dni=usuarios.dni AND MONTH(picadas_fecha)=$mes AND YEAR(picadas_fecha)=$anyo";
		}	
		$ejecutar_consulta_ver_picadas=$conexion->query($consulta_ver_picadas);
		include ("tabla-picadas.php");
		$conexion->close();
	}
?>