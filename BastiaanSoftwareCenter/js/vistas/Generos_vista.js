 class 	GenerosVista
{		
	 constructor(ventana)
		{	
			this.ventana = ventana;
			this.presentador = new GenerosPresentador(this);
			this.manejadorEventos = new ManejadorEventos();
			this.grid = new GridReg("grid");	
		}
	onLoad()
	{			
		this.crearColumnasgrid();
		this.presentador.consultar();
	}
	
	crearColumnasgrid()
	{
		this.grid._columnas = [
			{longitud:200, 	titulo:"Id",   	alias:"id", alineacion:"I" }, 
			{longitud:300, 	titulo:"Genero Corto",   alias:"gCorto", alineacion:"I" }, 
			{longitud:400, 	titulo:"Genero Largo",   alias:"gLargo", alineacion:"I" }, 
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
		    	this.presentador.actualizar();
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
	    	//TODO: Cerrar ventana aqui
	    	}
	}
	

	btnSalirFormulario_onClick()
	{		
		this.salirFormulario();
		this.presentador.actualizar();
	}	
	
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
			id:$('#idGeneroCriterioInput').val(),
			gCorto:$('#gCortoCriterioInput').val(),
			gLargo:$('#gLargoCriterioInput').val()
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
	
	set genero(valor)
	{		
		$('#idFormularioInput').val(valor.id);
		$('#gCortoFormularioInput').val(valor.gCorto);
		$('#gLargoFormularioInput').val(valor.gLargo);
	}
	
	get genero()
	{
		 var genero = 
		 {				    
				 id:$('#idFormularioInput').val(),
				 gCorto:$('#gCortoFormularioInput').val(),
				 gLargo:$('#gLargoFormularioInput').val()
		 };
		 return genero;
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
	
	campoObligatorioVacio()
	{
		if($('#gCortoFormularioInput').val()=='')					
			return $('#gCortoFormularioInput');
		
		if($('#gLargoFormularioInput').val()=='')					
			return $('#gLargoFormularioInput');
		
		return null;
	}	
	
	/*
	 * Limpiar formulario
	 */
	limpiarFormulario()
	{
		$('#idFormularioInput').val("");
		$('#gCortoFormularioInput').val("");
		$('#gLargoFormularioInput').val("");
	}
	

}
var vista = new GenerosVista();
