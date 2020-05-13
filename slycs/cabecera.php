<title><?php echo $titulo; ?></title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link href='http://fonts.googleapis.com/css?family=News+Cycle' rel='stylesheet' type='text/css'>
<link rel="STYLESHEET" type="text/css" href="<?php echo $raiz ?>css/estilos.css">

<!-- se incluye la librería jquery necesaria para ejecutar cualquier script  -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="<?php echo $raiz?>js/jquery.min.js"></script>

<!-- Se incluye .js para cargar el reloj del index-->
<script src="<?php echo $raiz?>js/jquery.reloj.js"></script>
<!-- Se incluye el siguiente js para usar en incidencias.php para que cargue el formulario correspondiente a la opción que se elija en el select-->
<script src="<?php echo $raiz?>js/jquery.opciones.incidencias.js"></script>

<!-- script para evitar el funcionamiento de la tecla Return -->
<script type="text/javascript">
$(document).ready(function() {
    $("form").keypress(function(e) {
        if (e.which == 13) {
            return false;
        }
    });
});
</script>