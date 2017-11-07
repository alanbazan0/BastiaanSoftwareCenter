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
			{longitud:200, 	titulo:"Descripciòn Corta",   alias:"descripcionCorta", alineacion:"I" },
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
		this.grid._presentacionGranTotal = "SI";
		this.grid.render();		
	}
	cargargridCriterio()
	{		 
		 this.grid2._columnas = [
				{longitud:100, 	titulo:"titulo",   	alias:"titulo", alineacion:"I" },
				{longitud:200, 	titulo:"presentar",   alias:"presentacion", alineacion:"I" },
				{longitud:200, 	titulo:"orden",   alias:"orden", alineacion:"I" },
				{longitud:200, 	titulo:"presentacion",   alias:"presentacin", alineacion:"I" }
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
			this.grid2._regExtra=20;
			this.grid2._presentacionGranTotal = "SI";
			this.grid2.render();
			// este el grid 3
			this.grid3._columnas = [
				{longitud:200, 	titulo:"Titulo campo",   	alias:"tituloCampo", alineacion:"I" }
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
			this.grid3._presentacionGranTotal = "SI";
			this.grid3.render();	
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
		}	
		
		
		btnConsulta_onClick()
		{
			this.presentador.consultar();
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
			if(this.modo=='ALTA')
				this.presentador.insertar();
			else
				this.presentador.actualizar();
		 }		
		 else
		 {
			this.mostrarMensaje('Error','El campo "' + campoObligatorioVacio.attr("descripcion") + '" es obligatorio.');
		 }	
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
	
	get criteriosSeleccion()
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
	
	/*
	 * Asignar registros al grid
	 */
	
	set datos(valor)
	{
		this.grid._dataProvider = valor;	
		this.grid.render();
	}
	
	
	set datosCriterios(valor)
	{
		this.grid2._dataProvider = valor;	
		this.grid2.render();
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
	
	salirFormulario()
	{
		$('#principalDiv').show();	
	    $('#criteriosDiv').hide();
		$('#formularioDiv').hide();
	}
	
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

}
var vista = new VersionesVista(this);

