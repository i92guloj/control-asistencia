function mostrar(id) {
    if (id=="diacompleto") {
        $("#diacompleto").show();
        $("#intervalo").hide();
        $("#horas").hide();
    }

    if (id =="intervalo") {
        $("#diacompleto").hide();
        $("#intervalo").show();
        $("#horas").hide();
    }

    if (id=="horas") {
        $("#diacompleto").hide();
        $("#intervalo").hide();
        $("#horas").show();
    }
}