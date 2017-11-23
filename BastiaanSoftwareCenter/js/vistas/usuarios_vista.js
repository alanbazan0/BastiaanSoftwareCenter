class UsuariosVista
{		
	constructor(ventana)
	{	
		this.ventana = ventana;
		this.presentador = new UsuariosPresentador(this);
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
			{longitud:100, 	titulo:"Password",   	alias:"password", alineacion:"I" }, 
			{longitud:200, 	titulo:"Primer nombre",   alias:"primerNombre", alineacion:"I" }, 
			{longitud:200, 	titulo:"Segundo nombre",   alias:"segundoNombre", alineacion:"I" }, 
			{longitud:200, 	titulo:"Apellido paterno",   alias:"apellidoPaterno", alineacion:"I" },	
			{longitud:200, 	titulo:"Apellido materno",   alias:"apellidoMaterno", alineacion:"I" },	
			{longitud:200, 	titulo:"Nombre completo",   alias:"nombreCompleto", alineacion:"I" },	
			{longitud:100, 	titulo:"Id Genero",   	alias:"idGenero", alineacion:"I" },
			{longitud:100, 	titulo:"Nacionalidad",   	alias:"nacionalidad", alineacion:"I" }, 
			{longitud:100, 	titulo:"Fecha de nacimiento",   	alias:"fechaNacimiento", alineacion:"I" }, 
			{longitud:100, 	titulo:"RFC",   alias:"rfc", alineacion:"I" },	
			{longitud:100, 	titulo:"NSS",   alias:"nss", alineacion:"I" },	
			{longitud:150, 	titulo:"CURP",   alias:"curp", alineacion:"I" },
			{longitud:100, 	titulo:"Código postal",   alias:"codigoPostal", alineacion:"I" }, 
			{longitud:100, 	titulo:"Número exterior",   alias:"numeroExterior", alineacion:"I" },	
			{longitud:100, 	titulo:"Número interior",   alias:"numeroInterior", alineacion:"I" },	
			{longitud:200, 	titulo:"Calle",   alias:"calle", alineacion:"I" },	
			{longitud:200, 	titulo:"Colonia",   alias:"colonia", alineacion:"I" },	
			{longitud:200, 	titulo:"Estado",   alias:"estado", alineacion:"I" },	
			{longitud:200, 	titulo:"País",   alias:"pais", alineacion:"I" },
			{longitud:200, 	titulo:"Ciudad",   alias:"ciudad", alineacion:"I" },
			{longitud:200, 	titulo:"Direccion",   alias:"direccion", alineacion:"I" },
			{longitud:200, 	titulo:"Correo electronico",   alias:"correoElectronicoEmpresa", alineacion:"I" },
			{longitud:200, 	titulo:"Correo electronico",   alias:"correoElectronicoPersonal", alineacion:"I" },
			{longitud:200, 	titulo:"Telefono celular",   alias:"telefonoCelular", alineacion:"I" },
			{longitud:200, 	titulo:"Telefono casa",   alias:"telefonoCasa", alineacion:"I" },
			{longitud:200, 	titulo:"Telefono contacto",   alias:"telefonoContacto", alineacion:"I" },
			{longitud:200, 	titulo:"Numero de empleado",   alias:"numeroEmpleado", alineacion:"I" },
			{longitud:200, 	titulo:"Fecha de ingreso",   alias:"fechaIngreso", alineacion:"I" },
			{longitud:200, 	titulo:"Tipo de banco",   alias:"tipoBanco", alineacion:"I" },
			{longitud:200, 	titulo:"Clave bancaria",   alias:"claveBancaria", alineacion:"I" },
			{longitud:200, 	titulo:"Sueldo",   alias:"sueldo", alineacion:"I" },
			{longitud:200, 	titulo:"Fecha de baja",   alias:"fechaBaja", alineacion:"I" },
			{longitud:200, 	titulo:"Id de baja",   alias:"idBaja", alineacion:"I" },
			{longitud:200, 	titulo:"Extension de usuario",   alias:"extensionUsuario", alineacion:"I" },
			
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
	}
	
	/*
	 * Eventos en botones
	*/
	
	btnAlta_onClick()
	{
		this.modo = "ALTA";
		this.limpiarFormulario();	
		this.mostrarFormulario();
		this.presentador.consultarPorPostal();
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
			this.presentador.consultarPorPostal();
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
	
	
	set datosPostales(valor)
	{
		
		this.promptPostales = valor;
		//this.datosPostales = valor;
		//this.render();
	}
	
	/*
	 * Mapeo de datos del formulario con el modelo
	 */
	
	set usuario(valor)
	{		
		$('#idFormularioInput').val(valor.id);
		$('#passwordFormularioInput').val(valor.password);
		$('#primerNombreFormularioInput').val(valor.primerNombre);
		$('#segundoNombreFormularioInput').val(valor.segundoNombre);
		$('#apellidoPaternoFormularioInput').val(valor.apellidoPaterno);
		$('#apellidoMaternoFormularioInput').val(valor.apellidoMaterno);
		$('#nombreCompletoFormularioInput').val(valor.nombreCompleto);
		$('#idGeneroFormularioInput').val(valor.idGenero);
		$('#nacionalidadFormularioInput').val(valor.nacionalidad);
		$('#fechaNacimientoFormularioInput').val(valor.fechaNacimiento);
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
		$('#ciudadFormularioInput').val(valor.ciudad);	
		$('#direccionFormularioInput').val(valor.direccion);
		$('#correoElectronicoPersonalFormularioInput').val(valor.correoElectronicoPersonal);
		$('#correoElectronicoEmpresaFormularioInput').val(valor.correoElectronicoEmpresa);
		$('#telefonoCelularFormularioInput').val(valor.telefonoCelular);
		$('#telefonoCasaFormulario').val(valor.telefonoCasa);
		$('#telefonoContactoFormularioInput').val(valor.telefonoContacto);
		$('#numeroEmpleadoFormularioInput').val(valor.numeroEmpleado);
		$('#fechaIngresoFormularioInput').val(valor.fechaIngreso);
		$('#tipoBancoFormularioInput').val(valor.tipoBanco);
		$('#claveBancariaFormularioInput').val(valor.claveBancaria);
		$('#sueldoFormularioInput').val(valor.sueldo);
		$('#fechaBajaFormularioInput').val(valor.fechaBaja);
		$('#idBajaFormularioInput').val(valor.idBaja);
		$('#extensionUsuarioFormularioInput').val(valor.extensionUsuario);
	}
	
	get usuario()
	{
		 var usuario = 
		 {				    
			 id:$('#idFormularioInput').val(),
			 password:$('#passwordFormularioInput').val(),
			 primerNombre:$('#primerNombreFormularioInput').val(),
			 segundoNombre:$('#segundoNombreFormularioInput').val(),
			 apellidoPaterno:$('#apellidoPaternoFormularioInput').val(),
			 apellidoMaterno:$('#apellidoMaternoFormularioInput').val(),
			 nombreCompleto:$('#nombreCompletoFormularioInput').val(),
			 idGenero:$('#idGeneroFormularioInput').val(),
			 nacionalidad:$('#nacionalidadFormularioInput').val(),
			 fechaNacimiento:$('#fechaNacimientoFormularioInput').val(),
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
			 ciudad:$('#ciudadFormularioInput').val(),
			 direccion:$('#direccionFormularioInput').val(),			 
			 correoElectronicoEmpresa:$('#correoElectronicoEmpresaFormularioInput').val(),
			 correoElectronicoPersonal:$('#correoElectronicoPersonalFormularioInput').val(),
			 telefonoCelular:$('#telefonoCelularFormularioInput').val(),
			 telefonoCasa:$('#telefonoCasaFormularioInput').val(),
			 telefonoContacto:$('#telefonoContactoFormularioInput').val(),
			 numeroEmpleado:$('#numeroEmpleadoFormularioInput').val(),
			 fechaIngreso:$('#fechaIngresoFormularioInput').val(),
			 tipoBanco:$('#tipoBancoFormularioInput').val(),
			 claveBancaria:$('#claveBancariaFormularioInput').val(),
			 sueldo:$('#sueldoFormularioInput').val(),
			 fechaBaja:$('#fechaBajaFormularioInput').val(),
			 idBaja:$('#idBajaFormularioInput').val(),
			 extensionUsuario:$('#extensionUsuarioFormularioInput').val() 
		 };
		 return usuario;
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
		if($('#primerNombreFormularioInput').val()=='')					
			return $('#primerNombreFormularioInput');
		
		if($('#apellidoPaternoFormularioInput').val()=='')					
			return $('#apellidoPaternoFormularioInput');
		
		return null;
	}	
	
	/*
	 * Limpiar formulario
	 */
	limpiarFormulario()
	{
		$('#idFormularioInput').val("");
		$('#passwordFormularioInput').val("");
		$('#primerNombreFormularioInput').val("");
		$('#segundoNombreFormularioInput').val("");
		$('#apellidoPaternoFormularioInput').val("");
		$('#apellidoMaternoFormularioInput').val("");
		$('#nombreCompletoFormularioInput').val("");
		$('#idGeneroFormularioInput').val("");
		$('#nacionalidadFormularioInput').val("");
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
		$('#ciudadFormularioInput').val("");	
		$('#correoElectronicoEmpresaFormularioInput').val("");
		$('#correoElectronicoPersonalFormularioInput').val("");
		$('#telefonoCelularFormularioInput').val("");
		$('#telefonoCasa').val("");
		$('#telefonoContactoFormularioInput').val("");
		$('#numeroEmpleadoFormularioInput').val("");
		$('#fechaIngresoFormularioInput').val("");
		$('#tipoBancoFormularioInput').val("");
		$('#claveBancariaFormularioInput').val("");
		$('#sueldoFormularioInput').val("");
		$('#fechaBajaFormularioInput').val("");
		$('#idBajaFormularioInput').val("");
		$('#extensionUsuarioFormularioInput').val("");
	}
	consutarPostalCri()
	{
		//consultar criterios
		alert( "si");
	}


	verDatosAsis()
	{	
		this._promptPostales = new PromptPostales("_promptPostales")
		this._promptPostales.setViewport("PromptPostal");
		this._promptPostales.load(this.datosPostales,this);
		this._promptPostales.render();
	}

	
}
var vista = new UsuariosVista(this);

