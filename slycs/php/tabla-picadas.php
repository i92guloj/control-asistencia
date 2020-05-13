<!--  desde control-panel.php, al inicio ya sea con admin o empleado-->
<!--  desde gestion-usuarios.php, sólo como admin -->
<?php
	error_reporting(E_ALL & ~E_NOTICE);
	//si llega desde control-panel.php, llega siempre !home, para que no muestre select-usuario en el inicio de control-panel.php
	//cuando llega desde gestion-usuarios.php sí se muestra select-usuario como debe ser
	if($_SESSION["admin"] && !isset($_GET["home"])){   
		echo "<form id='buscarusuario'>";
			$envio="picadas";
			include("select-usuario.php");
		echo "</form>";
	}	
?>
		<div class="datagrid">
			<table>
				<thead>
					<tr>
						<th>DNI</th>
						<th>Nombre</th>
						<th>Día</th>
						<th>Hora</th>
						<?php if($_SESSION["admin"]) echo "<th></th>" ?>
					</tr>
				</thead>
				<tbody>
					<?php
						while($registro_consulta_ver_picadas=$ejecutar_consulta_ver_picadas->fetch_assoc()){
							$dni=$registro_consulta_ver_picadas["dni"];
							$nombrecompleto=$registro_consulta_ver_picadas["nombre"]." ".$registro_consulta_ver_picadas["apellidos"];
							$fecha=$registro_consulta_ver_picadas["picadas_fecha"];
							$hora=$registro_consulta_ver_picadas["picadas_hora"];
					?>	
					<tr>
						<td><?php echo $dni; ?></td>
						<td><?php echo $nombrecompleto; ?></td>
						<td><?php echo date('d-m-Y',strtotime($fecha)); ?></td>
						<td><?php echo date("H:i",strtotime($hora)); ?></td>
						<?php if($_SESSION["admin"])
							echo "<td><form><input type='image' name='borrar_registro' src='../img/delete.png'></form></td>";
						?>
					</tr>
					<?php 
						}
					?>
				</tbody>
			</table>
		</div>
<?php
	// aquí sólo entra desde gestion-usuarios.php, al seleccionar un usuario como admin
	// antes de mostrar las picadas se comprueba si existen para el usuario en cuestión
	// si se ha pulsado la opción por default "Mostrar todos" no será necesario comprobar esto
	if($_GET["dni_slc"]!=null && $_GET["dni_slc"]!="default"){
		$dni_encontrado=$_GET["dni_slc"];
		$consulta_picadas="SELECT * FROM usuarios,picadas WHERE picadas_dni='$dni_encontrado'";
		$ejecutar_consulta_picadas=$conexion->query($consulta_picadas);

		if($ejecutar_consulta_picadas->num_rows<=0) //si existen registros del usuario se muestran las picadas
			echo "<br><div class='tabla-neg'>NO EXISTEN REGISTROS PARA EL USUARIO SELECCIONADO</div>";
	}
?>