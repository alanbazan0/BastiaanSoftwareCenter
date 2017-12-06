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
		
		this.cmbEstatus = new Combo("agenteIdFormularioInput");
		this.cmbEstatus.setViewport("recesoIdFormularioInput");
		this.cmbEstatus._dataField = "recesoId";
		this.cmbEstatus._labelField = "rCorto";
		this.cmbEstatus.render();
	}
	
	crearColumnasGrid()
	{
		this.grid._columnas = [
	
			{longitud:90, 	titulo:"Id",   	alias:"id", alineacion:"I" }, 
			{longitud:240, 	titulo:"Nombre Agente",   alias:"agenteId", alineacion:"I" }, 
			{longitud:100, 	titulo:"Nombre Pila",   alias:"recesoId", alineacion:"I" }, 
			{longitud:200, 	titulo:"Descripcion",   alias:"recesoC", alineacion:"I" }, 
			{longitud:100, 	titulo:"F.Incial",   alias:"fInicial", alineacion:"C" },
			{longitud:100, 	titulo:"F.Final",   alias:"fFinal", alineacion:"C" },
			{longitud:100, 	titulo:"H.Inicial",   alias:"hInicial", alineacion:"C" },
			{longitud:100, 	titulo:"H.Final",   alias:"hFinal", alineacion:"C" }, 
			{longitud:100, 	titulo:"Duracion",   alias:"dPersonal", alineacion:"C" }, 
			{longitud:130, 	titulo:"Duración en Segundos",  alias:"dsPersonal", alineacion:"D" }, 
			//{longitud:150, 	titulo:"Fecha Personal",   alias:"fPersonal", alineacion:"I" },
			
		    ]
		this.grid._origen="vista";
		this.grid.manejadorEventos=this.manejadorEventos;
		this.grid._ajustarAltura = true;
		this.grid._colorRenglon1 = "#FFFFFF";	
		this.grid._colorRenglon2 = "#f8f2de";
		this.grid._colorEncabezado1 = "#FF6600";
		this.grid._colorEncabezado2 = "#FF6600";
		this.grid._colorLetraEncabezado = "#FFFFFF";
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
		
		this.presentador.consultarPorReceso();

		$('.time').clockTimePicker();
		/*
	
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1;
		var yyyy = today.getFullYear();
		
		if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} 
			var strToday = new Date(mm+'/'+dd+'/'+yyyy); // = '01/'+mm+'/'+yyyy;
		var strTodayFirst = new Date(mm+'/'+'01/'+yyyy); // = '01/'+mm+'/'+yyyy;
		
		
		$("#"+ "fFinalFormularioInput").datepicker( {dateFormat:'dd/mm/yy'});
		$("#"+ "fFinalFormularioInput").datepicker( "option", $.datepicker.regional[ 'es' ] );
		$("#"+ "fFinalFormularioInput").datepicker({showOn:'button', buttonImage:'assets/botones/calendario.svg', buttonImageOnly:true});
		$("#"+ "fFinalFormularioInput").datepicker('option', {dateFormat:'dd/mm/yy'});
		$("#"+ "fFinalFormularioInput").datepicker("setDate", strTodayFirst);
		$("#"+ "fFinalFormularioInput").datepicker();	
		
		$("#"+ "fInicialFormularioInput").datepicker( {dateFormat:'dd/mm/yy'});
		$("#"+ "fInicialFormularioInput").datepicker( "option", $.datepicker.regional[ 'es' ] );
		$("#"+ "fInicialFormularioInput").datepicker({showOn:'button', buttonImage:'assets/botones/calendario.svg', buttonImageOnly:true});
		$("#"+ "fInicialFormularioInput").datepicker('option', {dateFormat:'dd/mm/yy'});
		$("#"+ "fInicialFormularioInput").datepicker("setDate", strTodayFirst);
		$("#"+ "fInicialFormularioInput").datepicker();
		
		$("#"+ "fPersonalFormularioInput").datepicker( {dateFormat:'dd/mm/yy'});
		$("#"+ "fPersonalFormularioInput").datepicker( "option", $.datepicker.regional[ 'es' ] );
		$("#"+ "fPersonalFormularioInput").datepicker({showOn:'button', buttonImage:'assets/botones/calendario.svg', buttonImageOnly:true});
		$("#"+ "fPersonalFormularioInput").datepicker('option', {dateFormat:'dd/mm/yy'});
		$("#"+ "fPersonalFormularioInput").datepicker("setDate", strTodayFirst);
		$("#"+ "fPersonalFormularioInput").datepicker();
		
        */
	    this.presentador.consultarPorUsuario();
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
			this.presentador.consultarPorReceso();
			
			
			$('.time').clockTimePicker();

			/*
		    var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1;
			var yyyy = today.getFullYear();
			
			if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} 
				var strToday = new Date(mm+'/'+dd+'/'+yyyy); // = '01/'+mm+'/'+yyyy;
			var strTodayFirst = new Date(mm+'/'+'01/'+yyyy); // = '01/'+mm+'/'+yyyy;
			
			
			$("#"+ "fFinalFormularioInput").datepicker( {dateFormat:'dd/mm/yy'});
			$("#"+ "fFinalFormularioInput").datepicker( "option", $.datepicker.regional[ 'es' ] );
			$("#"+ "fFinalFormularioInput").datepicker({showOn:'button', buttonImage:'assets/botones/calendario.svg', buttonImageOnly:true});
			$("#"+ "fFinalFormularioInput").datepicker('option', {dateFormat:'dd/mm/yy'});
			$("#"+ "fFinalFormularioInput").datepicker("setDate", strTodayFirst);
			$("#"+ "fFinalFormularioInput").datepicker();
			
			$("#"+ "fInicialFormularioInput").datepicker( {dateFormat:'dd/mm/yy'});
			$("#"+ "fInicialFormularioInput").datepicker( "option", $.datepicker.regional[ 'es' ] );
			$("#"+ "fInicialFormularioInput").datepicker({showOn:'button', buttonImage:'assets/botones/calendario.svg', buttonImageOnly:true});
			$("#"+ "fInicialFormularioInput").datepicker('option', {dateFormat:'dd/mm/yy'});
			$("#"+ "fInicialFormularioInput").datepicker("setDate", strTodayFirst);
			$("#"+ "fInicialFormularioInput").datepicker();
			
			$("#"+ "fPersonalFormularioInput").datepicker( {dateFormat:'dd/mm/yy'});
			$("#"+ "fPersonalFormularioInput").datepicker( "option", $.datepicker.regional[ 'es' ] );
			$("#"+ "fPersonalFormularioInput").datepicker({showOn:'button', buttonImage:'assets/botones/calendario.svg', buttonImageOnly:true});
			$("#"+ "fPersonalFormularioInput").datepicker('option', {dateFormat:'dd/mm/yy'});
			$("#"+ "fPersonalFormularioInput").datepicker("setDate", strTodayFirst);
			$("#"+ "fPersonalFormularioInput").datepicker();*/
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

		this.presentador.consultarPorUsuario();
		
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
	 btnExito_onClick()
	 {
	   // funciona para los dos navegadores 
	   this.grid._dataProvider
	   this.grid._colorRenglon1 = "#FFFFFF"; 
	    this.grid._colorRenglon2 = "#FFFFFF";
	    this.grid._colorEncabezado1 = "#FF6600";
	    this.grid._colorLetraEncabezado = "#000000";
	    this.grid._colorLetraCuerpo = "#000000";
	    this.grid.render(); 
	    
	   window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#grid').html()));
	   
	   this.grid._colorRenglon1 = "#FFFFFF"; 
	   this.grid._colorRenglon2 = "#f8f2de";
	   this.grid._colorEncabezado1 = "#FF6600";
	   this.grid._colorEncabezado2 = "#FF6600";
	   this.grid._colorLetraEncabezado = "#FFFFFF";
	   this.grid._colorLetraCuerpo = "#000000";
	   this.grid._regExtra=20;
	   this.grid.render();
	  
	 
	 }
		
/*
		 var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
		    var textRange; var j=0;
		  //var tab = document.getElementById("grid").value; // id of table
		    
		    var tab =this.grid._dataProvider;

		    for(j = 0 ; j < tab.length; j++) 
		    {     
		        tab_text=tab_text+tab[j].innerHTML+"</tr>";
		        //tab_text=tab_text+"</tr>";
		    }

		   var  tab_text=tab_text+"</table>";
		   var  tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
		   var  tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
		    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

		    var ua = window.navigator.userAgent;
		    var msie = ua.indexOf("MSIE "); 

		    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
		    {
		        txtArea1.document.open("txt/html","replace");
		        txtArea1.document.write(tab_text);
		        txtArea1.document.close();
		        txtArea1.focus(); 
		        sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
		    }  
		    else                 //other browser not tested on IE 11
		        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

		    return (sa);
*/
	

	
	
	
	
	
	
	
	
	
		/*
		 var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
		    var textRange; var j=0;
		    tab = document.getElementById('headerTable'); // id of table

		    for(j = 0 ; j < tab.rows.length ; j++) 
		    {     
		        tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
		        //tab_text=tab_text+"</tr>";
		    }

		    tab_text=tab_text+"</table>";
		    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
		    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
		    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

		    var ua = window.navigator.userAgent;
		    var msie = ua.indexOf("MSIE "); 

		    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
		    {
		        txtArea1.document.open("txt/html","replace");
		        txtArea1.document.write(tab_text);
		        txtArea1.document.close();
		        txtArea1.focus(); 
		        sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
		    }  
		    else                 //other browser not tested on IE 11
		        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

		    return (sa);
		    
		 */
		
	

	
	//funcion de calculo en segundos
	
	 myFunction() {

		var inicio = document.getElementById("hInicialFormularioInput").value;
		var fin = document.getElementById("hFinalFormularioInput").value;
	 
		var inicioHoras = parseInt(inicio.substr(0,2));
		var inicioMinutos = parseInt(inicio.substr(3,2));
		var inicioSegundos = parseInt(inicio.substr(6,2));
		  
		var  finHoras = parseInt(fin.substr(0,2));
		var  finMinutos = parseInt(fin.substr(3,2));
		var  finSegundos = parseInt(fin.substr(6,2));

	    var transcurridoMinutos = finMinutos - inicioMinutos;
		var transcurridoHoras = finHoras - inicioHoras;
		var transcurridoSegundos = finSegundos - inicioSegundos;
		
		var calculoMinutosPorHora = transcurridoHoras * 60;
		var calculoSegundosPorHora = calculoMinutosPorHora * 60;
		var calculoSegundosPorMinuto = transcurridoMinutos * 60;
		var calculoSegundosHorasMin = calculoSegundosPorHora + calculoSegundosPorMinuto;
		var calculoSumaSegundos = calculoSegundosHorasMin + transcurridoSegundos; 
		  
		  if (transcurridoMinutos < 0) {
		    transcurridoHoras--;
		    transcurridoMinutos = 60 + transcurridoMinutos;
		  }
		  
		  if (transcurridoSegundos < 0) {
			    transcurridoMinutos--;
			    transcurridoSegundos = 60 + transcurridoSegundos;
			  }
		  
		  var horas = transcurridoHoras.toString();
		  var minutos = transcurridoMinutos.toString();
		  var segundos = transcurridoSegundos.toString();
		  
		  if (horas.length < 2) {
		    horas = "0"+horas;
		  }
		  
		  if (minutos.length < 2) {
		    minutos = "0"+minutos;
		  }
		  
		  if (segundos.length < 2) {
			    segundos = "0"+segundos;
			  }
	 
		var confirmacion = confirm("Verifique que los datos ingresados sean correctos.");

		if (confirmacion)
	   	{
			document.getElementById("dPersonalFormularioInput").value = horas+":"+minutos+":"+segundos;
			document.getElementById("dsPersonalFormularioInput").value = calculoSumaSegundos;
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
	

	btnconsulta_onClick()
	{		
		this.btnconsulta();
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
		    id:$('#agenteIdCriterioInput').val(),
		    fInicial:$('#fInicialCriterioInput').val(),
			fFinal:$('#fFinalCriterioInput').val()

		 }
		 return criteriosSeleccion;
	}		
	
	get criteriosUsuarios()
	{	
		var criteriosUsuarios =
	    {
		agenteId:$('#idCriterioAsistenteInput').val(),
		agente:$('#dscCriterioAsistenteInput').val()
	    }
	    return 	criteriosUsuarios;
	}	
	
	
	
	
	set datosRecesos(valor)
	{
		this.cmbEstatus._dataProvider = valor;
		this.cmbEstatus.setSeleccionado("recesoId",this.recesoId);
		this.cmbEstatus.render();
		
	}
	

	set datos(valor)
	{
		this.grid._dataProvider = valor;	
		this.grid.render();
	}
	
	
	  
	
	
	
	


	
	set datosUsuarios(valor)
	{
	this._gridListaArchivos._dataProvider = valor;
	this._gridListaArchivos.render();
	//alert(this.datosUsuarios._dataProvider);
	
	}	
	
	
	
	

	
	
	/*
	get criteriosUsuarios()
	 {	
	var criteriosSeleccion =
       {
	     AgenteId:$('#AgenteIdCriterioInput').val(),
	     agente:$('#agenteCriterioInput').val()
	    }
	return criteriosUsuarios;
    }
	
	*/
	

	/*
	 * Asignar registros al grid
	 */
	/*
	 * Mapeo de datos del formulario con el modelo
	 */
	
	set receso(valor)
	{		
		$('#idFormularioInput').val(valor.id);
		$('#agenteIdFormularioInput').val(valor.agenteId);
		$('#agenteFormularioInput').val(valor.agente);
		$('#recesoIdFormularioInput').val(valor.recesoId);
		$('#recesoCFormularioInput').val(valor.recesoC);
		$('#fInicialFormularioInput').val(valor.fInicial);
		$('#fFinalFormularioInput').val(valor.fFinal);
		$('#fPersonalFormularioInput').val(valor.fPersonal);
		
		$('#hInicialFormularioInput').val(valor.hInicial);
		$('#hFinalFormularioInput').val(valor.hFinal);
		$('#dPersonalFormularioInput').val(valor.dPersonal);
		$('#dsPersonalFormularioInput').val(valor.dsPersonal);
		this.recesoId = valor.recesoId
		
	}
	
	get receso()
	{
		 var receso = 
		 {				    
			 id:$('#idFormularioInput').val(),
			 agenteId:$('#agenteIdFormularioInput').val(),
			 agente:$('#agenteFormularioInput').val(),
			 recesoC:$('#recesoCFormularioInput').val(),
			 recesoId:this.cmbEstatus._selectedItem.recesoId,
			 fInicial:$('#fInicialFormularioInput').val(),
			 fFinal:$('#fFinalFormularioInput').val(),
			 fPersonal:$('#fPersonalFormularioInput').val(),
			 hInicial:$('#hInicialFormularioInput').val(),
			 hFinal:$('#hFinalFormularioInput').val(),
			 dPersonal:$('#dPersonalFormularioInput').val(),
			 dsPersonal:$('#dsPersonalFormularioInput').val()
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
		$('#PromptUsuario').hide();
	}
	
	salirFormulario()
	{
		$('#principalDiv').show()	
		$('#formularioDiv').hide();
	}
	
	btnsalirPromt_onClick()
	{
		$('#principalDiv').hide()	
		$('#formularioDiv').show();
		this.mostrarFormulario();
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
		$('#agenteFormularioInput').val("");
		$('#recesoCFormularioInput').val("");
		$('#recesoIdFormularioInput').val("");
		$('#fInicialFormularioInput').val("");
		$('#fFinalFormularioInput').val("");
		$('#fPersonalFormularioInput').val("");
		$('#hInicialFormularioInput').val("");
		$('#hFinalFormularioInput').val("");
		$('#dPersonalFormularioInput').val("");
		$('#dsPersonalFormularioInput').val("");
		
	}
	
	
	
	usuarioSelect()
	{
		
		$('#agenteFormularioInput').val(this._gridListaArchivos._selectedItem.id);
		$('#agenteIdFormularioInput').val(this._gridListaArchivos._selectedItem.agenteId);
		$('#principalDiv').hide()	
		$('#formularioDiv').show();
		this.mostrarFormulario();
	 }      
	
	/*
	verDatosAsis()
	{
		var datosPrompt = {};	
		datosPrompt.agenteId = "";
		this._promptUsuarios = new PromptUsuarios("_promptUsuarios")
		this._promptUsuarios.setViewport("PromptUsuario");
		this._promptUsuarios.load(datosPrompt);				
		this._promptUsuarios.render();
	}
}

*/

consutarUsuarioCri()
{
	//consultar criterios
	//alert( "si");
}


verDatosAsis()
{	
	/*this._promptUsuarios = new PromptUsuarios("_promptUsuarios")
	this._promptUsuarios.setViewport("PromptUsuario");
	this._promptUsuarios.load(this.PromptUsuarios,this);				
	this._promptUsuarios.render();*/
	
	
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
	output += "  >";
	output += "</td>";
	output += "<img src='assets/botones/imgConsulta.png' onClick='vista.btnconsultaPrompt_onClick();' style='float:right;cursor:pointer;width:48px;height:48px;'>";
	output += "</td>";
	output += "</div>";
		output += "<div class='contCriterios2' id='contCriterios2' style='height:370'>";
		output += "<table WIDHT=25%; HEIGHT=35%;  CELLPADDING=0; cellspacing='15' style='padding-top: 1px; padding-left: 1%; position:relative;display:block;'>";  
		output += "<td>";
		output += "<tr>";	
		output += "<td>";
		output += "<label style='position: relative; left: 15px'>Id:</label>";
		output += "</td>"
		output += "<td>";
	output += "	<input  id='idCriterioAsistenteInput' type='text' style='left: 80px;box-shadow: 2px 2px 5px #999;' width:100px;'/>";
		output += "</td>"	
	output += "</tr>";
	output += "<tr>";
	output += "<td>";
	output += "<label style='position: relative; left: 15px'>Nombre Agente:</label>";
		output += "</td>"
		output += "<td>"
	output += "	<input id='dscCriterioAsistenteInput' type='text' style='right:3%;box-shadow: 2px 2px 5px #999;' width:100px;'>" ;
	output += "</td>";
	output += "</tr>";
	output += "</td>";
	output += "</table>";
	
		
		output +=" <div id='PromptUsuarioGrid' class='gridPrompt' style='height:60%;width:491px;></div>";	
	
		
		output += "</div'>";
		
	output += "</div'>";
	output += "</div'>";
	document.getElementById("PromptUsuario").innerHTML = output;
	document.getElementById("PromptUsuario").style.display = "block";			
	document.getElementById("PromptUsuario").style.position = "fixed";
	

	this._gridListaArchivos = new GridReg("_gridListaArchivos");
	var columnas = [
		{longitud:180, titulo:"Id", alias:"id", alineacion:"I"},
		{longitud:272, titulo:"Nombre Agente", alias:"agenteId", alineacion:"I"}
	];
	this._gridListaArchivos
	._origen="vista";
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
	this._gridListaArchivos.subscribirAEvento(this, "eventGridRowDoubleClick",vista.usuarioSelect);
	//this._gridListaArchivos._dataProvider = [];
	this._gridListaArchivos.setViewport("PromptUsuarioGrid");
	this._gridListaArchivos.render();
	this.presentador.consultarPorUsuario();   
	
}





}
var vista = new MovimientosVista(this);

