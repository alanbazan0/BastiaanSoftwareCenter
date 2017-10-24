class PortableVista
{		
	constructor()
	{
	
		this.presentador = new PortablePresentador(this);
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
			{longitud:100, 	titulo:"NIR",   	alias:"id", alineacion:"I" }, 
			{longitud:100, 	titulo:"No Serie",   alias:"consecutivo", alineacion:"I" }, 
			{longitud:200, 	titulo:"Numero",   alias:"numero", alineacion:"I" }, 
			{longitud:400, 	titulo:"Empresa",   alias:"descripcion", alineacion:"I" },	
			{longitud:200, 	titulo:"Poblado",   alias:"poblacion", alineacion:"I" },	
			{longitud:200, 	titulo:"Municipio",   alias:"municipio", alineacion:"I" },	
			{longitud:200, 	titulo:"Estado",   alias:"estado", alineacion:"I" },	
		]

		this.grid._ajustarAltura = true;
		this.grid._colorRenglon1 = "#FFFFFF";	
		this.grid._colorRenglon2 = "#f8f2de";
		this.grid._colorEncabezado1 = "#FF6600";
		this.grid._colorEncabezado2 = "#FF6600";
		this.grid._colorLetraEncabezado = "#ffffff";
		this.grid._colorLetraCuerpo = "#000000";
		this.grid._regExtra=4;
		this.grid._presentacionGranTotal = "SI";
		this.grid.subscribirAEvento(this, "eventgridRowDoubleClick", this.grid_eventgridRowDoubleClick);
		this.grid.render();		
	}
	
	btnConsulta3_onClick()
	{
		this.presentador.consultar();
	}
	
	 get id()
		{
			return $('#idInput').val();
		}
		
		get consecutivo()
		{
			return $('#consecutivoInput').val();
		}
		
		get numero()
		{
			return $('#numeroInput').val();
		}

		get descripcion()
		{
			return $('#descripcionInput').val();
		}
		
		get poblacion()
		{
			return $('#poblacionInput').val();
		}
		
		get municipio()
		{
			return $('#municipioInput').val();
		}
	
		get estado()
		{
			return $('#estadoInput').val();
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
	
	btnAlta3_onClick()
	{
		$('#principal').hide()	
		$('#altaCambioDiv').show();
	}
	
	
	btnGuardar3_onClick()
	{
		this.presentador.insertar();
	}
	
	//campos del formulario
	
	 get id()
		{
			return $('#idInput').val();
		}
		
		get consecutivo()
		{
			return $('#consecutivoInput').val();
		}
		
		get numero()
		{
			return $('#numeroInput').val();
		}

		get descripcion()
		{
			return $('#descripcionInput').val();
		}
		
		get poblacion()
		{
			return $('#poblacionInput').val();
		}
		
		get municipio()
		{
			return $('#municipioInput').val();
		}
	
		get estado()
		{
			return $('#estadoInput').val();
		}
  
	
	set resultado(valor)
	{
		alert(valor);
	}
}
var vistas = new PortableVista();
