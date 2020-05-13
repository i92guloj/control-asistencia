<html>
<head>
<?php
	// Se elimina cualquier sesión que pudiese haber quedado abierta
	session_start();
	session_destroy();
	$raiz="./";
	$titulo="Control de asistencia";
	// Se crea la cabecera aparte para que con include("cabecera.php") en cualquier fichero sea accesible la hoja de estilos y los jQuery
	include ("cabecera.php");
?>
</head>

<body class="index" onload="mueveReloj()"> <!-- se carga el reloj al cargar la página. La función está en "jquery.reloj.js" de la carpeta "js", que se carga en "cabecera.php"-->

	<div class="div-sesion">
		<form action="php/control-sesion.php" id="sesion" method="post" name="sesion_frm" enctype="application/x-www-form-urlencoded">
			<label for="dni_usuario"><b>DNI</b> </label>
			<input type="text" id="dni_usuario" name="dni_usuario_txt" minlength="8" maxlength="8" autocomplete="off" required pattern="[0-9]{8}">
			
			<label for="password"><b>Password</b> </label>
			<input type="password" id="password" name="password_txt" autocomplete="off" required>

			<input type="submit" name="sesion_btn" value="Iniciar sesión">
		</form>
	</div>
	<?php include("php/mensajes.php");?>
	<br><br>
	<div class="div-picada">
		<h2><b>Control de asistencia</b></h2>
		<form action="index.php" id="control-asistencia" method="post" name="asistencia_frm">
			<input type="text" class="reloj" name="reloj" readonly="readonly">	
			<br>
			<b>DNI (sin letra)</b>
			<br>
			<input type="text" id="dni" name="dni_txt" autofocus autocomplete="off" minlength="8" maxlength="8" required pattern="[0-9]{8}">
			<br><br><br>
			<input type="submit" name="registrar_btn" value="REGISTRAR"/>
		</form>
	</div>
</body>
</html>


<?php
	if(!empty($_POST["registrar_btn"])){
		if($_POST["dni_txt"]!=null){
			$dni=$_POST["dni_txt"];
			include("php/conexion.php");
			$consulta="SELECT dni FROM usuarios WHERE dni='$dni'";
			$ejecutar_consulta=$conexion->query($consulta);
			if($ejecutar_consulta->num_rows==1){		
				$dia_actual=date("Y-m-d");
				$hora_actual = date("H:i");
				$consulta="INSERT INTO picadas (picadas_dni,picadas_fecha,picadas_hora) VALUES ('$dni','$dia_actual','$hora_actual')";
				$ejecutar_consulta=$conexion->query($consulta);
				echo "<p class='mensajesok'>Registro de usuario con dni <b>".substr($dni,0,2)." * * * * ".substr($dni,6,6)."</b> a las ".$hora_actual."</p>";
				// Tras registro refrescar la página a los 5 segundos para eliminar el mensaje anterior que muestra el último registro realizado
				$self=$_SERVER["PHP_SELF"];
				header("refresh:5;url=$self");
			}
			else
				header("Location: ?mensaje=8");
			$conexion->close();
		}
		else
			header("Location: ?mensaje=2");
	}
?>