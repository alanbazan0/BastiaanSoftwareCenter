class AresVista
{		
	constructor(ventana)
	{	
		this.ventana = ventana;
		this.presentador = new AresPresentador(this);
		this.manejadorEventos = new ManejadorEventos();
		this.grid = new GridReg("grid");	
	}
	
	onLoad()
	{			
		this.crearColumnasGrid();
		this.presentador.consultar();
		this.presentador.consultarTipoEstructura();
	}
	
	abirTab(evt, cityName) {
	    var i, tabcontent, tablinks;
	    tabcontent = document.getElementsByClassName("tabcontent");
	    for (i = 0; i < tabcontent.length; i++) {
	        tabcontent[i].style.display = "none";
	    }
	    tablinks = document.getElementsByClassName("tablinks");
	    for (i = 0; i < tablinks.length; i++) {
	        tablinks[i].className = tablinks[i].className.replace(" active", "");
	    }
	    document.getElementById(cityName).style.display = "block";
	    evt.currentTarget.className += " active";
	}
	
	crearColumnasGrid()
	{
		this.grid._columnas = [
			{longitud:100, 	titulo:"Nombre",   	alias:"id", alineacion:"I" }, 
			{longitud:200, 	titulo:"Descripcion",   alias:"nombreArea", alineacion:"I" }, 
			{longitud:200, 	titulo:"Tipo estructura",   alias:"descripcionArea", alineacion:"I" }, 	
		]
		
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
		this.grid.render();	
		
		
		this.cmbEstatus = new Combo("tipoEstructura");
		this.cmbEstatus.setViewport("tipoEstructura");
		this.cmbEstatus._dataField = "ID";
		this.cmbEstatus._labelField = "label";
		this.cmbEstatus.render();
	}
	
	/*
	 * Eventos en botones
	*/
	
	btnAlta_onClick(event)
	{
		this.modo = "ALTA";
		this.limpiarFormulario();	
		this.mostrarFormulario();	
		this.abirTab(event, 'Basico')
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
	
	btnConsulta_onClick()
	{
		this.presentador.consultar();
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
			idArea:$('#idAreaCriterioInput').val(),
			nombreArea:$('#nombreAreaCriterioInput').val()
		 }
		 return criteriosSeleccion;
	}		
	
	
	/*
	 * Asignar registros al grid
	 */
	
	set datos(valor)
	{
		this.grid._dataProvider = valor;	
		this.grid.render();
	}
	
	set tipoEstructura(valor)
	{
		//this.grid._dataProvider = valor;	
		//this.grid.render();
		if(this.modo=="ALTA")
		{
			this.cmbEstatus2._dataProvider = valor;
			this.cmbEstatus2.render();
		}
		else
		{
			this.cmbEstatus._dataProvider = valor;
			this.cmbEstatus.render();
		}
	}
	set listaAreas(valor)
	{
		//this.grid._dataProvider = valor;	
		//this.grid.render();
		this.gridListaAreas._dataProvider = valor;	
		this.gridListaAreas.render();
	}
	
	
	/*
	 * Mapeo de datos del formulario con el modelo
	 */
	
	set area(valor)
	{		
		$('#idFormularioInput').val(valor.id);
		$('#nombreAreaFormularioInput').val(valor.nombreArea);
		$('#descripcionAreaFormularioInput').val(valor.descripcionArea);
	}
	
	get area()
	{
		 var area = 
		 {				    
			 id:$('#idFormularioInput').val(),
			 nombreArea:$('#nombreAreaFormularioInput').val(),
			 descripcionArea:$('#descripcionAreaFormularioInput').val()
		 };
		 return area;
	 }
	 

	mostrarMensaje(titulo,mensaje)
	{
		alert(mensaje);	
	}
	
	mostrarFormulario()
	{
		$('#principalDiv').hide()	
		$('#formularioDiv').show();
		this.gridListaAreas = new GridReg("gridListaArea");	
		this.gridListaAreas._columnas = [
			{longitud:178, 	titulo:"Area",   	alias:"ID", alineacion:"D" }, 
			{longitud:250, 	titulo:"Nombre corto",   alias:"IDC", alineacion:"I" }, 
			{longitud:250, 	titulo:"Nombre largo",   alias:"label", alineacion:"I" }, 	
		]
		
		this.gridListaAreas._origen="vista";
		this.gridListaAreas.manejadorEventos=this.manejadorEventos;
		this.gridListaAreas._ajustarAltura = true;
		this.gridListaAreas._colorRenglon1 = "#FFFFFF";	
		this.gridListaAreas._colorRenglon2 = "#f8f2de";
		this.gridListaAreas._colorEncabezado1 = "#FF6600";
		this.gridListaAreas._colorEncabezado2 = "#FF6600";
		this.gridListaAreas._colorLetraEncabezado = "#ffffff";
		this.gridListaAreas._colorLetraCuerpo = "#000000";
		this.gridListaAreas._regExtra=20;
		this.gridListaAreas.render();	
		
		this.cmbEstatus2 = new Combo("tipoEstructura2");
		this.cmbEstatus2.setViewport("tipoEstructura2");
		this.cmbEstatus2._dataField = "ID";
		this.cmbEstatus2._labelField = "label";
		this.cmbEstatus2.render();
		
		this.presentador.consultarListaAreas();
		this.presentador.consultarTipoEstructura();
	}
	
	salirFormulario()
	{
		$('#principalDiv').show()	
		$('#formularioDiv').hide();
	}
	
	/*
	 *Validación de los datos obligatorios del formulario 
	 */
	
	campoObligatorioVacio()
	{
		if($('#nombreAreaFormularioInput').val()=='')					
			return $('#nombreAreaFormularioInput');
		
		if($('#descripcionAreaFormularioInput').val()=='')					
			return $('#descripcionAreaFormularioInput');
		
		return null;
	}	
	
	/*
	 * Limpiar formulario
	 */
	limpiarFormulario()
	{
		$('#idFormularioInput').val("");
		$('#nombreAreaFormularioInput').val("");
		$('#descripcionAreaFormularioInput').val("");
	}
	verDatosAsis()
	{
		var datosPrompt = {};
		datosPrompt.listaArchivos = "";
		datosPrompt.rutaArchivo = "";
		this._promptArchivos = new PromptArchivosIEC("_promptArchivos")
		this._promptArchivos.setViewport("Prompt");
		this._promptArchivos.load(datosPrompt);				
		this._promptArchivos.render();
	}
	

	
}
var vista = new AresVista(this);

