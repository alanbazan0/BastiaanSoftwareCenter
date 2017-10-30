class  GenerosVista
{		
	constructor()
	{
	
		this.presentador = new GenerosPresentador(this);
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
		//var div = $('#grid');
		//this.html.grid = new GridReg("grid");	
		this.grid._columnas = [
			{longitud:200, 	titulo:"Genero corto",   alias:"nombre", alineacion:"I" }, 
			{longitud:200, 	titulo:"Genero largo",   alias:"nombreSegundo", alineacion:"I" }, 
			{longitud:200, 	titulo:"Apellido paterno",   alias:"apellidoPaterno", alineacion:"I" },	

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
		//this.grid.subscribirAEvento(this, "eventGridRowClick", this.recuperaDatosCliente);
		//this.grid.subscribirAEvento(this, "eventGridRowDoubleClick", this.grid_eventGridRowDoubleClick);
		this.grid.render();		
	}
	
	
	btnConsulta_onClick()
	{
		this.presentador.consultar();
	}
	
	btnBaja_onClick()
	{ 
		 var answer = confirm("¿Deseas eliminar este genero?")
		    if (answer){
		    	$('#nombreInput').val(this.grid._selectedItem.nombre)
		    	this.presentador.eliminar();
		    }	
	}
	
	get nombre()
	{
		return $('#nombreInput').val();
	}
	
	get nombreSegundo()
	{		
		return $('#nombreSegundoInput').val();
	}
	
	get apellidoPaterno()
	{
		return $('#apellidoPaternoInput').val();
	}

	
	set datos(valor)
	{
		this.grid._dataProvider = valor;	
		this.grid.render();
	}
	
	grid_eventGridRowDoubleClick()
	{
		alert(" ");
		//$('#principal').hide()	
		//$('#altaCambioDiv').show();
	}
	
	btnAlta_onClick()
	{
		$('#principal').hide()	
		$('#altaCambioDiv').show();
	}
	
	btnCambio_onClick()
	{
		if( this.grid._selectedItem!=null){
			$('#principal').hide()	
			$('#altaCambioDiv').show();
			$('#nombreInput').val(this.grid._selectedItem.nombre)
			
			
			this.presentador.consultarPorId();
		}else{
			alert("Selecciona un genero para actualizar");
		}		
	}
	
	btnGuardar_onClick()
	{		
		if(this.validar()!= 0){
			if( $('#nombreInput').val()==""){
				this.presentador.insertar();
			}else{
				this.presentador.actualizar();
			}
		}
		
	}
	
	set genero(valor)
	{
		//TODO: poner id de cliente aqui
		$('#nombreInput').val(valor.nombre);
		$('#nombreSegundoInput').val(valor.nombreSegundo);
		$('#apellidoPaternoInput').val(valor.apellidoPaterno);
	}
	
	 get genero()
	 {
		 var genero = 
		 {	
				 
			 nombre:this.nombre,
			 nombre:"",
			 nombreSegundo:"",
			 apellidoPaterno:""
		 };
		 return genero;
	 }
	
	//campos del formulario

	get nombre()
	{
		return $('#nombreInput').val();
	}
	
	get nombreSegundo()
	{
		return $('#nombreSegundoInput').val();
	}
	
	get apellidoPaterno()
	{
		return $('#apellidoPaternoInput').val();
	}
	
	mostrarMensaje(titulo,mensaje)
	{
		alert(mensaje);
	
	}
	
	salirDetalle()
	{
		$('#principal').show()	
		$('#altaCambioDiv').hide();
	}
	
	validar()
	{
		/*
		if($('#nombreInput').val()==""){
			alert("Tiene que llenar el campo nombre");
			$('#nombreInput').focus();
			return 0;
		}
		
		if($('#nombreSegundoInput').val()==""){
			alert("Tiene que llenar el campo segundo nombre");
			$('#nombreSegundoInput').focus();
			return 0;
		}
	*/
		/*
		if($('#rfcDetalleInput').val()==""){
			alert("Tiene que llenar el campo RFC");
			$('#rfcDetalleInput').focus();
			return 0;
		}
		
				
		if($('#rfcDetalleInput').val()==""){
			alert("Tiene que llenar el campo RFC");
			$('#rfcDetalleInput').focus();
			return 0;
		}
		
		if($('#curpDetalleInput').val()==""){
			alert("Tiene que llenar el campo CURP");
			$('#curpDetalleInput').focus();
			return 0;
		}
		
		if($('#calleInput').val()==""){
			alert("Tiene que llenar el campo Calle");
			$('#calleInput').focus();
			return 0;
		}
		
		if($('#codigoPostalInput').val()==""){
			alert("Tiene que llenar el campo Codigo postal");
			$('#codigoPostalInput').focus();
			return 0;
		}
		
		if($('#coloniaInput').val()==""){
			alert("Tiene que llenar el campo Colonia");
			$('#coloniaInput').focus();
			return 0;
		}
		
		if($('#numeroExteriorInput').val()==""){
			alert("Tiene que llenar el campo Numero exterior");
			$('#numeroExteriorInput').focus();
			return 0;
		}
		
		if($('#numeroExteriorInput').val()==""){
			alert("Tiene que llenar el campo Estado");
			$('#numeroExteriorInput').focus();
			return 0;
		}
		
		if($('#paisInput').val()==""){
			alert("Tiene que llenar el campo Pais");
			$('#paisInput').focus();
			return 0;
		}
		*/
	}
	
	btnSalir_onClick(){		
		$('#altaCambioDiv').hide();
		$('#principal').show();
		this.limpiar();
	}
	
	limpiar(){
			$('#nombreInput').val("");
			$('#nombreSegundoInput').val("");
			$('#apellidoPaternoInput').val("");

	}
	
	/*set resultadoActualizar(valor)
	{				
		$('#primerNombreInput').val(valor[0].nombre);
		$('#segundoNombreInput').val(valor[0].nombreSegundo);
		$('#primerApellidoInput').val(valor[0].apellidoPaterno);
		$('#segundoApellidoInput').val(valor[0].apellidoMaterno);
		$('#rfcDetalleInput').val(valor[0].rfc);
		$('#nssDetalleInput').val(valor[0].nss);
		$('#curpDetalleInput').val(valor[0].curp);
		$('#codigoPostalInput').val(valor[0].cpId);
		$('#numeroExteriorInput').val(valor[0].numExt);
		$('#numeroInteriorInput').val(valor[0].numInt);
		$('#calleInput').val(valor[0].calle);
		$('#coloniaInput').val(valor[0].colonia);
		$('#estadoInput').val(valor[0].estado);
		$('#paisInput').val(valor[0].pais);
		$('#correoInput').val(valor[0].correoElectronico);
	
	}*/
	
}
var vista = new GenerosVista();

