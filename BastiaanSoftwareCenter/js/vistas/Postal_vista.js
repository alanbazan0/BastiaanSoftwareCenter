class PostalVista
{		
	constructor()
	{
	
		this.presentador = new PostalPresentador(this);
		this.manejadorEventos = new ManejadorEventos();
		this.grid = new GridReg("grid");	
	}
	onLoad()
	{			
		this.crearColumnasgrid();
	}
	
	crearColumnasgrid()
	{
		//var div = $('#grid');
		//this.html.grid = new gridReg("grid");	
		this.grid._columnas = [
			{longitud:100, 	titulo:"No postal",   	alias:"nopostal", alineacion:"I" }, 
			{longitud:200, 	titulo:"ID",   alias:"id", alineacion:"I" }, 
			{longitud:200, 	titulo:"Asentamiento",   alias:"asentamiento", alineacion:"I" }, 
			{longitud:200, 	titulo:"Municipio",   alias:"municipio", alineacion:"I" },	
			{longitud:200, 	titulo:"Estado",   alias:"estado", alineacion:"I" },	
			{longitud:100, 	titulo:"Ciudad",   alias:"ciudad", alineacion:"I" },	
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
		this.grid._regExtra=14;
	//	this.grid._presentacionGranTotal = "SI";
//		this.grid.subscribirAEvento(this, "eventgridRowDoubleClick", this.grid_eventgridRowDoubleClick);
		this.grid.render();		
	}
	
	btnConsulta2_onClick()
	{
		this.presentador.consultar();
	}
	
	btnBaja2_onClick()
	{ 
		 var answer = confirm("¿Deseas eliminar este postal?")
		    if (answer){
		    	$('#idInput').val(this.grid._selectedItem.id)
		    	this.presentador.eliminar();
		    }	
	}
	
	 get noPostal()
		{
			return $('#noPostalInput').val();
		}
		
		get id()
		{
			return $('#idInput').val();
		}
		
		get asentamiento()
		{
			return $('#asentamientoInput').val();
		}

		get municipio()
		{
			return $('#municipioInput').val();
		}
		
		get estado()
		{
			return $('#estadoInput').val();
		}
		
		get ciudad()
		{
			return $('#ciudadInput').val();
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
	
	btnAlta2_onClick()
	{
		$('#principal').hide()	
		$('#altaCambioDiv').show();
	}
	
	btnCambio2_onClick()
	{
		if( this.grid._selectedItem!=null){
			$('#principal').hide()	
			$('#altaCambioDiv').show();
			$('#idInput').val(this.grid._selectedItem.id)
			this.presentador.consultarPorId();
		}else{
			alert("Selecciona un postal para actualizar");
		}		
	}
	
	
	btnGuardar2_onClick()
	{		
		if(this.validar()!= 0){
			if( $('#idInput').val()==""){
				this.presentador.insertar();
			}else{
				this.presentador.actualizar();
			}
		}
		
	}
	
	//campos del formulario
	

    get noPostal()
	{
		return $('#noPostalInput').val();
	}
	
	get id()
	{
		return $('#idInput').val();
	}
	
	get asentamiento()
	{
		return $('#asentamientoInput').val();
	}

	get municipio()
	{
		return $('#municipioInput').val();
	}
	
	get estado()
	{
		return $('#estadoInput').val();
	}
	
	get ciudad()
	{
		return $('#ciudadInput').val();
	}
	
	
	set resultado(valor)
	{
		alert(valor);
		this.limpiar();
	}
	
	
	validar()
	{
		if($('#nopostalInput').val()==""){
			alert("Tiene que llenar el campo No postal");
			$('#nopostalInput').focus();
			return 0;
		}
		
		if($('#asentamientoInput').val()==""){
			alert("Tiene que llenar el campo asentamiento");
			$('#asentamientoInput').focus();
			return 0;
		}
		
		if($('#municipioInput').val()==""){
			alert("Tiene que llenar el campo municipio");
			$('#municipioInput').focus();
			return 0;
		}
		
				
		if($('#estadoInput').val()==""){
			alert("Tiene que llenar el campo estado");
			$('#estadoInput').focus();
			return 0;
		}
		
		if($('#ciudadInput').val()==""){
			alert("Tiene que llenar el campo Ciudad");
			$('#ciudadInput').focus();
			return 0;
		}
		
	}
	
	btnSalir2_onClick(){		
		$('#altaCambioDiv').hide();
		$('#principal').show();
		this.limpiar();
	}
	
	limpiar(){
       		$('#nopostalInput').val("");
			$('#idInput').val("");
			$('#asentamientoInput').val("");
			$('#municipioInput').val("");
			$('#estadoInput').val("");
			$('#ciudadInput').val("");
	}
	
	set resultadoActualizar(valor)
	{				
		$('#nopostalInput').val(valor[0].nopostal);
		$('#asentamientoInput').val(valor[0].asentamiento);
		$('#municipioInput').val(valor[0].municipio);
		$('#estadoInput').val(valor[0].estado);
		$('#ciudadInput').val(valor[0].ciudad);
	}
	
}
	
var vistas = new PostalVista();
