//Función JavaScript para mostrar el reloj
		function mueveReloj(){
    		momentoActual = new Date()
    		hora = momentoActual.getHours()
    		minuto = momentoActual.getMinutes()
    		segundo = momentoActual.getSeconds()
    		//Con las líneas anteriores sacamos horas, minutos y segundos pero con un sólo carácter (13:9:7 horas:minutos:segundos)
    		//Es mejor mostrar siempre dos digitos (13:09:07 horas:minutos:segundos) 
    		//Para ello se comprueba si tienen un solo dígito y si es así se añade un 0 a la izquierda

    		str_hora = new String (hora)
    		if (str_hora.length == 1) //si la hora tiene un sólo dígito, es decir, menos de las 10 horas, se añade un 0
       			hora = "0" + hora

       		str_minuto = new String (minuto) //idem con los minutos
    		if (str_minuto.length == 1)
       			minuto = "0" + minuto

    		str_segundo = new String (segundo) // idem con los segundos
    		if (str_segundo.length == 1)
       			segundo = "0" + segundo
    
   			horaImprimible = hora + " : " + minuto + " : " + segundo
    		document.asistencia_frm.reloj.value = horaImprimible    //se pasa al parámetro "value" del input "reloj" del form "asistencia_frm" del index
    		setTimeout("mueveReloj()",1000) //se llama a la función cada segundo (1000 milisegundos) para mostrar los segundos corriendo en el index
		}