<?php
	if(isset($_GET["mensaje"])){

		switch ($_GET["mensaje"]) {

			case '1':
				echo "<p class='mensajesok'>SE HA MODIFICADO LA CONTRASEÑA</p>";
				break;
			case '2':
				echo "<p class='mensajesfail'>DEBE INTRODUCIR DNI</p>";
				break;				
			case '3':
				echo "<p class='mensajesfail'>DEBE INTRODUCIR DNI Y CONTRASEÑA</p>";
				break;
			case '4':
				echo "<p class='mensajesfail'>ERROR AL CONECTAR CON LA BASE DE DATOS. PÓNGASE EN CONTACTO CON EL ADMINISTRADOR</p>";
				break;								
			case '5':
				echo "<p class='mensajesfail'>DNI O CONTRASEÑA INCORRECTA</p>";
				break;								
			case '6':
				echo "<p class='mensajesfail'>TODOS LOS CAMPOS SON OBLIGATORIOS</p>";
				break;
			case '7':
				echo "<p class='mensajesfail'>LAS CONTRASEÑAS NO COINCIDEN</p>";
				break;
			case '8':
				echo "<p class='mensajesfail'>DNI NO REGISTRADO EN EL SISTEMA</p>";
				break;
			case '9':
				echo "<p class='mensajesok'>INCIDENCIA REGISTRADA CON ÉXITO</p>";
				break;
			case '10':
				echo "<p class='mensajesok'>USUARIO CREADO CON ÉXITO</p>";
				break;
			case '11':
				echo "<p class='mensajesfail'>YA EXISTE UN USUARIO CON EL DNI INDICADO</p>";
				break;
			case '12':
				echo "<p class='mensajesfail'>NO SE HAN ESPECIFICADO DÍAS/HORAS</p>";
				break;
		}
	}
?>