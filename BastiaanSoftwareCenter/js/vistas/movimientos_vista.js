class MovimientosVista
{		
	constructor(ventana)
	{	
		this.ventana = ventana;
		this.presentador = new MovimientosPresentador(this);
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
			{longitud:100, 	titulo:"Id",   	alias:"id", alineacion:"I" }, 
			{longitud:200, 	titulo:"Id agente",   alias:"agenteId", alineacion:"I" }, 
			{longitud:200, 	titulo:"Id receso",   alias:"recesoId", alineacion:"I" }, 
			{longitud:200, 	titulo:"Fecha Inicial",   alias:"fInicial", alineacion:"I" },
			{longitud:200, 	titulo:"Fecha Final",   alias:"fFinal", alineacion:"I" }, 
			{longitud:200, 	titulo:"Fecha Personal",   alias:"fPersonal", alineacion:"I" },
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
	//	this.grid._presentacionGranTotal = "SI";
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
			id:$('#agenteIdCriterioInput').val()
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
	
	set receso(valor)
	{		
		$('#idFormularioInput').val(valor.id);
		$('#agenteIdFormularioInput').val(valor.agenteId);
		$('#recesoIdFormularioInput').val(valor.recesoId);
		$('#fInicialFormularioInput').val(valor.fInicial);
		$('#fFinalFormularioInput').val(valor.fFinal);
		$('#fPersonalFormularioInput').val(valor.fPersonal);
	}
	
	get receso()
	{
		 var receso = 
		 {				    
			 id:$('#idFormularioInput').val(),
			 agenteId:$('#agenteIdFormularioInput').val(),
			 recesoId:$('#recesoIdFormularioInput').val(),
			 fInicial:$('#fInicialFormularioInput').val(),
			 fFinal:$('#fFinalFormularioInput').val(),
			 fPersonal:$('#fPersonalFormularioInput').val()
		 };
		 return receso;
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
		if($('#agenteIdFormularioInput').val()=='')					
			return $('#agenteIdFormularioInput');

		return null;
	}	
	
	/*
	 * Limpiar formulario
	 * 
	 *  */
	
	limpiarFormulario()
	{
		$('#idFormularioInput').val("");
		$('#agenteIdFormularioInput').val("");
		$('#recesoIdFormularioInput').val("");
		$('#fInicialFormularioInput').val("");
		$('#fFinalFormularioInput').val("");
		$('#fPersonalFormularioInput').val("");
	}
	
}
var vista = new MovimientosVista(this);

