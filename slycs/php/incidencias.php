<!--  desde control-panel.php -->

<?php 
	session_start();

	// si se intenta acceder por url sin estar autenticado, directamente vuelve a página de inicio, por lo que asistencia.php queda protegido
	if(!$_SESSION["autenticado"]){
		header("Location: salir.php");
	}
	else{
		$raiz="../";
		$titulo="Registro de incidencias";
		include ($raiz."cabecera.php");
		$dni=$_SESSION["dni_sesion"];
		echo "<fieldset><h4>Bienvenido: ".($_SESSION["nombre_sesion"])."</h4>";
		echo "<a href='control-panel.php?home'><input type='submit' name='volver_btn' value='Volver'></a>";
		echo "<a href='salir.php'><input type='submit' value='Cerrar sesión'></a></fieldset>";
?>
		<fieldset><legend> Nueva incidencia </legend>
			<form action="incidencias.php" method="post" name="nuevaincidencia_frm">
				<div class="div-incidencias">
					<select id="status" name="status" onChange="mostrar(this.value);" required>
					<!-- se mostrará el <div> cuyo id coincida con la opción seleccionada en el select 
						Para ello se necesita el <javascript> en cabecera.php -->
						<option value="">Seleccione la opción...</option>
						<option value="diacompleto"> Día completo </option>
						<option value="intervalo"> Periodo de días </option>
						<option value="horas"> Horas sueltas </option>
					</select>
					<div id="diacompleto" style="display: none;">
						<input type="date" name="Diacompleto" placeholder="dd/mm/aa">
					</div>
					<div id="intervalo" name="intervalo" style="display: none;">
						<input type="date" name="Diainicio" placeholder="dd/mm/aa">
						<input type="date" name="Diafin" placeholder="dd/mm/aa">
					</div>
					<div id="horas" name="horas" style="display: none;">
						<input type="date" name="Diahoras" placeholder="dd/mm/aa">
						<input type="time" name="Horainicio" placeholder="-- : --">
						<input type="time" name="Horafin" placeholder="-- : --">
					</div>
					<br><br>
					<textarea name="Comentarios" cols="40" rows="5" placeholder="Escriba aquí su comentario..."></textarea>
					<br>
					<input type="submit" name="grabar_incidencia_btn" value="Grabar incidencia">
				</div>
			</form>
		</fieldset>
		<br>
<?php
		include ("conexion.php");
		if(!empty($_POST["grabar_incidencia_btn"])){
			if(!empty($_POST["Diacompleto"])||((!empty($_POST["Diainicio"]))&&(!empty($_POST["Diafin"])))|| ((!empty($_POST["Diahoras"]))&&(!empty($_POST["Horainicio"]))&&(!empty($_POST["Horafin"])))){
				$duracion=$_POST["status"];
				$diacompleto=$_POST["Diacompleto"];
				$diainicio=$_POST["Diainicio"];
				$diafin=$_POST["Diafin"];
				$diahoras=$_POST["Diahoras"];
				$horainicio=$_POST["Horainicio"];
				$horafin=$_POST["Horafin"];
				$comentario=$_POST["Comentarios"];
		
				$consulta="INSERT INTO incidencias (inc_dni,inc_duracion,inc_diacompleto,inc_diainicio,inc_diafin,inc_diahoras,inc_horainicio,inc_horafin,inc_comentario) VALUES ('$dni','$duracion','$diacompleto','$diainicio','$diafin','$diahoras','$horainicio','$horafin','$comentario')";
				$ejecutar_consulta=$conexion->query($consulta);
				header("Location: ?mensaje=9");
			}
			else
				header("Location: ?mensaje=12");
		}
		include ("mensajes.php");
		
		//A continuación el procedimiento para mostrar las incidencias actuales

		$consulta_incidencias="SELECT * FROM incidencias I,usuarios U WHERE I.inc_dni='$dni' AND I.inc_dni=U.dni ORDER BY I.inc_id DESC";
		$ejecutar_consulta_incidencias=$conexion->query($consulta_incidencias);
		include ("tabla-incidencias.php");
		$conexion->close();
	}
?>