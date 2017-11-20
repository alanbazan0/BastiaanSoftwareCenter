  
function PromptUsuarios(id) {
	that = this;
	 this._viewport =id;
	this._id = id;
	this._agenteId = "";
	this.agenteId = "";
	this.agenteId = this.agenteId;
	this._subscriptoresEventos = [];
	this.datos=[];
	this.padre;
	
	/*
	* esta funcion carga el objeto de datos 
	*/

	
	this.load = function(datos,padre) {
		try{
			
			this.datos=datos;	
			this.padre=padre;
			this._listoInformacion = true;
		}catch(error){
			this._listoInformacion = false;
			throw "error al cargar los datos" + error;
			return false;
		}
		return true;
	}
	
	/*
	* Esta funcion dibuja el prompt
	*/
	this.render = function()
	{
		try{
			var output = "";
			output += '<div style="position: fixed; top: 0px; left: 0px; display: block; width: 100%; height: 100%; z-index: 5001; background-color: rgba(255, 255, 250, 0.75);" >'
			output += "<div class='panelAsistenteFRM' id='PMenuAsistente' style='width:120px;background-color:#BCBCBC;height:auto; margin-left:auto;margin-right:auto;margin-top:50px;padding-top:0px;padding-left: 0px;padding-right: 0px;' >";
			output += "<div class='tituloCriterio' style='height:42px;border-radius: 10px 10px 0px 0px;";
			output += "background-image: linear-gradient(bottom, rgb(100,100,100) 30%, rgb(140,140,140) 90%);";
			output += "background-image: -o-linear-gradient(bottom, rgb(100,100,100) 30%, rgb(140,140,140) 90%);";
			output += "background-image: -moz-linear-gradient(bottom, rgb(100,100,100) 30%, rgb(140,140,140) 90%);";
			output += "background-image: -webkit-linear-gradient(bottom, rgb(100,100,100) 30%, rgb(140,140,140) 90%);";
			output += "'>";
			output += "<img src='../COM/estilo/estacion/botones/btnSalir.png' style='float:right;cursor:pointer;width:38px;height:38px;'";
			output += " onclick='regresa();' >";
			output += "</div>";
   			output += "<div class='contCriterios2' id='contCriterios2' style='height:220px;'>";
   			output +=" <div id='" + this._viewport + "Grid' class='gridPrompt' style='height:200px;width:260px;></div>";	
   			output += "</div'>";

			output += "</div'>";
			output += "</div'>";
			document.getElementById(this._viewport).innerHTML = output;
			document.getElementById(this._viewport).style.display = "block";			
			document.getElementById(this._viewport).style.position = "fixed";
			
			_gridListaArchivos = new GridReg("_gridListaArchivos");
			var columnas = [
				{longitud:230, titulo:"Id", alias:"id", alineacion:"I"},
				{longitud:230, titulo:"Nombre Agente", alias:"agenteId", alineacion:"I"}
			];
			_gridListaArchivos._columnas = columnas;
			_gridListaArchivos._ajustarAltura 		= true;
		    _gridListaArchivos._colorRenglon1 		= "#FFFFFF";
			_gridListaArchivos._colorRenglon2 		= "#f8f2de";
			_gridListaArchivos._colorEncabezado1 	= "#ff6600";
			_gridListaArchivos._colorEncabezado2 	= "#ff6600";
			_gridListaArchivos._colorLetraEncabezado = "#ffffff";
			_gridListaArchivos._colorLetraCuerpo 	= "#464646";
		    _gridListaArchivos._colorLetraCuerpo 	= "#000000";
		    _gridListaArchivos.subscribirAEvento(this, "eventGridRowDoubleClick",this.clickListaArchivos );
			_gridListaArchivos._dataProvider = this.datos;
			_gridListaArchivos.setViewport(this._viewport + "Grid");
			_gridListaArchivos.render();
			
			
			this.padre.consutarUsuarioCri();
		}catch(error){
			throw "error al renderizar:" + error;
			return false;
		}
		return true;
	}

	/*
	*
	*/
	
	/*
	set datosUsuarios(valor)
	{
	this.PromptUsuarios = valor;
	this.grid.render();
	}
	*/
	
	
	
	this.clickListaArchivos = function (evento)
	{
		var archivo = "";
		//archivo += this._opciones[22] + "/" + this._rutaArchivo + "/" + evento.datos.nombre;
		archivo += this._rutaArchivo + "/" + evento.datos.nombre;
		window.open(archivo,"_blank");
	}

	/*
	* oculta el prompt
	*/	
	regresa = function ()
	{
		/*var datosEvent ={};
		datosEvent.seleccionados = this._seleccionados;
		var evento = new Evento("eventSalirPromptArchivosIEC", datosEvent);
		this.disparaEvento(evento);*/
		document.getElementById("Prompt").style.display = "none";
	} 

};
PromptUsuarios.inheritsFrom(Base);
