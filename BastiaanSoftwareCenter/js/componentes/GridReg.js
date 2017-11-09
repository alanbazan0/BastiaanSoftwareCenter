/*
* Este es un grid en formato html5
*/
GridReg = function(id) {
	this._id = id;
	this._viewport = id;
	this._columnas = [];
	this._dataProvider = [];
	this._colorRenglon1 = "#FFFFFF";
	this._colorRenglon2 = "#F0F0F0";
	this._colorEncabezado1 = "#FFFFFF";
	this._colorEncabezado2 = "#CCCCCC";
	this._colorLetraEncabezado = "#444444";
	this._colorLetraCuerpo = "#888888" 
	this._seleccionMultiple = false;
	this._bordesRedondeados = true;
	this._eliminarLineaVerticales = false;
	this._deseleccionar = false;
	this._seleccionarTodos = false;
	this._ocultarEncabezado = false;
	this._mostrarMarcadores = false;
	this._ajustarAltura = false;
	this._scrollHorizontal = true;
	this._subscriptoresEventos = [];
	this._regExtra=50;
	this._draggedEl;
	this._newId = 0;
	this.datosEventX = new Object();
	this._presentacionGranTotal = "NO";
	this._origen = "";
	this.manejadorEventos="";
	/*
	* variables para el drop 
	*/
	this._tieneDragDrop= false;
	this._aceptaDrop=true;
	this._aceptaDelete=false;
	this._aceptaDropEncualquierParte=false;
	
	
	/*
	* Esta funcion dibuja el objeto 
	* recorremos las columnas para dibujar el grid
	*/
	this.render = function(){
		try{
		  
	
			var output = [];
			var iLength;
			var jLength;
			var bordes ="";
			var separacionVertical="";
			var viewport = document.getElementById(this._viewport);
			viewport.style.overflowX = "auto";//viewport.style.overflowX = "auto";
			if(esExplorer == false){
				viewport.style.overflowY = "hidden";
			}
			if( this._eliminarLineaVerticales == true){
				separacionVertical += "border-width:0px;border-collapse: collapse;";
			}else{
				separacionVertical += "border-width:1px;border-collapse: collapse;";
				bordes += "border-style:solid;";
			}
			if( this._bordesRedondeados == true){ 
				separacionVertical += "border-collapse: separate;";
				bordes += "-moz-border-radius:6px;-webkit-border-radius:6px;border-radius:6px;border-color: #BFBFBF;";
			}
			/*
			altura para los totales
			*/
			var altoPie = 0;
			if( this._presentacionGranTotal == "SI"){
				altoPie = 50;
			}
			/*
			* calculamos el ancho de las columnas
			* si el ancho de la tabla en total es menor al ancho del viewport
			* a la ultima columna le agregamos la diferencia
			*/
			var anchoTablaAux = 0;
			var anchoTabla = 0;
			var anchoColumnas = [];
			var tipo = [];
			var anchoCheckbox = 0;
			var anchoScroll = 18;
			var altoEncabezado = 40;
			if(this._ocultarEncabezado==true){
			   altoEncabezado = 0;
			}
			var jj = this._columnas.length;
			if(this._seleccionMultiple == true ){
				anchoCheckbox = 20;
			}
			anchoTabla += anchoCheckbox;
			for(var j = 0 ; j < jj ; j++){
				anchoTabla += +this._columnas[j].longitud;
				anchoColumnas.push(this._columnas[j].longitud);
				
			}
			
			if( anchoTabla < viewport.offsetWidth ){
				//anchoColumnas[jj-1] += (viewport.offsetWidth - anchoTabla );
				var tabla= anchoTabla //+ anchoScroll;
				anchoTablaAux = viewport.offsetWidth - tabla;
                 anchoTablaAux = anchoTablaAux-anchoScroll;
                 anchoTablaAux =  anchoTablaAux-50;
			}
			
			
			  output[output.length] = "<table id='" + this._viewport + "Table' style='"+separacionVertical+"width:" + ( anchoTabla + anchoScroll) + "px;height:100%;'>";
				if(this._ocultarEncabezado == false){
					output[output.length] = "<thead class='grid'>";
					if(this._mostrarMarcadores == true){
						output[output.length] = "<tr style='height:5px;' >";
						if( this._seleccionMultiple == true ){
							output[output.length] = "<th style='height:5px;width:" + anchoCheckbox + "px;" + separacionVertical;
							output[output.length] = "' ";
							output[output.length] = " >&nbsp;</th>";
						}
						var jj = this._columnas.length;
						for(var j=0 ; j < jj ; j++ ){
							output[output.length] = "<th style='vertical-align:top;height:5px;";
							if(j == jj-1){
								output[output.length] = "width:" + (anchoColumnas[j]+anchoScroll) + "px;max-width:" + (anchoColumnas[j]+anchoScroll) + "px;min-width:" + (anchoColumnas[j]+anchoScroll) + "px;";
							} else{
								output[output.length] = "width:" + anchoColumnas[j] + "px;max-width:" + anchoColumnas[j] + "px;min-width:" + anchoColumnas[j] + "px;";
							}
							if(this._columnas[j].colorMarcador != null && this._columnas[j].colorMarcador != undefined ){
								output[output.length] = "' ><hr style='background-color:" + this._columnas[j].colorMarcador + ";border:none;height:2px;' /></th>";
							}else{
								output[output.length] = "' >&nbsp;</th>";
							}
						}
						if(anchoTablaAux>0){
						    output[output.length] = "<th style='vertical-align:top;height:5px;";
							output[output.length] = "width:" + (anchoTablaAux+anchoScroll) + "px;max-width:" + (anchoTablaAux+anchoScroll) + "px;min-width:" + (anchoTablaAux+anchoScroll) + "px;";
							output[output.length] = "' ><hr style='background-color:" + this._columnas[0].colorMarcador + ";border:none;height:2px;' /></th>";
						}
						output[output.length] = "</tr>";
										
					}
					output[output.length] = "<tr>";
					if( this._seleccionMultiple == true ){
						output[output.length] = "<th class='grid' style='width:" + anchoCheckbox + "px;" + separacionVertical;
						output[output.length] = "background: -webkit-gradient(linear, left top, left bottom, from(" + this._colorEncabezado1 + "), to(" + this._colorEncabezado2 +"));";
						output[output.length] = "background: -moz-linear-gradient(top,  " + this._colorEncabezado1 + ",  " + this._colorEncabezado2 + ");";
						output[output.length] = "color:" + this._colorLetraEncabezado + ";";
						output[output.length] = bordes;
						output[output.length] = "' onclick='" + this._id +".seleccionarTodo()'";
						output[output.length] = " >&nbsp;</th>";
					}
					var jj = this._columnas.length;
					for(var j=0 ; j < jj ; j++ ){
						output[output.length] = "<th class='grid' style='" + separacionVertical;
						if(j == jj-1){
							output[output.length] = "width:" + (anchoColumnas[j]+anchoScroll) + "px;max-width:" + (anchoColumnas[j]+anchoScroll) + "px;min-width:" + (anchoColumnas[j]+anchoScroll) + "px;";
						} else{
							output[output.length] = "width:" + anchoColumnas[j] + "px;max-width:" + anchoColumnas[j] + "px;min-width:" + anchoColumnas[j] + "px;";
						}
						output[output.length] = "background: -webkit-gradient(linear, left top, left bottom, from(" + this._colorEncabezado1 + "), to(" + this._colorEncabezado2 +"));";
						output[output.length] = "background: -moz-linear-gradient(top,  " + this._colorEncabezado1 + ",  " + this._colorEncabezado2 + ");";
						output[output.length] = "color:" + this._colorLetraEncabezado + ";";
						output[output.length] = bordes;
						output[output.length] = "' ";
						if(this._columnas[j].reacomodable == true){
							output[output.length] = " onclick='" + this._id +".reacomodaColumnas(" + this._id + "._columnas[" +j + "], "+ j + ", this)'";
						}
						output[output.length] = " >" + this._columnas[j].titulo + "</th>";
					}
					   if(anchoTablaAux>0){
							output[output.length] = "<th class='grid' style='" + separacionVertical;
							output[output.length] = "width:" + anchoTablaAux + "px;max-width:" + anchoTablaAux+ "px;min-width:" + anchoTablaAux + "px;";
						
						output[output.length] = "background: -webkit-gradient(linear, left top, left bottom, from(" + this._colorEncabezado1 + "), to(" + this._colorEncabezado2 +"));";
						output[output.length] = "background: -moz-linear-gradient(top,  " + this._colorEncabezado1 + ",  " + this._colorEncabezado2 + ");";
						output[output.length] = "color:" + this._colorLetraEncabezado + ";";
						output[output.length] = bordes;
						output[output.length] = "' ";
						output[output.length] = " ></th>";							
							
							
						}
					output[output.length] = "</tr>";
					output[output.length] = "</thead>";
				}
				//output[output.length] = "<tbody class='grid' style='height:" + (viewport.offsetHeight-altoEncabezado) + "px;width:" + ( anchoTabla + anchoScroll ) +"px'>";
				

               if(this._tieneDragDrop== true){
                  	if(this._aceptaDrop== true){
                   	    if(this._aceptaDropEncualquierParte==true){
				           output[output.length] = "<tbody id='" + this._viewport + "Tbody'  ondrop='"+this._id+".dropDR(event)'  ondragover='"+this._origen+"."+this._id+".allowDrop(event)'     class='grid' style='height:" + (viewport.offsetHeight-altoEncabezado-altoPie) + "px;";
				         }else{
				            output[output.length] = "<tbody id='" + this._viewport + "Tbody'   ondrop='"+this._origen+"."+this._id+".drop(event)' ondragover='"+this._origen+"."+this._id+".allowDrop(event)'     class='grid' style='height:" + (viewport.offsetHeight-altoEncabezado-altoPie) + "px;";
				         }
				     }else{
				        if(this._aceptaDelete== true){
				             output[output.length] = "<tbody id='" + this._viewport + "Tbody'  ondrop='"+this._id+".dropD(event)'  ondragover='"+this._origen+"."+this._id+".allowDrop(event)'     class='grid' style='height:" + (viewport.offsetHeight-altoEncabezado-altoPie) + "px;";
				           }else{
				             output[output.length] = "<tbody id='" + this._viewport + "Tbody'  ondrop='"+this._id+".dropE(event)'  ondragover='"+this._origen+"."+this._id+".allowDrop(event)'     class='grid' style='height:" + (viewport.offsetHeight-altoEncabezado-altoPie) + "px;";
				           }
				      } 
			   }else{
			     output[output.length] = "<tbody id='" + this._viewport + "Tbody'    class='grid' style='height:" + (viewport.offsetHeight-altoEncabezado-altoPie) + "px;";
			   }	

                 // esto es para que el grid tengasu propio scroll horizontal
				/*if(this._scrollHorizontal==false){ 
				   output[output.length] = " overflow-x:hidden; ";
				}*/
				output[output.length] = " overflow-x:hidden; ";
								
				output[output.length] = "'>";
				iLength = this._dataProvider.length;
				registrosExtras =this._regExtra;
				
				if(iLength>=registrosExtras)
				{
				  registrosExtras=0;
				}else{
				 registrosExtras= registrosExtras-iLength;
				}
				
				for(var i=0; i<iLength;i++ ){
					var color;
					if(i%2 == 0){
						color=this._colorRenglon1;
					}else{
						color=this._colorRenglon2;
					}
					if(this._tieneDragDrop== true){
					 output[output.length] = "<tr id='" + this._viewport + "Table" + i + "' style=''  draggable='true' ondragstart='"+this._origen+"." + this._id + ".drag(event,"+this._origen+"."+ this._id + "._dataProvider[" + i + " ]," + i+ ")');'  ondrop = undefined ";
					}else{
					 output[output.length] = "<tr id='" + this._viewport + "Table" + i + "' style=''   ondrop = undefined ";
					}
					output[output.length] = " ontouchstart='"+this._id+".touchRow(event," + this._id + "._dataProvider[" + i + " ]," + i+ ")'";
					output[output.length] = " ontouchend='"+this._id+".untouchRow(event," + this._id + "._dataProvider[" + i + " ]," + i+ ")'";
					output[output.length] = " ontouchmove='"+this._id+".movetouch(event," + this._id + "._dataProvider[" + i + " ]," + i+ ")'";
					output[output.length] = " onclick='"+this._origen+"."+this._id+".clickRow(event," +this._origen+"."+ this._id + "._dataProvider[" + i + " ]," + i+ ")'";
					output[output.length] = " ondblclick='"+this._origen+"."+this._id+".dblclickRow(event,"+this._origen+"." + this._id + "._dataProvider[" + i + " ]," + i+ ")'";
					output[output.length] = ">";
					if( this._seleccionMultiple == true ){
						output[output.length] = "<td class='grid' style='width:" + anchoCheckbox + "px;"+separacionVertical;
						output[output.length] = "background-color:" + color + ";";
						output[output.length] = "color:" + this._colorLetraCuerpo + ";";
						output[output.length] = bordes;
						output[output.length] = "' ><center>";
						output[output.length] = "<input type='checkbox' id='" + this._id + "chk" + i + "'"; 
						output[output.length] = " onclick='"+this._id+".clickCheck(event," + this._id + "._dataProvider[" + i + " ]," + i+ ")'";
						output[output.length] = " '/></center>";
						output[output.length] = "</td>";
					}
					var kk = this._columnas.length;
					for(var k = 0 ; k < kk ; k++ ){
						var campoActual;
						campoActual = this._columnas[k].alias;
						output[output.length] = "<td class='grid' style='vertical-align: top;" +separacionVertical;
						var sumar = 0;
						
						if( k == kk-1){
							sumar = anchoScroll;
						}
						
						output[output.length] = "width:" + (anchoColumnas[k]+sumar) + "px;max-width:" + (anchoColumnas[k]+sumar) + "px;min-width:" + (anchoColumnas[k]+sumar) + "px;";
						output[output.length] = this.generaEstiloCampo(this._columnas[k]);
						output[output.length] = "background-color:" + color + ";";
						output[output.length] = "color:" + this._colorLetraCuerpo + ";";
						output[output.length] = bordes;
						output[output.length] = "'    title = '" + this.generaToolTipCampo(this._dataProvider[i], this._columnas[k]) + "' >";
						output[output.length] = this.generaFormatoCampo(this._dataProvider[i], this._columnas[k]) ;
						output[output.length] = "</td>";
					}
					if(anchoTablaAux>0){
						output[output.length] = "<td class='grid' style='vertical-align: top;" +separacionVertical;
						var sumar = 0;
						if( k == kk-1){
							sumar = anchoScroll;
						}
						output[output.length] = "width:" + (anchoTablaAux+sumar) + "px;max-width:" + (anchoTablaAux+sumar) + "px;min-width:" + (anchoTablaAux+sumar) + "px;";
						output[output.length] = "background-color:" + color + ";";
						output[output.length] = "color:" + color + ";";
						output[output.length] = bordes;
						output[output.length] = "' title = '' >";
						output[output.length] = this.generaFormatoCampo(""," ") ;
						output[output.length] = "</td>";
						}
				output[output.length] = "</tr>";
				}
				/*
				* extra
				*/
				for(var j=0; j<registrosExtras;j++ ){
					var color;
					if(j%2 == 0){
					   color=this._colorRenglon1;
					}else{
						color=this._colorRenglon2;
					}
					output[output.length] = "<tr id='" + this._viewport + "Table" + j + "' style='' ";
					output[output.length] = ">";
					var kk = this._columnas.length;
					for(var k = 0 ; k < kk ; k++ ){
						var campoActual;
						campoActual = this._columnas[k].alias;
						output[output.length] = "<td class='grid' style='vertical-align: top;" +separacionVertical;
						var sumar = 0;
						output[output.length] = "width:" + (anchoColumnas[k]+sumar) + "px;max-width:" + (anchoColumnas[k]+sumar) + "px;min-width:" + (anchoColumnas[k]+sumar) + "px;";
						output[output.length] = this.generaEstiloCampo(this._columnas[k]);
						output[output.length] = "background-color:" + color + ";";
						output[output.length] = "color:"+color+";";
						output[output.length] = bordes;
						output[output.length] = "' title = '' >";
						output[output.length] = this.generaFormatoCampo(" ", " ") ;
						output[output.length] = "</td>";
					}
						  
					if(anchoTablaAux>0){
						output[output.length] = "<td class='grid' style='vertical-align: top;" +separacionVertical;
						var sumar = 0;
						if( k == kk-1){
							sumar = anchoScroll;
						}
						output[output.length] = "width:" + (anchoTablaAux+sumar) + "px;max-width:" + (anchoTablaAux+sumar) + "px;min-width:" + (anchoTablaAux+sumar) + "px;";
						output[output.length] = "background-color:" + color + ";";
						output[output.length] = "color:" + color + ";";
						output[output.length] = bordes;
						output[output.length] = "' title = '' >";
						output[output.length] = this.generaFormatoCampo("","") ;
						output[output.length] = "</td>";
						}
					output[output.length] = "</tr>";
				}
				
				
				output[output.length] = "</tbody>";
				
			
				if( this._presentacionGranTotal == "SI"){
					
					this._totales = this.calculaTotales();
					
					output[output.length] = "<tfoot >";
					output[output.length] = "<tr style ='display:block;'>";
					
					
					iLength = this._columnas.length;
					for(var k=0 ; k<iLength; k++ ){
						
							/*output[output.length] = "<td class='gridBase' style='" + generaEstiloCampo(this._campos[i]) + this._bordes;
							if(this._tieneAjuste && this.tieneAjusteCampo(this._campos[i])){
								output[output.length] = "width:auto;";
							}else{
								output[output.length] = "width:" + anchoColumnas[i] + "px;max-width:" + anchoColumnas[i] + "px;min-width:" + anchoColumnas[i] + "px;";
							}
							output[output.length] = "background-color:#dddddd;" + this._bordesRedondeados + "word-wrap: break-word;'>";
							output[output.length] = generaFormatoCampo(this._totales[this._campos[i].alias], this._campos[i]) + "</td>";
						
						*/
						
						
						
						var campoActual;
							campoActual = this._columnas[k].alias;
							output[output.length] = "<td class='grid' style='padding:4 0 4 2; vertical-align: top;" +separacionVertical;
							var sumar = 0;
							
							output[output.length] = "width:" + (anchoColumnas[k]+sumar) + "px;max-width:" + (anchoColumnas[k]+sumar) + "px;min-width:" + (anchoColumnas[k]+sumar) + "px;";
							output[output.length] = this.generaEstiloCampo(this._columnas[k]);
							output[output.length] = "background-color:#dddddd;";
							output[output.length] = "color:#000000;font-weight: normal;font-style:normal;border-width:1px;border-color:#e8e8e8;background-color:#dddddd;-moz-border-radius:6px; border-radius:6px;-border-radius:6px;word-wrap: break-word;"
							output[output.length] = this.generaFormatoCampo(this._totales, this._columnas[k]) ;
							output[output.length] = "</td>";
					}
					if(anchoTablaAux>0){
						var sumar = 0;
						if( k == iLength-1){
							sumar = anchoScroll;
						}
						output[output.length] = "<td class='grid' style='padding:4 0 4 4; vertical-align: top;" +separacionVertical;
						output[output.length] = "width:" + (anchoTablaAux+sumar) + "px;max-width:" + (anchoTablaAux+sumar) + "px;min-width:" + (anchoTablaAux+sumar) + "px;";
						output[output.length] = "background-color:#dddddd;";
						output[output.length] = "color:#dddddd;font-weight: normal;font-style:normal;border-width:1px;border-color:#e8e8e8;background-color:#dddddd;-moz-border-radius:6px; border-radius:6px;-border-radius:6px;word-wrap: break-word;"
						//
						output[output.length] = this.generaFormatoCampo("","") ;
						output[output.length] = "</td>";
						}
					output[output.length] = "</tr>";
					output[output.length] = "</tfoot>";
				}
			output[output.length] = "</table>";
			viewport.innerHTML = output.join('');
			if(this._seleccionMultiple == true){
				this.seleccionarTodo()
			}
			this._selectedItem = null;
			this._selectedRow = null;
			this._selectedRowId = null;
			this._reacomodando = false;
			this._selectedItems = [];
			//$("#" + this._viewport + "Table").tablesorter(); 
		}catch(error){
			throw "error al renderizar el grid :" + this._id + " . " + error;
			return false;
		}
		return true;
	}
	
	
	var totalesGridBase;
	this.calculaTotales = function()
	{
		var totales = {};
		totalesGridBase=totales;
		if( this._presentacionGranTotal == "SI"){
			var ii = this._columnas.length; 
			for(var i=0; i<ii ; i++){
				var campo = this._columnas[i].alias;
				if(this._columnas[i].agregarTotal == true)
				{
					var jj = this._dataProvider.length;
					totales[campo] = 0;
					for(var j=0; j<jj ; j++)
					{
						if(this._dataProvider[j][campo].includes(":"))
						{
							if(this._columnas[i].tipoTotal=="MAX")
							{
								totales[campo] =this.mayorHoras(this._dataProvider,campo)
									
							}
							else if(this._columnas[i].tipoTotal=="TP")
							{
								totales[campo] =this.promedioHoras(this._dataProvider,campo,this._columnas[i].formulaTotal)
								
							}
							else if(this._columnas[i].tipoTotal=="P")
							{
								totales[campo] =this.normalPromedioHoras(this._dataProvider,campo,this._columnas[i].formulaTotal)
								
							}
							else
							{
							   	totales[campo] =this.sumaHoras(this._dataProvider,campo)
							   	
							}
							break;							
						}	
						else
						{
							if(this._columnas[i].tipoTotal=="MAX")
							{
								totales[campo] =this.mayor(this._dataProvider,campo)
								break;									
							}
							else if(this._columnas[i].tipoTotal=="MIN")
							{
								totales[campo] =this.menor(this._dataProvider,campo)
								break;									
							}
							else if(this._columnas[i].tipoTotal=="P")
							{
								totales[campo] =this.promedioNormal(this._dataProvider,campo)
								break;									
							}
							else if(this._columnas[i].tipoTotal=="C")
							{
								totales[campo] =this._dataProvider.length;
								break;									
							}
							else
								totales[campo] += +this._dataProvider[j][campo];
						}
					}									
				}
				else if(this._columnas[i].agregarTotalFuncion == true)
				{
					totales[campo] = this.calcuarPorcentaje(this._columnas[i].expresion,this._dataProvider,campo,this._columnas[i]);
				}
				else
				{
					totales[campo] = "";
				}
			}
		}else{
			
		}
		return totales;
	}
	/*
	* Esta funcion nos permite reacomodar las columnas
	* si no estamos reacomodando, nos marca la columna diferente y nos permite pasarla
	*/
	this.reacomodaColumnas = function (columna , indiceColumna, elementoth)
	{
		if(this._reacomodando == true){
			
			//this._elementothSeleccionado.className = "grid";
			this._elementothSeleccionado.style.opacity = 1.0;
			/*
			* solo generamos el evento si dejamos caer la columna en una posicion diferente 
			*/
			if( this._indiceColumnaSeleccionada != indiceColumna){
				generarEvento = true;
				var datosEvent = new Object();
				datosEvent.columnaNueva = columna;
				datosEvent.columnaAnterior = this._columnaSeleccionada;
				datosEvent.indiceColumnaNueva = indiceColumna;
				datosEvent.indiceColumnaAnterior = this._indiceColumnaSeleccionada;
				var evento = new Evento("eventGridReacomodaColumnas", datosEvent);
				manejadorEventos.disparaEvento(evento);
				this.disparaEvento(evento);
			}
			this._columnaSeleccionada = null;
			this._indiceColumnaSeleccionada = null;		
			this._elementothSeleccionado = null;
			this._reacomodando = false;
		}else{
			this._columnaSeleccionada = columna;
			this._indiceColumnaSeleccionada = indiceColumna;
			this._elementothSeleccionado = elementoth;
			this._reacomodando = true;
			//this._elementothSeleccionado.className = "#000000";
			this._elementothSeleccionado.style.opacity = 0.1;
			
		}
	}

	/*
	* Genera el estilo del campo
	*/
	this.generaEstiloCampo = function (campoBase)
	{
		var estilo="";
		if(campoBase.alineacion == 'I'){
			estilo += "text-align:left;";
		} else if(campoBase.alineacion == 'C'){
			estilo += "text-align:center;";
		} else if(campoBase.alineacion == 'D'){
			estilo += "text-align:right;";
		}
		return estilo;
	}
	
	/*
	* Genera el contenido del campo
	*/
	this.generaFormatoCampo = function (renglon, campoBase){
		var contenido = "<div style='";
		if(this._ajustarAltura == true ){
			contenido += "height:auto;";
		}else{
			contenido += "height:1em;";
		}
		contenido += "overflow:hidden;padding:4 4 4 4;'>";
		var itemRender = campoBase.itemRender;
		var contexto = campoBase.contexto;
		if( itemRender == undefined || itemRender == null)
		{
			
				if(campoBase.miles==="S"){
			      contenido += this.separador_miles(renglon[campoBase.alias],2)    
			    }else{
			      contenido += renglon[campoBase.alias];
			    }
			
		}else{
			//contenido += window[itemRender](renglon, campoBase);
			if(contexto != null && contexto != undefined){
				contenido += itemRender.call( contexto, renglon, campoBase);
			}else{		
						
				contenido += itemRender( renglon, campoBase);
			}
		}
		contenido += "</div>";
		return contenido;
	}

	/*
	* Genera el tooltip del campo
	*/
	this.generaToolTipCampo= function (renglon, campoBase){
		var tooltipRender = campoBase.tooltipRender ;
		var contexto = campoBase.contexto;
		if( tooltipRender == undefined || tooltipRender == null){
			return renglon[campoBase.alias];
		}else{
			//return window[tooltipRender ](renglon, campoBase);
			if(contexto != null && contexto != undefined){
				return tooltipRender.call( contexto, renglon, campoBase);
			}else{
				return tooltipRender( renglon, campoBase);
			}
		}
	}
	this.separador_miles=function(amount, decimals) {

    amount += ''; // por si pasan un numero en vez de un string
    amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

    decimals = decimals || 0; // por si la variable no fue fue pasada

    // si no es un numero o es igual a cero retorno el mismo cero
    if (isNaN(amount) || amount === 0) 
        return "";//parseFloat(0).toFixed(decimals);

    // si es mayor o menor que cero retorno el valor formateado como numero
    amount = '' + amount.toFixed(decimals);

    var amount_parts = amount.split('.'),
        regexp = /(\d+)(\d{3})/;

    while (regexp.test(amount_parts[0]))
        amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

    return amount_parts.join('.');
}
	/*
	* Selecciona todos los registros del grid
	*/
	this.seleccionarTodo = function (){
		for(var  i = 0 ; i <  this._dataProvider.length ; i++ ){
			var check = document.getElementById(this._id + "chk" + i);
			check.checked = this._seleccionarTodos;
		}
		if(this._seleccionarTodos == false){
			this._selectedItems = [];
		}else{
			this._selectedItems = this._dataProvider;
		}
		this._seleccionarTodos = !this._seleccionarTodos;
		if(this._selectedItems.length > 0){
			this._selectedItem = this._selectedItems[this._selectedItems.length-1];
		}else{
			this._selectedItem = null;
		}
	}
	
	/*
	* dispara el evento de dar click en un renglon
	* primero genera un objeto con los nombres de campo adecuados
	* despues marca como seleccionado el renglon del grid al que dimos click
	*/
	this.clickCheck =  function (e, datos, rowNo){
		var datosEvent = new Object();
		var check = document.getElementById(this._id + "chk" + rowNo);
		if(check.checked == true){
			this._selectedItems.push(datos);
		}else{
			for( var i = 0; i < this._selectedItems.length ;i++ ){
				if( datos === this._selectedItems[i]){
					this._selectedItems.splice(i, 1);
					break;
				}
			}
		}
		if(this._selectedItems.length > 0){
			this._selectedItem = this._selectedItems[this._selectedItems.length-1];
		}else{
			this._selectedItem = null;
		}
		datosEvent.seleccionado = check.checked;
		datosEvent.datos = datos;
		datosEvent.event = e;
		datosEvent.target = this;
		datosEvent.renglon = rowNo;
		var evento = new Evento("eventGridRowClickCheck", datosEvent);
		manejadorEventos.disparaEvento(evento);
	}

	/*
	* dispara el evento de dar click en un renglon
	* primero genera un objeto con los nombres de campo adecuados
	* despues marca como seleccionado el renglon del grid al que dimos click
	*/
	this.clickRow =  function (evento, datos, rowNo){
		var datosEvent = new Object();
		if(this._seleccionMultiple == false){
			if(this._selectedRow != null ){
				for(var i=0;i<this._selectedRow.childNodes.length;i++){
					this._selectedRow.childNodes[i].style.backgroundColor=this.colorAnterior; 
				}
			}
			if(this._deseleccionar == true && this._selectedRowId == rowNo){
				for(var i=0;i<this._selectedRow.childNodes.length;i++)	{
					this._selectedRow.childNodes[i].style.backgroundColor=this.colorAnterior; 
				}
				this._selectedRow = null;
				this._selectedItem = null;
				this._selectedRowId = null;
			}else{
				this._selectedRow = document.getElementById(this._viewport + "Table" + rowNo);
				for(var i=0;i<this._selectedRow.childNodes.length;i++){
					this.colorAnterior = this._selectedRow.childNodes[i].style.backgroundColor;
					this._selectedRow.childNodes[i].style.backgroundColor='#B2E1FF'; 
				}
				this._selectedIndex = this._selectedRowId = rowNo;
				this._selectedItem = datos; 
			}
			if(this._selectedRowId == null){
				datosEvent.seleccionado = false;
			}else{
				datosEvent.seleccionado = true;
			}
		}
		datosEvent.datos = datos;
		datosEvent.event = evento;
		datosEvent.target = this;
		datosEvent.renglon = rowNo;
		datosEvent.grid = this;
		var evento = new Evento("eventGridRowClick", datosEvent);
		this.manejadorEventos.disparaEvento(evento);
		this.disparaEvento(evento);
	}

	/*
	* dispara el evento de dar doble click en un renglon regresa el objeto de datos, pero con sus campos
	* nombrados en base al alias
	*/
	this.dblclickRow =  function (e, datos, row){
		var datosEvent = new Object();
		datosEvent.datos = datos;
		datosEvent.event = e;
		datosEvent.target = this;
		datosEvent.renglon = row;
		datosEvent.grid = this;
		var evento = new Evento("eventGridRowDoubleClick", datosEvent);
		this.manejadorEventos.disparaEvento(evento);
		this.disparaEvento(evento);
	}

	/*
	* dispara el evento de dar simple o doble click en un renglon
	*/
	this.touchRow =  function (e, datos, row){
		//e.preventDefault();
		this.thisTouch = new Date().getTime();
		this.thisRow = row;
		if((this.lastTouch != undefined) && (this.thisTouch  - this.lastTouch < 1500 && (this.thisTouch  - this.lastTouch > 200))
			&& (this.lastRow != undefined) && (this.thisRow  == this.lastRow ) ){
			this.lastTouch = 0;
			this.lastRow = -1;
			this.dblclickRow(e, datos, row);
		}else {
			this.lastTouch = this.thisTouch;
			this.lastRow = this.thisRow;
			this.clickRow(e, datos, row);
		}
		if(e.touches.length == 1){
			this.touchIn = new Date().getTime();
			setTimeout(this._id+".checaHold(" + e.targetTouches[0].pageX + "," + e.targetTouches[0].pageY + "," + this.touchIn + ")", 1000);
		}else{
			this.touchIn = 0;
		}
	}
	
	/*
	* resetea la bandera para cuando dejamos de tocar el renglon
	*/
	this.untouchRow =  function (e, datos, row){
		this.touchIn = 0;
	}

	/*
	* resetea la bandera para cuando movemos el dedo
	*/
	this.movetouch  =  function (e, datos, row){
		//this.touchIn = 0;
	}

	/*
	* checa si duramos con el dedo presionado mas de 2 segundos
	*/
	this.checaHold =  function (x, y, toque){
		if(this.touchIn == toque){
			var datosEvent = new Object();
			datosEvent.x = x;
			datosEvent.y = y;
			datosEvent.grid = this;
			var evento = new Evento("eventGridRowTouchSostenido", datosEvent);
			this.manejadorEventos.disparaEvento(evento);
		}
	}
		
	this.eliminaDuplicados =  function (){
		var out = new Array();
		var obj = new Object();
		var ii = this._dataProvider.length;
		for(var i = 0 ; i < ii ; i++){
			///obj[this._dataProvider[i][campos[0].alias]]
			obj[this._dataProvider[i].label] = this._dataProvider[i]; 
		}
		for(var prop in obj){
			if(obj[prop].label != ""){
				out.push(obj[prop]);
			}
		}
		this._dataProvider = out;
	}
	
	this.scrollToEnd = function ()
	{
		if(esExplorer == false){
			var elem = document.getElementById(this._viewport + "Tbody");
	  		elem.scrollTop = elem.scrollHeight;
		}else{
			var viewport = document.getElementById(this._viewport);
			viewport.scrollTop  = viewport.scrollHeight;
		}
	}
	
this.allowDrop = function(ev){
  ev.preventDefault();
}


this.drag = function(ev, datos, rowNo){ 
    ev.dataTransfer.setData("text", ev.target.id);

    
        this.datosEventX = new Object();
		if(this._seleccionMultiple == false){
			if(this._selectedRow != null ){
				for(var i=0;i<this._selectedRow.childNodes.length;i++){
					this._selectedRow.childNodes[i].style.backgroundColor=this.colorAnterior; 
				}
			}
			if(this._deseleccionar == true && this._selectedRowId == rowNo){
				for(var i=0;i<this._selectedRow.childNodes.length;i++)	{
					this._selectedRow.childNodes[i].style.backgroundColor=this.colorAnterior; 
				}
				this._selectedRow = null;
				this._selectedItem = null;
				this._selectedRowId = null;
			}else{
				this._selectedRow = document.getElementById(this._viewport + "Table" + rowNo);
				for(var i=0;i<this._selectedRow.childNodes.length;i++){
					this.colorAnterior = this._selectedRow.childNodes[i].style.backgroundColor;
					this._selectedRow.childNodes[i].style.backgroundColor='#B2E1FF'; 
				}
				this._selectedIndex = this._selectedRowId = rowNo;
				this._selectedItem = datos;
			}
			if(this._selectedRowId == null){
				this.datosEventX.seleccionado = false;
			}else{
				this.datosEventX.seleccionado = true;
			}
		}
		this.datosEventX.datos = datos;
		this.datosEventX.event = ev;
		this.datosEventX.target = this;
		this.datosEventX.renglon = rowNo;
		this.datosEventX.grid = this;
		
		var evento = new Evento("drag", this.datosEventX);
		this.manejadorEventos.disparaEvento(evento);
		this.disparaEvento(evento);
}
this.drop = function(ev){
   var data = ev.dataTransfer.getData("text");
   
   if(data!=""){  
       if(ev.target.localName=="tbody"){
         // if(ev.currentTarget.id!=IdIniciodrag){
	      var clonn = document.getElementById(data);
	      var clon = clonn.cloneNode(true);
	      clon.ondrop = undefined;
	    //clon.ondragover = undefined;
	    //clon.ondragstart = undefined;
	    
	    //si es un tr si podemos aceptarlo si es otro objecto no lo debe de agregar
	      ev.target.appendChild(clon);
	   //}
	   
		var evento = new Evento("drop", this.datosEventX);
		this.manejadorEventos.disparaEvento(evento);
		this.disparaEvento(evento);
 	   
	   
	   
	   
	   
      }
    }
    ev.preventDefault();
 }
 
 
 
 
/*
* Drop para solo seleccionar este no acepta nodos ni los borra
*/ 
this.dropE = function(ev) {  
       ev.preventDefault();
 }
/*
* Drop acepta el nodo y lo borra
*/ 
this.dropD = function(ev) { 
 var arreglo  = ev.currentTarget.children;
 var data = ev.dataTransfer.getData("text");
    if(data!=""){  
       if(ev.target.localName=="tbody"){
	        ev.target.appendChild(document.getElementById(data));
	        ev.target.removeChild(document.getElementById(data));
		    var evento = new Evento("dropD", this.datosEventX);
		    this.manejadorEventos.disparaEvento(evento);
			this.disparaEvento(evento);
       }
     }
     ev.preventDefault();   
 }
/*
* Drop acepta el nodo en culaquier parte y lo borra
*/ 
this.dropDR = function(ev) { 
    var arreglo  = ev.currentTarget.children;
    var data = ev.dataTransfer.getData("text");
	var evento = new Evento("dropDR", this.datosEventX);
	this.manejadorEventos.disparaEvento(evento);
	this.disparaEvento(evento);
    ev.preventDefault();   
 }


 	
};	

GridReg.inheritsFrom(Base);