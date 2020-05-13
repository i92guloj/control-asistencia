<!--  desde control-panel.php sólo como admin -->
<!-- desde el botón ver-usuarios... de esta misma página, sólo como admin -->
<!-- desde el botón ver-incidencias... de esta misma página, sólo como admin -->

<?php 
	$raiz="../";
	$titulo="Gestión de usuarios";
	session_start();

	// si se intenta acceder por url sin estar autenticado, directamente vuelve a página de inicio, por lo que asistencia.php queda protegido
	if(!$_SESSION["autenticado"] || !$_SESSION["admin"])
		header("Location: salir.php");
	else{
		include ($raiz."cabecera.php");

		echo "<fieldset><h4>Bienvenido: ".($_SESSION["nombre_sesion"])."</h4>";
		echo "<a href='control-panel.php?home'><input type='submit' name='volver_btn' value='Volver'></a>";
		echo "<a href='salir.php'><input type='submit' value='Cerrar sesión'></a></fieldset>";
?>
<br>
<fieldset><legend>GESTIÓN DE USUARIOS</legend>
	<ul class="menu">
		<!-- hay que pasar por GET para que cargue la vista por defecto con los usuarios, no con las picadas -->
		<li><form class="menu-form-users" action="gestion-usuarios.php?home" method="POST" ><input type="submit" name="ver_usuarios_btn" value="Ver usuarios..."></form></li>
		<li><form class="menu-form-users" action="cambio-password.php" method="POST" ><input type="submit" name="gestion_psswd_btn" value="Gestión de contraseñas..."></form></li>
		<li><form class="menu-form-users" action="gestion-usuarios.php" method="POST" ><input type="submit" name="ver_picadas_btn" value="Ver picadas de usuarios"></form></li>
		<li><form class="menu-form-users" action="gestion-usuarios.php" method="POST" ><input type="submit" name="ver_incidencias_btn" value="Permisos de usuarios"></form></li>
	</ul>
</fieldset>
<?php
		error_reporting(E_ALL & ~E_NOTICE);
		include("conexion.php");
/***************************************************************************************************************************/		
		//en la pantalla gestion-usuarios se muestran tanto los usuarios como las picadas, como las incidencias, según lo siguiente:
/***************************************************************************************************************************/		
//Opción 1: por defecto se muestra el listado de usuarios que viene del control-panel recibiendo GET[home]
//Opción 2: se mostrará el usuario seleccionado en el envío get de "users" desde select-usuario.php que lo ha recibido de tabla-usuarios.php

		if(isset($_GET["home"])|| $_GET["flag"]=="users"){
			if(isset($_GET["home"]))     //viene de control-panel, opción por defecto, se cargan todos los usuario
				$consulta_ver_usuarios="SELECT * FROM usuarios ORDER BY apellidos";
			if($_GET["flag"]=="users"){  //se ha hecho selección en select-usuario.php
				if($_GET["dni_slc"]=="default")  //si se ha seleccionado la opción por defecto "Mostrar todos"...
					$consulta_ver_usuarios="SELECT * FROM usuarios ORDER BY apellidos";
				else{
					$dni_encontrado=$_GET["dni_slc"]; //se recibe por GET de select-usuario.php
					$consulta_ver_usuarios="SELECT * FROM usuarios WHERE dni='$dni_encontrado'";
				}
			}
			$ejecutar_consulta_ver_usuarios=$conexion->query($consulta_ver_usuarios);
			include("tabla-usuarios.php");
		}
/***************************************************************************************************************************/
//Opción 3: se muestran todas las picadas al recargar esta misma página mediante el botón ver_picadas_btn
//Opción 4: se mostrarán las picadas del usuario seleccionado en el envío get "picadas" desde select-usuario.php que lo ha recibido de tabla-picadas.php

		if(!empty($_POST["ver_picadas_btn"]) || $_GET["flag"]=="picadas"){
		   	//si se ha pulsado el botón ver picadas se mostrarán éstas en lugar del listado de usuarios
			if(!empty($_POST["ver_picadas_btn"]))    //opción por defecto, se muestran todas las picadas
				$consulta_ver_picadas="SELECT * FROM picadas,usuarios WHERE picadas.picadas_dni=usuarios.dni ORDER BY picadas_fecha DESC";	
			if ($_GET["flag"]=="picadas"){    //se ha hecho selección en select-usuario.php
				if($_GET["dni_slc"]=="default")   //si se ha seleccionado la opción por defecto "Mostrar todos"...
					$consulta_ver_picadas="SELECT * FROM picadas,usuarios WHERE picadas.picadas_dni=usuarios.dni ORDER BY picadas_fecha DESC";	
				else{
					$dni_encontrado=$_GET["dni_slc"];   //se recibe por GET de select-usuario.php
					$consulta_ver_picadas="SELECT * FROM picadas,usuarios WHERE picadas.picadas_dni='$dni_encontrado' AND picadas.picadas_dni=usuarios.dni ORDER BY picadas_fecha DESC";
				}
			}
			$ejecutar_consulta_ver_picadas=$conexion->query($consulta_ver_picadas);
			include("tabla-picadas.php");
		}
/***************************************************************************************************************************/
//Opción 5: se muestran todas las incidencias al recargar esta misma página mediante el botón ver_incidencias_btn
//Opción 6: se muestran las incidencias del usuario seleccionado en el envío get "incidencias" desde select-usuario.php

		if(!empty($_POST["ver_incidencias_btn"]) || $_GET["flag"]=="incidencias"){
			//"$origen"sólo será tenido en cuenta en tabla-incidencias.php, para que envíe un parámetro por GET a tabla-detalle-incidencia.php
			//para que el botón "volver" de tabla-detalle redirija a gestion-usuarios.php para un correcto flujo del programa
			//También será tenido en cuenta para que cargue o no el select-usuario, ya que sólo debe cargarse si se accede desde el panel de gestión
			//pero no si se accede desde el botón "mis incidencias del control-panel"
			$origen=1; 
			if(!empty($_POST["ver_incidencias_btn"]))
				//si se ha pulsado el botón ver_incidencias, por defecto se muestran las de todos los usuarios
				$consulta_incidencias="SELECT * FROM incidencias I,usuarios U WHERE I.inc_dni=U.dni ORDER BY inc_id DESC";
			if ($_GET["flag"]=="incidencias"){          //si se ha seleccionado un usuario, se muestran sus incidencias
				if($_GET["dni_slc"]=="default")         //si se ha seleccionado la opción por defecto "Mostrar todos"...
					$consulta_incidencias="SELECT * FROM incidencias I,usuarios U WHERE I.inc_dni=U.dni ORDER BY inc_id DESC";
				else{
					$dni_encontrado=$_GET["dni_slc"];       //se recibe por GET de select-usuario.php
					$consulta_incidencias="SELECT * FROM incidencias I,usuarios U WHERE I.inc_dni='$dni_encontrado' AND I.inc_dni=U.dni ORDER BY inc_id DESC";
				}
			}
			$ejecutar_consulta_incidencias=$conexion->query($consulta_incidencias);
			include("tabla-incidencias.php");
		}
		$conexion->close();
	}
?>