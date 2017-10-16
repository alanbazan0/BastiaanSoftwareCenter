
/*
* Esta clase maneja los eventos de la interfaz de javascript
*/
 
	ManejadorEventos = function() {
		this.subscriptoresEventos = new Array();
	
		/*
		* suscribe una funcion de un objetoa  un evento
		*/
		this.subscribirAEvento = function(objetivo, evento, funcion) {
			try{
				subscripcionEvento = new SubscripcionEvento(objetivo, evento, funcion);
				this.subscriptoresEventos.push(subscripcionEvento);
			}catch(error){
				return false;
			}
			return true;
		}

		/*
		* desuscribe una funcion de un objeto a un evento
		*/
		this.desubscribirAEvento = function(objetivo, evento, funcion) {
			try{
				var iLength = this.subscriptoresEventos.length;
				for (var i=0; i< iLength; i++){
					if( this.subscriptoresEventos[i].evento == evento){
						this.subscriptoresEventos.splice(i,1);
						return true;
					}
				}
			}catch(error){
				return false;
			}
			return true;
		}
		/*
		* Esta funcion recorre el listado de eventos y dispara las funciones de todos los suscriptores al evento
		*/
		this.disparaEvento = function(evento) {
			try{
				var iLength = this.subscriptoresEventos.length;
				for (var i=0; i< iLength; i++){
					//alert(JSON.stringify(this.subscriptoresEventos[i]));
					if( this.subscriptoresEventos[i].evento == evento.nombre){
						var tmpObjetivo=this.subscriptoresEventos[i].objetivo;
						var tmpFuncion=this.subscriptoresEventos[i].funcion; 
						window[tmpObjetivo][tmpFuncion](evento.datos);
					}
				}
			}catch(error){
				return false;
			}
			return true;
		}

	};
	
	/*
	* clase subscriptor a un evento 
	*/
	SubscripcionEvento = function(pobjetivo, pevento, pfuncion ) {
		this.objetivo = pobjetivo;
		this.evento = pevento;
		this.funcion = pfuncion;
	};
	
	/*
	* clase de evento,sus parametros son el nombre del evento y un objeto que contiene los datos 
	*/
	Evento = function(pnombre, pdatos) {
		if (pnombre==undefined){
			this.nombre="nombreEvento";
		}else{
			this.nombre = pnombre;
		}
		if (pdatos==undefined){
			this.datos = new Object();
		}else{
			this.datos = pdatos;
		}
		
	};	
