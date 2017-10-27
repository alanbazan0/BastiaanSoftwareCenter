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
		this.presentador.consultar();
	}
	
	crearColumnasGrid()
	{
		this.grid._columnas = [
			{longitud:100, 	titulo:"Id",   	alias:"id", alineacion:"I" }, 
			{longitud:200, 	titulo:"Primer nombre",   alias:"nombre", alineacion:"I" }, 
			{longitud:200, 	titulo:"Segundo nombre",   alias:"segundoNombre", alineacion:"I" }, 
			{longitud:200, 	titulo:"Apellido paterno",   alias:"apellidoPaterno", alineacion:"I" },	
			{longitud:200, 	titulo:"Apellido materno",   alias:"apellidoMaterno", alineacion:"I" },	
			{longitud:100, 	titulo:"RFC",   alias:"rfc", alineacion:"I" },	
			{longitud:100, 	titulo:"NSS",   alias:"nss", alineacion:"I" },	
			{longitud:150, 	titulo:"CURP",   alias:"curp", alineacion:"I" },	
			{longitud:200, 	titulo:"Correo electronico",   alias:"correoElectronico", alineacion:"I" },	
			{longitud:100, 	titulo:"Código postal",   alias:"codigoPostal", alineacion:"I" }, 
			{longitud:100, 	titulo:"Número exterior",   alias:"numeroExterior", alineacion:"I" },	
			{longitud:100, 	titulo:"Número interior",   alias:"numeroInterior", alineacion:"I" },	
			{longitud:200, 	titulo:"Calle",   alias:"calle", alineacion:"I" },	
			{longitud:200, 	titulo:"Colonia",   alias:"colonia", alineacion:"I" },	
			{longitud:200, 	titulo:"Estado",   alias:"estado", alineacion:"I" },	
			{longitud:200, 	titulo:"País",   alias:"pais", alineacion:"I" },	
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
	
	/*
	 * Eventos en botones y grid
	*/
	
	btnAlta_onClick()
	{
		
	}
	
	btnBaja_onClick()
	{ 
		 var answer = confirm("¿Deseas eliminar este cliente?")
		    if (answer){
		    	$('#idClienteInput').val(this.grid._selectedItem.id)
		    	this.presentador.eliminar();
		    }	
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
	
	btnConsulta_onClick()
	{
		this.presentador.consultar();
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
	
	btnSalir_onClick()
	{		
		$('#altaCambioDiv').hide();
		$('#principal').show();
		this.limpiar();
	}
	
	grid_eventGridRowDoubleClick()
	{
		alert(" ");
	}
	
	/*
	 * Valores de los criterios de selección
	 */
	
	get criteriosSeleccion()
	{
		 var criteriosSeleccion = 
		 {				    
			nombreCompleto:$('#nombreCompletoCriterioInput').val(),
			rfc:$('#rfcCriterioInput').val(),
			curp:$('#curpCriterioInput').val()
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
	
	set cliente(valor)
	{		
		$('#idFormularioInput').val(valor.nombre);
		$('#primerNombreFormularioInput').val(valor.primerNombre);
		$('#segundoNombreFormularioInput').val(valor.segundoNombre);
		$('#apellidoPaternoFormularioInput').val(valor.apellidoPaterno);
		$('#apellidoMaternoFormularioInput').val(valor.apellidoMaterno);
		$('#rfcFormularioInput').val(valor.rfc);
		$('#nssFormularioInput').val(valor.nss);
		$('#curpFormularioInput').val(valor.curp);
		$('#codigoPostalFormularioInput').val(valor.codigoPostal);
		$('#numeroExteriorFormularioInput').val(valor.numeroExterior);
		$('#numeroInteriorFormularioInput').val(valor.numeroInterior);
		$('#calleFormularioInput').val(valor.calle);
		$('#coloniaFormularioInput').val(valor.colonia);
		$('#estadoFormularioInput').val(valor.estado);
		$('#paisFormularioInput').val(valor.pais);
		$('#direccionFormularioInput').val(valor.direccion);
		$('#correoElectronicoFormularioInput').val(valor.correoElectronico);
	}
	
	 get cliente()
	 {
		 var cliente = 
		 {				    
			 id:$('#idFormularioInput').val(),
			 primerNombre:$('#primerNombreFormularioInput').val(),
			 segundoNombre:$('#segundoNombreFormularioInput').val(),
			 apellidoPaterno:$('#apellidoPaternoFormularioInput').val(),
			 apellidoMaterno:$('#apellidoMaternoFormularioInput').val(),
			 nombreCompleto:this.nombreCompletoFormulario,
			 rfc:$('#rfcFormularioInput').val(),
			 nss:$('#nssFormularioInput').val(),
			 curp:$('#curpFormularioInput').val(),
			 codigoPostal:$('#codigoPostalFormularioInput').val(),
			 numeroExterior:$('#numeroExteriorFormularioInput').val(),
			 numeroInterior:$('#numeroInteriorFormularioInput').val(),
			 calle:$('#calleFormularioInput').val(),
			 colonia:$('#coloniaFormularioInput').val(),
			 estado:$('#estadoFormularioInput').val(),
			 pais:$('#paisFormularioInput').val(),
			 direccion:$('#idInput').val(),			 
			 correoElectronico:$('#correoElectronicoFormularioInput').val()
		 };
		 return cliente;
	 }
	 
	 /*
	  * Propiedades especiales o calculas
	  */
	 
	 
	 get nombreCompletoFormulario()
	 {
		return $('#primerNombreFormularioInput').val() + " " + 
			   $('#segundoNombreFormularioInput').val() +" " + 
			   $('#apellidoPaternoFormularioInput').val() + " " +
			   $('#apellidoMaternoFormularioInput').val();
	 }
	
	 
	
	
	mostrarMensaje(titulo,mensaje)
	{
		alert(mensaje);
	
	}
	
	mostrarFormulario()
	{
		$('#principal').hide()	
		$('#formularioDiv').show();
	}
	
	salirFormulario()
	{
		$('#principal').show()	
		$('#formularioDiv').hide();
	}
	
	/*
	 *Validación de los datos obligatorios del formulario 
	 */
	/*
	validar()
	{
		if($('#primerNombreFormularioInput').val()==""){
			alert("Tiene que llenar el campo primer nombre");
			$('#primerNombreInput').focus();
			return 0;
		}
		
		if($('#apellidoPaternoFormularioInput').val()==""){
			alert("Tiene que llenar el campo primer apellido");
			$('#primerApellidoInput').focus();
			return 0;
		}
		
		if($('#rfcFormularioInput').val()==""){
			alert("Tiene que llenar el campo RFC");
			$('#rfcInput').focus();
			return 0;
		}
		
				
		
		if($('#curpFormularioInput').val()==""){
			alert("Tiene que llenar el campo CURP");
			$('#curpFormularioInput').focus();
			return 0;
		}
		
		if($('#calleFormularioInput').val()==""){
			alert("Tiene que llenar el campo Calle");
			$('#calleFormularioInput').focus();
			return 0;
		}
		
		if($('#codigoPostalFormularioInput').val()==""){
			alert("Tiene que llenar el campo Código postal");
			$('#codigoPostalFormularioInput').focus();
			return 0;
		}
		
		if($('#coloniaFormularioInput').val()==""){
			alert("Tiene que llenar el campo Colonia");
			$('#coloniaFormularioInput').focus();
			return 0;
		}
		
		if($('#numeroExteriorFormularioInput').val()==""){
			alert("Tiene que llenar el campo Número exterior");
			$('#numeroExteriorFormularioInput').focus();
			return 0;
		}
		
		if($('#estadoFormularioInput').val()==""){
			alert("Tiene que llenar el campo Estado");
			$('#estadoFormularioInput').focus();
			return 0;
		}
		
		if($('#paisFormularioInput').val()==""){
			alert("Tiene que llenar el campo País");
			$('#paisFormularioInput').focus();
			return 0;
		}
		
	}	
	*/
	/*
	 * Limpiar formulario
	 */
	limpiar()
	{
			$('#idFormularioInput').val("");
			$('#primerNombreFormularioInput').val("");
			$('#segundoNombreFormularioInput').val("");
			$('#apellidoPaternoFormularioInput').val("");
			$('#apellidoMaternoFormularioInput').val("");
			$('#rfcFormularioInput').val("");
			$('#nssFormularioInput').val("");
			$('#curpFormularioInput').val("");
			$('#codigoPostalFormularioInput').val("");
			$('#numeroExteriorFormularioInput').val("");
			$('#numeroInteriorFormularioInput').val("");
			$('#calleFormularioInput').val("");
			$('#coloniaFormularioInput').val("");
			$('#estadoFormularioInput').val("");
			$('#paisFormularioInput').val("");
			$('#direccionFormularioInput').val("");
			$('#correoInput').val("");
	}
	

	
}
var vista = new ClientesVista();

