class PortablesVista
{		
	constructor(ventana)
	{	
		this.ventana = ventana;
		this.presentador = new PortablesPresentador(this);
		this.manejadorEventos = new ManejadorEventos();
		this.grid = new GridReg("grid");	
	}
	
	onLoad()
	{			
		this.crearColumnasGrid();
		this.presentador.consultar();
	}
	
	crearColumnasGrid()
	{
		this.grid._columnas = [
			{longitud:100, 	titulo:"Id de municipio",   	alias:"idMunicipio", alineacion:"I" }, 
			{longitud:100, 	titulo:"Id consecutivo",   	alias:"idConsecutivo", alineacion:"I" },
			{longitud:200, 	titulo:"Numero de portabilidad",   alias:"numeroPortabilidad", alineacion:"I" }, 
			{longitud:200, 	titulo:"Descripcion de la portabilidad",   alias:"descripcionPortabilidad", alineacion:"I" },
			{longitud:100, 	titulo:"Ciudad de la portabilidad",   	alias:"ciudadPortabilidad", alineacion:"I" }, 
			{longitud:200, 	titulo:"Municipio de la portabilidad",   alias:"municipioPortabilidad", alineacion:"I" }, 
			{longitud:200, 	titulo:"Estado de la portabilidad",   alias:"estadoPortabilidad", alineacion:"I" }, 	
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
		this.grid._presentacionGranTotal = "SI";
		this.grid.render();		
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
			idConsecutivo:this.grid._selectedItem.idConsecutivo	
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
			idMunicipio:$('#idMunicipioCriterioInput').val(),
			idConsecutivo:$('#idConsecutivoCriterioInput').val()
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
	
	/*
	 * Mapeo de datos del formulario con el modelo
	 */
	
	set portable(valor)
	{		
		$('#idMunicipioFormularioInput').val(valor.idMunicipio);
		$('#idConsecutivoFormularioInput').val(valor.idConsecutivo);
		$('#numeroPortabilidadFormularioInput').val(valor.numeroPortabilidad);
		$('#descripcionPortabilidadFormularioInput').val(valor.descripcionPortabilidad);
		$('#ciudadPortabilidadFormularioInput').val(valor.ciudadPortabilidad);
		$('#municipioPortabilidadFormularioInput').val(valor.municipioPortabilidad);
		$('#estadoPortabilidadFormularioInput').val(valor.estadoPortabilidad);
		
	}
	
	get portable()
	{
		 var portable = 
		 {				    
				 idMunicipio:$('#idMunicipioFormularioInput').val(),
				 idConsecutivo:$('#idConsecutivoFormularioInput').val(),
				 numeroPortabilidad:$('#numeroPortabilidadFormularioInput').val(),
				 descripcionPortabilidad:$('#descripcionPortabilidadFormularioInput').val(),
				 ciudadPortabilidad:$('#ciudadPortabilidadFormularioInput').val(),
				 municipioPortabilidad:$('#municipioPortabilidadFormularioInput').val(),
				 estadoPortabilidad:$('#estadoPortabilidadFormularioInput').val()
		 };
		 return portable;
	 }
	 
	mostrarMensaje(titulo,mensaje)
	{
		alert(mensaje);	
	}
	
	mostrarFormulario()
	{
		$('#principalDiv').hide()	
		$('#formularioDiv').show();
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
		if($('#idMunicipioFormularioInput').val()=='')					
			return $('#idMunicipioFormularioInput');
		
		if($('#descripcionPortabilidadFormularioInput').val()=='')					
			return $('#descripcionPortabilidadFormularioInput');
		
		return null;
	}	
	
	/*
	 * Limpiar formulario
	 */
	limpiarFormulario()
	{
		$('#idMunicipioFormularioInput').val("");
		$('#idConsecutivoFormularioInput').val("");
		$('#numeroPortabilidadFormularioInput').val("");
		$('#descripcionPortabilidadFormularioInput').val("");
		$('#ciudadPortabilidadFormularioInput').val("");
		$('#municipioPortabilidadFormularioInput').val("");
		$('#estadoPortabilidadFormularioInput').val("");
	}
	

	
}
var vista = new PortablesVista(this);


	