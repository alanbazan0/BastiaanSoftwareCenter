class ClientesTelefonosVista
{		
	constructor(ventana)
	{	
		this.ventana = ventana;
		this.presentador = new ClientesTelefonosPresentador(this);
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
			
			{longitud:100, 	titulo:"Número Cliente",   	alias:"id", alineacion:"I" }, 
			//{longitud:200, 	titulo:"Consecutivo",   alias:"consecutivo", alineacion:"I" },
			{longitud:200, 	titulo:"Teléfono Cliente",   alias:"telefonoCliente", alineacion:"I" },
			{longitud:200, 	titulo:"Nir",   alias:"nir", alineacion:"I" },
			{longitud:100, 	titulo:"Serie",   	alias:"serie", alineacion:"I" }, 
			{longitud:200, 	titulo:"Numeración",   alias:"numeracion", alineacion:"I" },
			{longitud:200, 	titulo:"Campaña",   alias:"compania", alineacion:"I" },
			{longitud:200, 	titulo:"Tipo teléfono",   alias:"tipoTelefono", alineacion:"I" },
			
			
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
	
	set Clientetelefono(valor)
	{		
		$('#idFormularioInput').val(valor.id);
		//$('#consecutivoFormularioInput').val(valor.consecutivo);
		$('#telefonoClienteFormularioInput').val(valor.telefonoCliente);
		$('#nirFormularioInput').val(valor.nir);
		$('#serieFormularioInput').val(valor.serie);
		$('#numeracionFormularioInput').val(valor.numeracion);
		$('#companiaFormularioInput').val(valor.compania);
		$('#tipoTelefonoFormularioInput').val(valor.tipoTelefono);
		

	}
	
	get Clientetelefono()
	{
		 var Clientetelefono = 
		 {	
		    id:$('#idFormularoInput').val(),
			//consecutivo:$('#consecutivoFormularioInput').val(),
			telefonoCliente:$('#telefonoClienteFormularioInput').val(),
			nir:$('#nirFormularioInput').val(v),
			serie:$('#serieFormularioInput').val(),
			numeracion:$('#numeracionFormularioInput').val(),
			compania:$('#companiaFormularioInput').val(),
			tipoTelefono:$('#tipoTelefonoFormularioInput').val()
			 
			 
		 };
		 return Clientetelefono;
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
		if($('#serieFormularioInput').val()=='')					
			return $('#serieFormularioInput');
		
		return null;
	}	
	
	/*
	 * Limpiar formulario
	 */
	limpiarFormulario()
	{
		$('#idFormularioInput').val("");		
		//$('#consecutivoFormularioInput').val("");
		$('#telefonoClienteFormularioInput').val("");
		$('#nirFormularioInput').val("");
		$('#serieFormularioInput').val("");
		$('#numeracionFormularioInput').val("");
		$('#companiaFormularioInput').val("");
		$('#tipoTelefonoFormularioInput').val("");
	}
	

	
}
var vista = new ClientesTelefonosVista(this);

