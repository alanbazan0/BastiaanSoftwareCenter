/*
* Este es un combo en formato html5
*/
Combo = function(id) {
	this._id = id;
	this._viewport = id;
	this._dataField = "recesoId";
	this._labelField = "rCorto";
	this._dataProvider = [];
	this._selectedItem = null;
	this._selectedIndex = null;
	this._seleccionMultiple = false;
	this._subscriptoresEventos = [];
	
	/*
	* Esta funcion dibuja el objeto
	*/
	this.render = function(){
		try{
			var output = "";
			var viewport = document.getElementById(this._viewport);
			viewport.onchange = this.changeIndex.bind(this);
			var iLength = this._dataProvider.length;
			if( esExplorer == true){
				viewport.options.length = 0;
				for(var i=0 ; i<iLength;i++ ){
					var option1 = document.createElement("option");
					option1.value = this._dataProvider[i][this._dataField];
					option1.innerText = escapeCharacters(this._dataProvider[i][this._labelField]);
					viewport.appendChild(option1);
				}
			}else{
				for(var i=0 ; i<iLength;i++ ){
					output += "<option value ='" + this._dataProvider[i][this._dataField] + "'";
	 				output += " >" + this._dataProvider[i][this._labelField] + "</option>";
				}
				viewport.innerHTML = output;			
			}
			this.updateSelected();
		}catch(error){
			throw "error al renderizar el combo :" + this._id + " . " + error;
			return false;
		}
		return true;
	}
	
	/*
	* cambia el elemento seleccionado
	*/
	this.updateSelected =  function (event){
		this._selectedItem = null;
		this._selectedIndex = null;
		var tmp = document.getElementById(this._viewport);
		for( var i= tmp.options.length-1; i > -1  ;i--){
			if(tmp.options[i].selected == true){
				this._selectedItem = this._dataProvider[i];
				this._selectedIndex = i;
				break;
			}
		}
	}
	
	/*
	* cambia el elemento seleccionado
	*/
	this.changeIndex =  function (event){
		this.updateSelected();
		var datosEvent = new Object();
		datosEvent.event = event;
		datosEvent.target = this;
		datosEvent.datos = this._selectedItem;
		var evento = new Evento("eventComboChange", datosEvent);
		manejadorEventos.disparaEvento(evento);
		this.disparaEvento(evento);
	}
	
	/*
	* establece el elemento seleccionado
	*/
	this.setSeleccionado =  function (campo, valor){
		var tmp = document.getElementById(this._viewport);
		for( var i= tmp.options.length-1; i > -1  ;i--){
			if(this._dataProvider[i][campo] == valor){
				tmp.options[i].selected = true;
				this._selectedItem = this._dataProvider[i];
				this._selectedIndex = i;
			}else{
				tmp.options[i].selected = false;
			}
		}
	}

};	

Combo.inheritsFrom(Base);