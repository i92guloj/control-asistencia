<!--  desde inedex.php -->

<?php 
	$raiz="../";
	if($_POST["dni_usuario_txt"]==null || $_POST["password_txt"]==null)
			header("Location: ../index.php?mensaje=3");
	else{
		include("conexion.php");

		$dni_autenticado=$_POST["dni_usuario_txt"];
		$pass_autenticado=md5($_POST["password_txt"]);
		//se comprueba si el usuario existe y las credenciales coinciden
		$consulta="SELECT * FROM usuarios WHERE dni='$dni_autenticado' AND password='$pass_autenticado'";
		$ejecutar_consulta=$conexion->query($consulta);
		$registro=$ejecutar_consulta->fetch_assoc();
		$num_regs=$ejecutar_consulta->num_rows;
		$conexion->close();
		if($num_regs==1){    //se ha encontrado un usuario correcto, se abre la sesión
			session_start();
			// se crean las variables de sesión
			$_SESSION["autenticado"]=true;

			//se comprueba si es usuario administrador
			if($registro["perfil"]=="1")
				$_SESSION["admin"]=true;
			else
				$_SESSION["admin"]=false;

			$_SESSION["dni_sesion"]=$_POST["dni_usuario_txt"];
			$_SESSION["nombre_sesion"]=$registro["nombre"]." ".$registro["apellidos"];
			header("Location: control-panel.php?home"); //se pasa home por GET para que por defecto no muestre en la pantalla inicio el select usuario
		}
		else{        //no se ha encontrado el usuario
			header("Location: ../index.php?mensaje=5");
		}
	}
 ?>