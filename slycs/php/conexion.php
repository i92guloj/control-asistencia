<?php
	function conectarse(){
		$server="localhost";
		$usuario="root";
		$password="";
		$dbname="slycs";

		$conectar=new mysqli($server,$usuario,$password,$dbname);
		return $conectar;
	}
	$inicio=$raiz."index.php";
	$conexion=conectarse();
	if (mysqli_connect_error()){
				header("Location: $inicio?mensaje=4");
    			die("");
    		}
?>