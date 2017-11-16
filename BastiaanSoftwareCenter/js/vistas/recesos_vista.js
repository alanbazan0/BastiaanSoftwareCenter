class RecesosVista
{		
	constructor(ventana)
	{	
		this.ventana = ventana;
		this.presentador = new RecesosPresentador(this);
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
			{longitud:200, 	titulo:"Descripción",   alias:"rDescripcion", alineacion:"I" }, 
			{longitud:200, 	titulo:"Nombre Corto",   alias:"rCorto", alineacion:"I" }, 
			{longitud:200, 	titulo:"Nombre Largo",   alias:"rLargo", alineacion:"I" },
			{longitud:200, 	titulo:"Maximo de Tiempo",   alias:"rTiempo", alineacion:"I" }, 
			{longitud:200, 	titulo:"Maximo de Recesos",   alias:"rRecesos", alineacion:"I" },
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
			id:$('#idRecesoCriterioInput').val()
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
		$('#rDescripcionFormularioInput').val(valor.rDescripcion);
		$('#rCortoFormularioInput').val(valor.rCorto);
		$('#rLargoFormularioInput').val(valor.rLargo);
		$('#rTiempoFormularioInput').val(valor.rTiempo);
		$('#rRecesosFormularioInput').val(valor.rRecesos);
	}
	
	get receso()
	{
		 var receso = 
		 {				    
			 id:$('#idFormularioInput').val(),
			 rDescripcion:$('#rDescripcionFormularioInput').val(),
			 rCorto:$('#rCortoFormularioInput').val(),
			 rLargo:$('#rLargoFormularioInput').val(),
			 rTiempo:$('#rTiempoFormularioInput').val(),
			 rRecesos:$('#rRecesosFormularioInput').val()
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
		if($('#rDescripcionFormularioInput').val()=='')					
			return $('#rDescripcionFormularioInput');

		return null;
	}	
	
	/*
	 * Limpiar formulario
	 * 
	 *  */
	
	limpiarFormulario()
	{
		$('#idFormularioInput').val("");
		$('#rDescripcionFormularioInput').val("");
		$('#rCortoFormularioInput').val("");
		$('#rLargoFormularioInput').val("");
		$('#rTiempoFormularioInput').val("");
		$('#rRecesosFormularioInput').val("");
	}
	
}
var vista = new RecesosVista(this);

