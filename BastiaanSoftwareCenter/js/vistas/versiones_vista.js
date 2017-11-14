class VersionesVista
{		
	constructor(ventana)
	{	
		this.ventana = ventana;
		this.presentador = new VersionesPresentador(this);
		this.manejadorEventos = new ManejadorEventos();
		this.grid = new GridReg("grid");
	    this.grid2= new GridReg("grid2");
	    this.grid3= new GridReg("grid3");	    
	}
	onLoad()
	{			
		this.crearColumnasGrid();
		this.cargargridCriterio();
		this.presentador.consultar();
	    //this.presentador.consultarPorVersion();
	   //this.presentador.consultarPorCampo();

	}
	crearColumnasGrid()
	{
		this.grid._columnas = [
			{longitud:100, 	titulo:"Id",   	alias:"id", alineacion:"I" },
			{longitud:200, 	titulo:"Descripciòn Corta",   alias:"descripcionCorta", alineacion:"I", tamano:"15" },
		    {longitud:200, 	titulo:"Descripciòn Larga",   alias:"descripcionLarga", alineacion:"I" },
			{longitud:200, 	titulo:"principal",   alias:"nombrePila", alineacion:"I" },
			{longitud:200, 	titulo:"Fecha",   alias:"fecha", alineacion:"I" },
			{longitud:200, 	titulo:"Hora",   alias:"hora", alineacion:"I" }
        ];
		this.grid._origen="vista";
		this.grid.manejadorEventos=this.manejadorEventos;
		this.grid._ajustarAltura = true;
		this.grid._colorRenglon1 = "#FFFFFF";	
		this.grid._colorRenglon2 = "#f8f2de";
		this.grid._colorEncabezado1 = "#FF6600";
		this.grid._colorEncabezado2 = "#FF6600";
		this.grid._colorLetraEncabezado = "#ffffff";
		this.grid._colorLetraCuerpo = "#000000";
		this.grid._regExtra=20;
		//this.grid._presentacionGranTotal = "SI";
		this.grid.render();		
	}
	cargargridCriterio()
	{		 
		
		 this.grid2._columnas = [
			 
			{longitud:200, 	titulo:"titulo",   	alias:"titulo", alineacion:"I" },
				{longitud:250, 	titulo:"presentar",   alias:"presentacion", alineacion:"I", itemRender:this.renderSwitch},
				{longitud:250, 	titulo:"orden",   alias:"orden", alineacion:"C" },
				{longitud:250, 	titulo:"Catalogo de Cliente",   alias:"tablaId", alineacion:"I" }
				                ];
			this.grid2._origen="vista";
			this.grid2.manejadorEventos=this.manejadorEventos;
			this.grid2._ajustarAltura = true;
			this.grid2._colorRenglon1 = "#FFFFFF";	
			this.grid2._colorRenglon2 = "#f8f2de";
			this.grid2._colorEncabezado1 = "#FF6600";
			this.grid2._colorEncabezado2 = "#FF6600";
			this.grid2._colorLetraEncabezado = "#ffffff";
			this.grid2._colorLetraCuerpo = "#000000";
			this.grid2._regExtra=12;
			this.grid2._tieneDragDrop= true;
	        this.grid2._aceptaDrop=true;
	        this.grid2.subscribirAEvento(this, "drop",this.agregarSalida );
		//	this.grid2._presentacionGranTotal = "SI";
			this.grid2.render();
			// este el grid 3
			this.grid3._columnas = [
				{longitud:200, 	titulo:"Titulo campo", 	alias:"tituloCampo", alineacion:"I" },
				{longitud:200, 	titulo:"Tipo Campo", 	alias:"tipoCampo", alineacion:"I" },
				{longitud:200, 	titulo:"Tamaño Campo", 	alias:"tamanoCampo", alineacion:"I" },
				{longitud:200, 	titulo:"Tabla", 	alias:"tablaId", alineacion:"I" },
				{longitud:200, 	titulo:"Tipo de Campo", 	alias:"tamanoCampo", alineacion:"I" },
				{longitud:200, 	titulo:"Numero de Campo", 	alias:"campoNumero", alineacion:"I" }
			                        ];
			this.grid3._origen="vista";
			this.grid3.manejadorEventos=this.manejadorEventos;
			this.grid3._ajustarAltura = true;
			this.grid3._colorRenglon1 = "#FFFFFF";	
			this.grid3._colorRenglon2 = "#f8f2de";
			this.grid3._colorEncabezado1 = "#FF6600";
			this.grid3._colorEncabezado2 = "#FF6600";
			this.grid3._colorLetraEncabezado = "#ffffff";
			this.grid3._colorLetraCuerpo = "#000000";
			this.grid3._regExtra=20;
			this.grid3._tieneDragDrop= true;
	        this.grid3._aceptaDrop=false;	
	        this.grid3.subscribirAEvento(this, "drop",this.drop );
			this.grid3.subscribirAEvento(this, "drag",this.recuperaItemDrag);
		//	this.grid3._presentacionGranTotal = "SI";
			this.grid3.render();	
			this.a=0;
		    
		    var a = 0;
	 }
	/*
	 * Eventos en botones
	*/
		btnAlta_onClick()
	{
		this.modo = "ALTA";
		this.limpiarFormulario();	
		this.mostrarFormulario();		
	}
		
		btncriterios_onClick()
		{
		    this.modo = "CRITERIOS";
	        this.mostrarCriterios();
	        this.presentador.consultarPorCampo();
		    this.presentador.consultarPorVersion();
		    
		    var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1;
			var yyyy = today.getFullYear();
			
			if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} 
				var strToday = new Date(mm+'/'+dd+'/'+yyyy); // = '01/'+mm+'/'+yyyy;
			var strTodayFirst = new Date(mm+'/'+'01/'+yyyy); // = '01/'+mm+'/'+yyyy;
			
			
			$("#"+ "fechaFormularioInput").datepicker( {dateFormat:'dd/mm/yy'});
			$("#"+ "fechaFormularioInput").datepicker( "option", $.datepicker.regional[ 'es' ] );
			$("#"+ "fechaFormularioInput").datepicker({showOn:'button', buttonImage:'assets/botones/calendario.svg', buttonImageOnly:true});
			$("#"+ "fechaFormularioInput").datepicker('option', {dateFormat:'dd/mm/yy'});
			$("#"+ "fechaFormularioInput").datepicker("setDate", strTodayFirst);
			$("#"+ "fechaFormularioInput").datepicker();	
			
			if(this.grid._selectedItem!=null)
			{			
				this.modo = "CAMBIO";
				this.limpiarFormulario();	
				this.mostrarFormulario();		
				this.presentador.consultarPorLlaves();
			}
			else
				this.mostrarMensaje("Selecciona un registro para modificar.");
		}	
		

		
		btnConsulta_onClick()
		{
			this.presentador.consultar();
			//this.presentador.ocultar();
			
		}	
		
		
	btnBaja_onClick()
	{ 
		if(this.grid._selectedItem!=null)
		{
			var confirmacion = confirm("¿Esta seguro que desea eliminar el registro?")
		    if (confirmacion)
		    {
		    	this.presentador.eliminar();
		    }	
		}
		else
			this.mostrarMensaje("Selecciona un registro para eliminar.");
	}
	
	
	btnCambio_onClick()
	{
		if(this.grid._selectedItem!=null)
		{			
			this.modo = "CAMBIO";
			this.limpiarFormulario();	
			this.mostrarFormulario();		
			this.presentador.consultarPorLlaves();
		}
		else
			this.mostrarMensaje("Selecciona un registro para modificar.");
				
	}
	

	
	btnGuardarFormulario_onClick()
	{		
		 var campoObligatorioVacio = this.campoObligatorioVacio();
		 if(campoObligatorioVacio==null)
		 {
			/*if(this.modo=='ALTA')
				this.presentador.insertar();
			  // this.presentador.insertarGrid2();
			else
				this.presentador.actualizar();*/
		 }		
		 else
		 {
			this.mostrarMensaje('Error','El campo "' + campoObligatorioVacio.attr("descripcion") + '" es obligatorio.');
		 }
		//para el swithc
		 for(var b = 0; b < this.grid2._dataProvider.length; b++)
			{		
					if(document.getElementById(b).checked)
					{		
						
						this.grid2._dataProvider[b].presentacion="1"
					}
					else	
					{					
						this.grid2._dataProvider[b].presentacion="0"
					}			
			}
		 this.presentador.eliminar();
		 this.presentador.insertarGrid2();
		 
		//this.presentador.actualizarGrid2();
			  
		

		 
		 /*
			if(this.grid2._dataProvider!=null)
			{
				var confirmacion = confirm("¿Esta seguro que desea eliminar el registro?")
			    if (confirmacion)
			    {
			    	this.presentador.eliminar();
			    }	
			}
			else
				this.mostrarMensaje("Selecciona un registro para eliminar.");
			*/
			
			
		 
	    //	this.presentador.eliminar();
		 
		
		
			/*  insert del item  */
		    /*
			 var campoObligatorioVacio = this.campoObligatorioVacio();
			 if(campoObligatorioVacio==null)
			 {
	               this.presentador.insertarGrid2();
				  this.presentador.actualizarGrid2();
			 }	
			 else
			 {
				this.mostrarMensaje('Error','El campo "' + campoObligatorioVacio.attr("descripcion") + '" es obligatorio.');
			 }	
	       */
	}
	
	btnSalir_onClick()
	{
		var confirmacion = confirm("¿Esta seguro que desea salir?")
	    if (confirmacion)
	    	{
	    	//TODO: Cerrar ventana aqui
	    	}
	}
	
	btnSalirFormulario_onClick()
	{		
		this.salirFormulario();
	}	
	
	/*
	 * Valores de las llaves
	 */
	
	get llaves()
	{
		var llaves =
		{
			id:this.grid._selectedItem.id
		}
		return llaves;
	}
	
	/*
	 * Valores de los criterios de selección
	 */
	
	get criteriosSeleccion ()
	{
		 var criteriosSeleccion = 
		 {				    	
			id:$('#idCriterioInput').val()
		 }
		 return criteriosSeleccion;
	}		
	

	get criteriosVersion ()
	{
		 var criteriosVersion = 
		 {				    
			id:this.grid._selectedItem.id
		 }
		 return criteriosVersion;		 
	}	
	
	
	get insertarGrid2()
	{
		 var insertarGrid2 = 
		 {		
		 	datosGrid2:this.grid2._dataProvider ,
		 	versionId:$('#idFormularioInput').val()
		 }
		 return insertarGrid2;
	}	
	
	set datos(valor)
	{
		this.grid._dataProvider = valor;	
		this.grid.render();
	}
	
	
	set datosCriterios(valor)
	{
		this.grid2._dataProvider = valor;	
		this.grid2.render();
		
		for(var b = 0; b < this.grid2._dataProvider.length; b++)
		{		
			if(this.grid2._dataProvider[b].presentacion ===  "1")
			{	
				document.getElementById(b).checked = true;
			}
			else				
				document.getElementById(b).checked = false; 	
			
		}
		
	}
	
	
	
	
	set  datosCampos(valor)
	{
		this.grid3._dataProvider = valor;	
		this.grid3.render();
	}
	
	/*
	 * Mapeo de datos del formulario con el modelo
	 */
	
	set version(valor)
	{		
		$('#idFormularioInput').val(valor.id);
		$('#descripcionCortaFormularioInput').val(valor.descripcionCorta);
		$('#descripcionLargaFormularioInput').val(valor.descripcionLarga);
		$('#nombrePilaFormularioInput').val(valor.nombrePila);
		$('#fechaFormularioInput').val(valor.fecha);
		$('#horaFormularioInput').val(valor.hora);
		
		
	}
	
	get version()
	{
		 var version = 
		 {				    
			 id:$('#idFormularioInput').val(),
			 descripcionCorta:$('#descripcionCortaFormularioInput').val(),
			 descripcionLarga:$('#descripcionLargaFormularioInput').val(),
			 nombrePila:$('#nombrePilaFormularioInput').val(),
			 fecha:$('#fechaFormularioInput').val(),
			 hora:$('#horaFormularioInput').val()
		 };
		 return version;
	 }
	 /*
	  * Propiedades especiales o calculas
	  */
	
	
   
	 
	
	mostrarMensaje(titulo,mensaje)
	{
		alert(mensaje);	
	}
	
	mostrarFormulario()
	{
		$('#principalDiv').hide();
		$('#formularioDiv').show();
	}
	
	mostrarCriterios()
	{
		$('#principalDiv').hide();
		$('#criteriosDiv').show();
		
	}
	
	ocultar()
	{
		$('#principalDiv').show();
		$('#criteriosDiv').hide();
	}
	
	
	
	salirFormulario()
	{
		$('#principalDiv').show();	
	    $('#criteriosDiv').hide();
		$('#formularioDiv').hide();
	}
	
	
	
	
	
	
	/*
	for (var a = 0; i < 9; a++) {
		   n += i;
		   mifuncion(n);
		}
		*/
	
	/*
	 *Validación de los datos obligatorios del formulario 
	 */
	
	campoObligatorioVacio()
	{
		if($('#descripcionCortaFormularioInput').val()=='')					
			return $('#descripcionCortaFormularioInput');
		
		if($('#descripcionLargaFormularioInput').val()=='')					
			return $('#descripcionLargaFormularioInput');
		
		if($('#nombrePilaFormularioInput').val()=='')					
			return $('#nombrePilaFormularioInput');
		
		if($('#fechaFormularioInput').val()=='')					
			return $('#fechaFormularioInput');
		
		if($('#horaFormularioInput').val()=='')					
			return $('#horaFormularioInput');
		
		
		return null;
	}	
	
	/*
	 * Limpiar formulario
	 */
	limpiarFormulario()
	{
		$('#idFormularioInput').val("");
		$('#descripcionCortaFormularioInput').val("");
		$('#descripcionLargaFormularioInput').val("");
		$('#nombrePilaFormularioInput').val("");
		$('#fechaFormularioInput').val("");
		$('#horaFormularioInput').val("");
	
	}
	
	

	/*alert("hola")
	var Sel =this.Grid3._selectedItem;
	
    this._arraySalida.push( {BTVERSIONID:"1",BTCAMPOID:"campoID",BTCRITERIOPRESENTACION:"",BTCRITERIOORDEN:"", titulo:""+Sel.tituloCampo,REPTSDSC:""+this.gridTipoDocumentos._selectedItem.REPTSDSC});
    this.Grid2._dataProvider=this._arraySalida;
 	this.Grid2.render();	   

*/
	
	
	renderSwitch(renglon, campoBase)
	{				
	   // this.a=0;
		//a;
		var contenido = "";
		contenido += "<center>NO<label class='switch'>";
		contenido += "<input id='"+vista.a+"'  type='checkbox'>A"; 
		contenido += "<span class='slider round''></span>";
		contenido += "</label>SI</center>";
		vista.a++;


//		document.getElementById("a").checked = true;
		
		
		
		/*
		function check() {
		    document.getElementById("a").checked = true;
		}

		function uncheck() {
		    document.getElementById("a").checked = false;
		}
		
		
		*/

	    return contenido;
	}	
    
	
	agregarSalida (evento) 
	{ 		
		
	
		
		alert("salida")
		
		this.a=0;
		var Sel = this.grid3._selectedItem;
		
		this._arrayCampo=[];
		this._arrayCampo=this.grid2._dataProvider;
		var o = this.grid2._dataProvider.length+1;
		this._arrayCampo.push({titulo:Sel.tituloCampo,tablaId:Sel.tablaId,presentacion:"",orden:o,campoId:Sel.campoId}); 

		
	    this.grid2._dataProvider=this._arrayCampo
	    
	    
	    
	    
		this.grid2.render();	    
	    
	    
        //para el swithc
	    for(var b = 0; b < this.grid2._dataProvider.length; b++)
		{		
			if(this.grid2._dataProvider[b].presentacion ===  "1")
			{		
				document.getElementById(b).checked = true;
				this.grid2._dataProvider[b].presentacion="1"
			}
			else	
			{
				document.getElementById(b).checked = false; 
				this.grid2._dataProvider[b].presentacion="0"
			}			
		}
	    
	    
	    
	}


	
	drop(ev) 
	{	    
		var data = ev.dataTransfer.getData("text");
		//ev.target.appendChild(document.getElementById(data));
	    var TargetActual = ev.target.id;
		var TargetAnterior = ev.target.id//document.getElementById(this._viewport + "_gridSeleccionadosTbody").id;
		if(TargetActual == TargetAnterior)
		{
		    var nvoCampo=0;
		    /*if(data.indexOf("promptGenerico_gridFechaTable") > -1)
		    {
		    		
		    }   */
		    alert("drop")
		     ev.preventDefault();
		}
	}
	/*
	* Recuperamos informacion del Drag
	*/	
	recuperaItemDrag (evento) 
	{
		var a=evento;
		//a = evento.datos.hasOwnProperty ( "REPSID" );
		/*if(a==true)
	      {
	      	REPSID = evento.datos.REPSID;
	      }
	      else
	        REPSID =null;*/
	 } 
	allowDrop (ev)
	{
		ev.preventDefault();
	}
	allowDropE (ev)
    {  
    	ev.preventDefault();
	}
    dropE (ev) 
    {	
    	//eliminaCrite();
    	//ev.preventDefault();
    	alert("elimino")
	}
    

}
var vista = new VersionesVista(this);

