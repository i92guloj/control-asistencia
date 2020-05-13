<!--  desde form-usuario.php -->

<?php 
	$raiz="../";
	session_start();
	// si se intenta acceder por url sin estar autenticado, directamente vuelve a página de inicio, por lo que el proceso queda protegido
	if(!$_SESSION["autenticado"] || !$_SESSION["admin"])
		header("Location: salir.php");
	else{
		if(!empty($_POST["addusuario_btn"])){
			if(($_POST["nuevo_dni_txt"]==null) || ($_POST["nuevo_nombre_txt"]==null) || ($_POST["nuevos_apellidos_txt"]==null) || ($_POST["nuevo_password_txt"]==null) || ($_POST["confirma_nuevo_password_txt"]==null) || ($_POST["fecha_alta"]==null))
				header("Location: form-usuario.php?mensaje=6");
			else{
				if($_POST["nuevo_password_txt"]!=$_POST["confirma_nuevo_password_txt"])
					header("Location: form-usuario.php?mensaje=7");
				else{
					$dni=$_POST["nuevo_dni_txt"];
					include("conexion.php");
					//Se comprueba si el usuario ya existe
					$consulta="SELECT dni FROM usuarios WHERE dni='$dni'";
					$ejecutar_consulta=$conexion->query($consulta);
					if($ejecutar_consulta->num_rows!=1){ //si no existe se inserta
						$nombre=($_POST["nuevo_nombre_txt"]);
						$apellidos=($_POST["nuevos_apellidos_txt"]);
						$password=md5($_POST["nuevo_password_txt"]);
						$perfil=$_POST["gender"];
						$fecha_alta=$_POST["fecha_alta"];
						$consulta="INSERT INTO usuarios(dni,password,nombre,apellidos,perfil,fecha_alta) VALUES('$dni','$password','$nombre','$apellidos','$perfil','$fecha_alta')";
						$ejecutar_consulta=$conexion->query($consulta);
						header("Location: form-usuario.php?mensaje=10");
					}
					else
						header("Location: form-usuario.php?mensaje=11");
					
					$conexion->close();
				}
			}
		}
	}
		
?>

