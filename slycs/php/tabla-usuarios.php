<!--  desde gestion-usuarios.php -->

<div id="div-izquierdo">
	<form id='buscarusuario'>
		<?php 
			$envio="users"; 
			//tomará el valor en select-usuario.php para que se lo envíe por GET a gestion-usuarios.php y siga mostrando usuarios, no picadas
			include("select-usuario.php");
		?>
	</form>
</div>
<div id="div-derecho"><a href='form-usuario.php'><input type='submit' name='add_user_btn' value='Nuevo usuario...'></a></div>
<p> (Listado de usuarios ordenados alfabéticamente) </p>
<div class="datagrid">
	<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>Nombre</th>
				<th>Perfil</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
				while($registro_consulta_ver_usuarios=$ejecutar_consulta_ver_usuarios->fetch_assoc()){
					$dni=$registro_consulta_ver_usuarios["dni"];
					$nombre=$registro_consulta_ver_usuarios["apellidos"].", ".$registro_consulta_ver_usuarios["nombre"];
					$perfil=$registro_consulta_ver_usuarios["perfil"];
			?>
				<tr>
					<td><?php echo $dni;?></td>
					<td><?php echo $nombre;?></td>
					<td><?php if($perfil==1) echo "Administrador";else echo "Empleado";?></td>
					<td>
						<form>
							<input type="image" src="../img/editar.png" name="editar">
							<input type='image' src='../img/delete.png' name='borrar_usuario_btn'>
						</form>
					</td>
				</tr>
		<?php }	?>
		</tbody>
	</table>
</div>