/*
* Aqui se declara la clase base para graficar por html
*
*/
/*
* al instanciar los objetos se proporciona su id, esto para poder dispara sus eventos
*/
Base = function(id) {
	this._viewport;
	this._subscriptoresEventos = [];
	this._ancho;
	this._alto;
	this._datos;
	this._listoViewport = false;
	this._listoInformacion = false;
	//this._id = Math.ceil(Math.random()*65536);
	this._id = id;
		
	/* 
	* esta funcion carga el objeto de datos 
	*/
	this.load = function(datos) {
		try{
			this._datos = datos;
			this._listoInformacion = true;
		}catch(error){
			this._listoInformacion = false;
			throw "error al cargar los datos" + error;
			return false;
		}
		return true;
	}
	
	/*
	* Esta funcion dibuja el objeto 
	*/
	this.render = function(){
		try{
			document.getElementById(this._viewport).innerHTML = this._id;
		}catch(error){
			throw "error al renderizar:" + error;
			return false;
		}
		return true;
	}
	
	/*
	* Esta funcion borra el objeto 
	*/
	this.clear = function(){
		try{
			document.getElementById(this._viewport).innerHTML = "";
		}catch(error){
			throw "error al limpiar render" + error;
			return false;
		}
		return true;
	}

	/*
	* Esta funcion nos dice si el objeto esta listo para ser dibujado
	* si la informacion y el viewport estan listos, nos regresa verdadero, falso en caso contrario
	*/
	this.estaListo = function(){
		if(this._listoInformacion && this._listoViewport){
			return true;
		}
		return false;
	}

	/*
	* Esta funcion establece el viewport para dibujar el objeto
	*/
	this.setViewport = function(viewport, ancho, alto){
		try{
			this._viewport = viewport;
			this._ancho = ancho;
			this._alto = alto;
			this._listoViewport = true;
		}catch(error){
			this._listoViewport = false;
			throw "error establecer el viewport" + error;
			return false;
		}
		return true;
	}
	
	/*
	* oculta el grafico
	*/
	this.hide = function(){
		document.getElementById(this._viewport).style.display = "none";	
	}

	/*
	* muestra el grafico
	*/
	this.show = function(){
		document.getElementById(this._viewport).style.display = "block";	
	}
	
	/*
	* nos regresa un string que representa al objeto
	*/
	this.toString = function () {
 		return "objeto";
	}
	
	/*
	* Esta funcion recupera los parametros en general data 
	*/
	this.setData = function(cabecero){
		try{
			this._cabecero = cabecero;
			//this.valorActual = cabecero[this._campoId];
		}catch(error){
			throw "error al establecer valor :" + error;
			return false;
		}
		return true;
	}
	
	/*
	* suscribe una funcion de un objetoa  un evento
	*/
	this.subscribirAEvento = function(objetivo, evento, funcion) {
		try{
			var subscripcionEvento = new SubscripcionEvento(objetivo, evento, funcion);
			this._subscriptoresEventos.push(subscripcionEvento);
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
			var iLength = this._subscriptoresEventos.length;
			for (var i=0; i< iLength; i++){
				if( this._subscriptoresEventos[i].evento == evento){
					this._subscriptoresEventos.splice(i,1);
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
			var iLength = this._subscriptoresEventos.length;
			for (var i=0; i< iLength; i++){
				if( this._subscriptoresEventos[i].evento == evento.nombre){
					var tmpObjetivo=this._subscriptoresEventos[i].objetivo;
					var tmpFuncion=this._subscriptoresEventos[i].funcion;
					//tmpObjetivo[tmpFuncion](evento.datos);
					tmpFuncion.call(tmpObjetivo, evento.datos);
				}
			}
		}catch(error){
			return false;
		}
		return true;
	}
	
};	
