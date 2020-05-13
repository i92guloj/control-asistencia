<!--  desde incidencias.php, como admin o como empleado-->
<!-- desde gestion-usuarios.php sólo como admin -->
<?php
	error_reporting(E_ALL & ~E_NOTICE);
	//cuando llega desde gestion-usuarios.php sí se muestra select-usuario como debe ser
	//$origen viene desde gestion-usuarios. Si el flujo viniese desde control-panel el 
	// select no se carga ya que sólo hay que mostrar las incidencias del propio usuario
	//con la sesión iniciada
	if($_SESSION["admin"] && $origen==1){   
		echo "<form id='buscarusuario'>";
			$envio="incidencias";
			include("select-usuario.php");
		echo "</form>";
	}	
?>
<br>
<div class="datagrid">
	<table>
		<thead>
			<tr>
				<th style="width:3%;">ID</th>
				<th style="width:25%;">Empleado</th>
				<th>Descripción</th>
				<th class="td-iconos"></th>
			</tr>
		</thead>
		<tbody>
			<?php
				while($registro=$ejecutar_consulta_incidencias->fetch_assoc()){
					$id=$registro["inc_id"];
					$nombre=$registro["nombre"]." ".$registro["apellidos"];
					$comentario=$registro["inc_comentario"];
			?>	
			<tr>
				<td><?php echo $id;?></td>
				<td><?php echo $nombre;?></td>
				<td><?php echo $comentario; ?></td>
				<td class="td-iconos">
					<?php
						//origen se recibe de gestion-usuarios.php. Tiene la función de indicar que se accede a tabla-detalle
						//como admin y que al pulsar en "volver" de tabla-detalle debe redirigir el flujo del programa correctamente
						//volviendo a cargar gestion-usuarios.php con los parámetros adecuados
						if ($origen==1)
							echo "<form action='tabla-detalle-incidencia.php?admin' method='POST'>";
						else
							echo "<form action='tabla-detalle-incidencia.php' method='POST'>";
					?>
						<!-- se pasa oculto el id de la incidencia para ver su detalle -->
						<input type="hidden" name="codigo" value="<?php echo $id; ?>">
						<input type="image" src="../img/ver-mas.jpg">
					</form>
				</td>
			</tr>
			<?php }?>
		</tbody>
	</table>
</div>

<?php
	// aquí sólo entra desde gestion-usuarios.php, al seleccionar un usuario como admin
	// antes de mostrar las incidencias se comprueba si existen para el usuario en cuestión
	// si se ha pulsado la opción por default "Mostrar todos" no será necesario comprobar esto
	if($_GET["dni_slc"]!=null && $_GET["dni_slc"]!="default"){
		$dni_encontrado=$_GET["dni_slc"];
		$consulta_incidencias="SELECT * FROM incidencias I,usuarios U WHERE I.inc_dni='$dni_encontrado' AND I.inc_dni=U.dni ORDER BY inc_id DESC";
		$ejecutar_consulta_incidencias=$conexion->query($consulta_incidencias);

		if($ejecutar_consulta_incidencias->num_rows<=0) //si existen registros del usuario se muestran las picadas
			echo "<br><div class='tabla-neg'>NO EXISTEN REGISTROS PARA EL USUARIO SELECCIONADO</div>";
	}
?>
