class PostalVista
{		
	constructor()
	{
	
		this.presentador = new PostalPresentador(this);
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
			{longitud:200, 	titulo:"id",   alias:"id", alineacion:"I" }, 
			{longitud:200, 	titulo:"Asentamiento",   alias:"asentamiento", alineacion:"I" }, 
			{longitud:200, 	titulo:"Municipio",   alias:"municipio", alineacion:"I" },	
			{longitud:200, 	titulo:"Estado",   alias:"estado", alineacion:"I" },	
			{longitud:100, 	titulo:"Ciudad",   alias:"ciudad", alineacion:"I" },	
		]

		this.grid._ajustarAltura = true;
		this.grid._colorRenglon1 = "#FFFFFF";	
		this.grid._colorRenglon2 = "#f8f2de";
		this.grid._colorEncabezado1 = "#FF6600";
		this.grid._colorEncabezado2 = "#FF6600";
		this.grid._colorLetraEncabezado = "#ffffff";
		this.grid._colorLetraCuerpo = "#000000";
		this.grid._regExtra=14;
		this.grid._presentacionGranTotal = "SI";
		this.grid.subscribirAEvento(this, "eventgridRowDoubleClick", this.grid_eventgridRowDoubleClick);
		this.grid.render();		
	}
	
	btnConsulta2_onClick()
	{
		this.presentador.consultar();
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
	
	grid_eventgridRowDoubleClick()
	{
		$('#principal').hide()	
		$('#altaCambioDiv').show();
	}
	
	btnAlta2_onClick()
	{
		$('#principal').hide()	
		$('#altaCambioDiv').show();
	}
	
	
	btnGuardar2_onClick()
	{
		this.presentador.insertar();
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
	}
}
var vistas = new PostalVista();
