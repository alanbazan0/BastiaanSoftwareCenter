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
	
	
	btnconsultaPrompt_onClick()
	{
		this.presentador.consultarPorPostal();
	}
	btnExcel_onClick()
	{
	
	//	this.presentador.consultar();
		
		  function descargarExcel(){
		        //Creamos un Elemento Temporal en forma de enlace
		        var tmpElemento = document.createElement('a');
		        // obtenemos la información desde el div que lo contiene en el html
		        // Obtenemos la información de la tabla
		        var data_type = 'data:application/vnd.ms-excel';
		        var tabla_div = document.getElementById('principalDiv');
		        var tabla_html = tabla_div.outerHTML.replace(/ /g, '%20');
		        tmpElemento.href = data_type + ', ' + tabla_html;
		        //Asignamos el nombre a nuestro EXCEL
		        tmpElemento.download = 'MovimientosPersonal.xls';
		        tmpElemento.click();
		    }
		    descargarExcel();
	
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
	
	btnsalirPrompt_onClick()
	{
			this.mostrarFormulario();
	}
	
	btnSalir_onClick()
	{
		var confirmacion = confirm("¿Esta seguro que desea salir?")
	    if (confirmacion)
	    	{
	    	//TODO: Cerrar ventana aqui
	    	}
	}
	
	btnsalirPromt_onClick()
	{		
		this.mostrarFormulario();
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
	
	get criteriosPostales()
	{	
		var criteriosPostales =
	    {
		idPostal:$('#idPostalCriterioAsistenteInput').val(),
		nirPostal:$('#nirPostalCriterioAsistenteInput').val()
	    }
	    return 	criteriosPostales;
	}	
	
	set datosPostales(valor)
	{
	
		this._gridListaArchivos._dataProvider = valor;
		this._gridListaArchivos.render();
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
	set datosPostales(valor)
	{
		
		this.promptPostales = valor;
		//this.datosPostales = valor;
		//this.render();
	}
	

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
		$('#principalDiv').hide();
		$('#formularioDiv').show();
		$('#PromptPostal').hide();
	}
/*	ocultarPrompt()
	{
		$('#principalDiv').hide();
		$('#PromptPrincipalPostalGrid').hide();
		$('#formularioDiv').show();
	}*/
	salirFormulario()
	{
		$('#principalDiv').show()	
		$('#formularioDiv').hide();
	}
	
	usuarioSelect()
	{
		
		
		$('#codigoPostalFormularioInput').val(this._gridListaArchivos._selectedItem.nirPostal);
		
	    $('#principalDiv').hide()	
		$('#formularioDiv').show();
		this.mostrarFormulario();
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
		//alert( "si");
	}
	

	verDatosAsis()
	{	
		var output = "";
		output += '<div style="position: fixed; top: 0px; left: 0px; display: block; width: 100%; height: 100%; z-index: 5001; background-color: rgba(255, 255, 250, 0.75);" >'
		output += "<div class='panelAsistenteFRM' id='PMenuAsistente' style='width:520px;background-color:#BCBCBC;height:auto; margin-left:auto;margin-right:auto;margin-top:50px;padding-top:0px;padding-left: 0px;padding-right: 0px;' >";
		output += "<div class='tituloCriterio' style='height:52px;border-radius:20px;";
		output += "background-image: linear-gradient(bottom, rgb(100,100,100) 30%, rgb(140,140,140) 90%);";
		output += "background-image: -o-linear-gradient(bottom, rgb(100,100,100) 30%, rgb(140,140,140) 90%);";
		output += "background-image: -moz-linear-gradient(bottom, rgb(100,100,100) 30%, rgb(140,140,140) 90%);";
		output += "background-image: -webkit-linear-gradient(bottom, rgb(100,100,100) 30%, rgb(140,140,140) 90%);";
		output += "'>";
		output += "<td>";
		output += "<td>";
		output += "<img src='assets/botones/btnSalir.png' onClick='vista.btnsalirPromt_onClick();' style='float:right;cursor:pointer;width:48px;height:48px;'";
		output += "' >";
		output += "</td>";
		output += "<img src='assets/botones/imgConsulta.png' onClick='vista.btnconsultaPrompt_onClick();' style='float:right;cursor:pointer;width:48px;height:48px;'>";
		output += "</td>";
		output += "</div>";
			output += "<div class='contCriterios2' id='contCriterios2' style='height:370'>";
			output += "<table WIDHT=25%; HEIGHT=35%;  CELLPADDING=0; cellspacing='15' style='padding-top: 1px; padding-left: 1%; position:relative;display:block;'>";  
			output += "<td>";
			output += "<tr>";	
			output += "<td>";
			output += "<label style='position: relative; left: 15px'>Id Postal:</label>";
			output += "</td>"
			output += "<td>";
		output += "	<input  id='idPostalCriterioAsistenteInput' type='text' style='left: 80px;box-shadow: 2px 2px 5px #999;' width:100px;'/>";
			output += "</td>"	
		output += "</tr>";
		output += "<tr>";
		output += "<td>";
		output += "<label style='position: relative; left: 15px'>Codigo Postal:</label>";
			output += "</td>"
			output += "<td>"
		output += "	<input id='nirPostalCriterioAsistenteInput' type='text' style='right:3%;box-shadow: 2px 2px 5px #999;' width:100px;'>" ;
		output += "</td>";
		output += "</tr>";
		output += "</td>";
		output += "</table>";
		
			
			output +=" <div id='PromptPostalGrid' class='gridPrompt' style='height:60%;width:491px;></div>";	
		
			
			output += "</div'>";
			
		output += "</div'>";
		output += "</div'>";
		document.getElementById("PromptPostal").innerHTML = output;
		document.getElementById("PromptPostal").style.display = "block";			
		document.getElementById("PromptPostal").style.position = "fixed";
		
		this._gridListaArchivos = new GridReg("_gridListaArchivos");
		var columnas = [
			{longitud:86, titulo:"Id", alias:"idPostal", alineacion:"I"},
			{longitud:86, titulo:"Codigo Postal",  alias:"nirPostal", alineacion:"I" },
			{longitud:86, titulo:"Asentamiento",  alias:"asentamientoPostal", alineacion:"I" },
			{longitud:86, titulo:"Municipio",  alias:"municipioPostal", alineacion:"I" },
			{longitud:86, titulo:"Estado",  alias:"estadoPostal", alineacion:"I" },
			{longitud:86, titulo:"Ciudad",  alias:"ciudadPostal", alineacion:"I" }
		];
		this._gridListaArchivos._origen="vista";
		this._gridListaArchivos._columnas = columnas;
		this._gridListaArchivos._ajustarAltura 		= true;
		this._gridListaArchivos._colorRenglon1 		= "#FFFFFF";
		this._gridListaArchivos._colorRenglon2 		= "#FFFFFF";
		this._gridListaArchivos._colorEncabezado1 	= "#CCC";
		this._gridListaArchivos._colorEncabezado2 	= "#CCC";
		this._gridListaArchivos._colorLetraEncabezado = "#444444";
		this._gridListaArchivos._colorLetraCuerpo 	= "#888888";
		this._gridListaArchivos._colorLetraCuerpo 	= "#888888";
		this._gridListaArchivos.manejadorEventos=this.manejadorEventos;
		this._gridListaArchivos.subscribirAEvento(this, "eventGridRowDoubleClick",vista.usuarioSelect );
		
		this._gridListaArchivos.setViewport("PromptPostalGrid");
		this._gridListaArchivos.render();
		this.presentador.consultarPorPostal();
		
		
		/*
		this._promptPostales = new PromptPostales("_promptPostales")
		this._promptPostales.setViewport("PromptPostal");
		this._promptPostales.load(this.datosPostales,this);
		this._promptPostales.render();
		
		*/
	}

	
}
var vista = new UsuariosVista(this);

