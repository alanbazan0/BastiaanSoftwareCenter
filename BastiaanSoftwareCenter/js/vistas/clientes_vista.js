class ClientesVista
{		
	constructor()
	{
	
		this.presentador = new ClientesPresentador(this);
		this.manejadorEventos = new ManejadorEventos();
		this.grid = new GridReg("grid");	
	}
	onLoad()
	{			
		this.crearColumnasGrid();
	}
	
	crearColumnasGrid()
	{
		//var div = $('#grid');
		//this.html.grid = new GridReg("grid");	
		this.grid._columnas = [
			{longitud:100, 	titulo:"Id",   	alias:"id", alineacion:"I" }, 
			{longitud:200, 	titulo:"Primer nombre",   alias:"nombre", alineacion:"I" }, 
			{longitud:200, 	titulo:"Segundo nombre",   alias:"nombreSegundo", alineacion:"I" }, 
			{longitud:200, 	titulo:"Apellido paterno",   alias:"apellidoPaterno", alineacion:"I" },	
			{longitud:200, 	titulo:"Materno materno",   alias:"apellidoMaterno", alineacion:"I" },	
			{longitud:100, 	titulo:"Rfc",   alias:"rfc", alineacion:"I" },	
			{longitud:100, 	titulo:"Nss",   alias:"nss", alineacion:"I" },	
			{longitud:150, 	titulo:"Curp",   alias:"curp", alineacion:"I" },	
			{longitud:200, 	titulo:"Correo electronico",   alias:"correoElectronico", alineacion:"I" },	
			{longitud:100, 	titulo:"Codigo postal",   alias:"cpId", alineacion:"I" }, 
			{longitud:100, 	titulo:"Numero exterior",   alias:"numExt", alineacion:"I" },	
			{longitud:100, 	titulo:"Numero interior",   alias:"numInt", alineacion:"I" },	
			{longitud:200, 	titulo:"Calle",   alias:"calle", alineacion:"I" },	
			{longitud:200, 	titulo:"Colonia",   alias:"colonia", alineacion:"I" },	
			{longitud:200, 	titulo:"Estado",   alias:"estado", alineacion:"I" },	
			{longitud:200, 	titulo:"Pais",   alias:"pais", alineacion:"I" },	
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
		 var answer = confirm("¿Deseas eliminar este cliente?")
		    if (answer){
		    	$('#idClienteInput').val(this.grid._selectedItem.id)
		    	this.presentador.eliminar();
		    }	
	}
	
	get nombreCompleto()
	{
		return $('#nombreInput').val();
	}
	
	get rfc()
	{		
		return $('#rfcInput').val();
	}
	
	get curp()
	{
		return $('#curpInput').val();
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
			$('#idClienteInput').val(this.grid._selectedItem.id)
			this.presentador.consultarPorId();
		}else{
			alert("Selecciona un cliente para actualizar");
		}		
	}
	
	btnGuardar_onClick()
	{		
		if(this.validar()!= 0){
			if( $('#idClienteInput').val()==""){
				this.presentador.insertar();
			}else{
				this.presentador.actualizar();
			}
		}
		
	}
	
	//campos del formulario
	
	get idCliente()
	{
		return $('#idClienteInput').val();
	}
	
	get primerNombre()
	{
		return $('#primerNombreInput').val();
	}
	
	get segundoNombre()
	{
		return $('#segundoNombreInput').val();
	}
	
	get primerApellido()
	{
		return $('#primerApellidoInput').val();
	}
	
	get segundoApellido()
	{
		return $('#segundoApellidoInput').val();
	}
	
	get rfcDetalle()
	{
		return $('#rfcDetalleInput').val();
	}
	
	get nssDetalle()
	{
		return $('#nssDetalleInput').val();
	}
	
	get curpDetalle()
	{
		return $('#curpDetalleInput').val();
	}
	
	get codigoPostal()
	{
		return $('#codigoPostalInput').val();
	}
	
	get numeroExterior()
	{
		return $('#numeroExteriorInput').val();
	}
	
	get numeroInterior()
	{
		return $('#numeroInteriorInput').val();
	}
	
	
	get calle()
	{
		return $('#calleInput').val();
	}
	
	
	get colonia()
	{
		return $('#coloniaInput').val();
	}
	
	
	get estado()
	{
		return $('#estadoInput').val();
	}
	
	get pais()
	{
		return $('#paisInput').val();
	}
	
	get correo()
	{
		return $('#correoInput').val();
	}
	
	set resultado(valor)
	{
		alert(valor);
		this.limpiar();	
	}
	
	validar()
	{
		if($('#primerNombreInput').val()==""){
			alert("Tiene que llenar el campo primer nombre");
			$('#primerNombreInput').focus();
			return 0;
		}
		
		if($('#primerApellidoInput').val()==""){
			alert("Tiene que llenar el campo primer apellido");
			$('#primerApellidoInput').focus();
			return 0;
		}
		
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
		
	}
	
	btnSalir_onClick(){		
		$('#altaCambioDiv').hide();
		$('#principal').show();
		this.limpiar();
	}
	
	limpiar(){
			$('#idClienteInput').val("");
			$('#primerNombreInput').val("");
			$('#segundoNombreInput').val("");
			$('#primerApellidoInput').val("");
			$('#segundoApellidoInput').val("");
			$('#rfcDetalleInput').val("");
			$('#nssDetalleInput').val("");
			$('#curpDetalleInput').val("");
			$('#codigoPostalInput').val("");
			$('#numeroExteriorInput').val("");
			$('#numeroInteriorInput').val("");
			$('#calleInput').val("");
			$('#coloniaInput').val("");
			$('#estadoInput').val("");
			$('#paisInput').val("");
			$('#correoInput').val("");
	}
	
	set resultadoActualizar(valor)
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
	
	}
	
}
var vista = new ClientesVista();

