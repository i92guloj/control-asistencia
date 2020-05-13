	<!--  desde tabla-incidencias.php -->
<?php
	session_start();
	if(!$_SESSION["autenticado"]) //con esto se evita el acceso a alguien que escriba directamente en el navegador la ruta
		header("Location: salir.php");
	else{
		error_reporting(E_ALL & ~E_NOTICE);
		$raiz="../";
		$titulo="Detalle incidencia";
		include($raiz."cabecera.php");
		include ("conexion.php");
		
		//se recibe el id (codigo) que se envía oculto desde tabla-incidencias.php
		$codigo=$_POST["codigo"]; 
		$consulta_detalle_inc="SELECT * FROM incidencias I,usuarios U WHERE I.inc_dni=U.dni AND I.inc_id='$codigo'";
		$ejecutar_consulta_detalle_inc=$conexion->query($consulta_detalle_inc);
		$registro=$ejecutar_consulta_detalle_inc->fetch_assoc();
		$dni=$registro["dni"];
		$nombre=$registro["nombre"]." ".$registro["apellidos"];
		$duracion=$registro["inc_duracion"];
		$diacompleto=$registro["inc_diacompleto"];
		$diainicio=$registro["inc_diainicio"];
		$diafin=$registro["inc_diafin"];
		$diahoras=$registro["inc_diahoras"];
		$horainicio=$registro["inc_horainicio"];
		$horafin=$registro["inc_horafin"];
		$comentario=$registro["inc_comentario"];
?>
		<fieldset>
			<h4>Bienvenido: <?php echo $_SESSION["nombre_sesion"] ?></h4>
			<?php
				//puede o no recibir por GET el parámetro admin desde tabla-incidencias.php. Esto sucede cuando es un admin
				//quien está accediendo a esta tabla, para que al pulsar el botón "volver" continúe con el flujo
				//del programa que corresponde a dicho administrador, volviendo a gestion-usuarios con los parámetros adecuados
				//en lugar de a incidencias.php como es el flujo cuando el que accede al detalle de sus incidencias es un empleado
				if (isset($_GET["admin"]))
					echo "<a href='gestion-usuarios.php?dni_slc=$dni&flag=incidencias'><input type='submit' value='Volver'></a>";
				else
					echo "<a href='incidencias.php'><input type='submit' value='Volver'></a>";
				echo "<a href='salir.php'><input type='submit' value='Cerrar sesión'></a>";
			?>
		</fieldset>
		<br>

<?php if($duracion=="diacompleto"){?>
		<table class="detalle-incidencia">
			<tr>
				<td class="td-titulo">ID incidencia</td>
				<td class="td-valor"><?php echo $codigo;?></td>
			</tr>
			<tr>
				<td class="td-titulo">ID empleado</td>
				<td class="td-valor"><?php echo $dni;?></td>
			</tr>
			<tr>
				<td class="td-titulo">Nombre empleado</td>
				<td class="td-valor"><?php echo $nombre; ?></td>
			</tr>
			<tr>
				<td class="td-titulo">Día</td>
				<td class="td-valor"><?php echo date("d-m-Y",strtotime($diacompleto));?></td>
			</tr>
			<tr>
				<td class="td-titulo">Comentario</td>
				<td class="td-valor"><?php echo $comentario; ?></td>
			</tr>
		</table>
<?php } ?>

<?php if($duracion=="intervalo"){?>
		<table class="detalle-incidencia">
			<tr>
				<td class="td-titulo">ID incidencia</td>
				<td class="td-valor"><?php echo $codigo;?></td>
			</tr>
			<tr>
				<td class="td-titulo">ID empleado</td>
				<td class="td-valor"><?php echo $dni;?></td>
			</tr>
			<tr>
				<td class="td-titulo">Nombre empleado</td>
				<td class="td-valor"><?php echo $nombre; ?></td>
			</tr>
			<tr>
				<td class="td-titulo">Día inicio</td>
				<td class="td-valor"><?php echo date("d-m-Y",strtotime($diainicio));?></td>
			</tr>			
			<tr>
				<td class="td-titulo">Día fin</td>
				<td class="td-valor"><?php echo date("d-m-Y",strtotime($diafin));?></td>
			</tr>
			<tr>
				<td class="td-titulo">Comentario</td>
				<td class="td-valor"><?php echo $comentario; ?></td>
			</tr>			
		</table>
<?php } ?>

<?php if($duracion=="horas"){?>
		<table class="detalle-incidencia">
			<tr>
				<td class="td-titulo">ID incidencia</td>
				<td class="td-valor"><?php echo $codigo;?></td>
			</tr>
			<tr>
				<td class="td-titulo">ID empleado</td>
				<td class="td-valor"><?php echo $dni;?></td>
			</tr>
			<tr>
				<td class="td-titulo">Nombre empleado</td>
				<td class="td-valor"><?php echo $nombre; ?></td>
			</tr>
			<tr>
				<td class="td-titulo">Día</td>
				<td class="td-valor"><?php echo date("d-m-Y",strtotime($diahoras));?></td>
			</tr>
			<tr>
				<td class="td-titulo">Hora de inicio</td>
				<td class="td-valor"><?php echo date("H:i",strtotime($horainicio));?></td>
			</tr>
			<tr>
				<td class="td-titulo">Hora de fin</td>
				<td class="td-valor"><?php echo date("H:i",strtotime($horafin));?></td>
			</tr>
			<tr>
				<td class="td-titulo">Comentario</td>
				<td class="td-valor"><?php echo $comentario; ?></td>
			</tr>
		</table>
<?php } 
		$conexion->close();
	}
?>