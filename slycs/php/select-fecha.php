<!--  desde control-panel.php -->

<?php
	// se crean las siguientes variables tan sólo para que al consultar por fecha, quede seleccionado tanto el mes como el año que indica el usuario
	// estas variables sólo se usarán más abajo tan sólo para que se pueda imprimir "selected" en los option de abajo
	$mes_selected=0;
	$anyo_selected=0;
	if((!empty($_POST["mes_slc"])) && (!empty($_POST["anyo_slc"]))){
		$mes_selected=$_POST["mes_slc"];
		$anyo_selected=$_POST["anyo_slc"];
	}	
?>
<fieldset id='buscarfecha'>
<legend>BUSCAR POR FECHA</legend>
	<form action='control-panel.php?home' method='post'>
		<select name="mes_slc" id="mes" required>
			<option value=""> Mes </option>
			<option value="1" <?php if ($mes_selected=="1") echo " selected";?>>Enero</option>
			<option value="2" <?php if ($mes_selected=="2") echo " selected";?>>Febrero</option>
			<option value="3" <?php if ($mes_selected=="3") echo " selected";?>>Marzo</option>
			<option value="4" <?php if ($mes_selected=="4") echo " selected";?>>Abril</option>
			<option value="5" <?php if ($mes_selected=="5") echo " selected";?>>Mayo</option>
			<option value="6" <?php if ($mes_selected=="6") echo " selected";?>>Junio</option>
			<option value="7" <?php if ($mes_selected=="7") echo " selected";?>>Julio</option>
			<option value="8" <?php if ($mes_selected=="8") echo " selected";?>>Agosto</option>
			<option value="9" <?php if ($mes_selected=="9") echo " selected";?>>Septiembre</option>
			<option value="10" <?php if ($mes_selected=="10") echo " selected";?>>Octubre</option>
			<option value="11" <?php if ($mes_selected=="11") echo " selected";?>>Noviembre</option>
			<option value="12" <?php if ($mes_selected=="12") echo " selected";?>>Diciembre</option>
		</select>
<?php
	//en el select debe mostrarse desde el año actual hasta el primero del que se tengan picadas
	//Como el id de las picadas es autoincremental corresponderá con el año de la picada cuyo id=1
	$consulta_primer_year="SELECT picadas_fecha FROM picadas WHERE picadas_id='1'";
	$ejecutar_consulta_primer_year=$conexion->query($consulta_primer_year);
	$primera_picada=$ejecutar_consulta_primer_year->fetch_assoc();
	$primer_year=date("Y",strtotime($primera_picada["picadas_fecha"]));
?>		
		<select name="anyo_slc" id="year" required>
			<option value=""> Año </option>
			<?php
				//se muestra en el select desde el año actual, date("Y"), 
				//hasta el primer año del que se tienen picadas averiguado en el paso anterior
				for($anyo=date("Y");$anyo>=$primer_year;$anyo--){
					echo "<option value='$anyo' ";
					if($anyo_selected==$anyo)
						echo "selected";
					echo ">$anyo</option>";
				}
			?>
		</select>
		<input type="submit" name="buscar_btn" value="Buscar">
	</form>
</fieldset>
<br>