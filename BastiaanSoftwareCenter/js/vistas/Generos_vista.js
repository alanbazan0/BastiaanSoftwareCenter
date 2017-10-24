 class 	GenerosVista
{		
	constructor()
	{
	
		this.presentador = new GenerosPresentador(this);
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
			{longitud:200, 	titulo:"ID",   	alias:"id", alineacion:"I" }, 
			{longitud:300, 	titulo:"Genero Corto",   alias:"gcorto", alineacion:"I" }, 
			{longitud:400, 	titulo:"Genero Largo",   alias:"glargo", alineacion:"I" }, 
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
		this.grid.subscribirAEvento(this, "eventgridRowDoubleClick", this.grid_eventgridRowDoubleClick);
		this.grid.render();		
	}
	
	btnConsulta4_onClick()
	{
		this.presentador.consultar();
	}
	
	
    btnBaja_onClick()
    { 
	 var answer = confirm("¿Deseas eliminar este genero?")
		    if (answer){
		    $('#idInput').val(this.grid._selectedItem.id)
		    this.presentador.eliminar();
		 }	
	}

	get id()
	{
		return $('#idInput').val();
	}
	
	get gcorto()
	{
		return $('#gcortoInput').val();
	}

	get glargo()
	{
		return $('#glargoInput').val();
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
	
	btnCambio4_onClick()
	{
		if( this.grid._selectedItem!=null){
			$('#principal').hide()	
			$('#altaCambioDiv').show();
			$('#idInput').val(this.grid._selectedItem.id)
			
			
			this.presentador.consultarPorId();
		}else{
			alert("Selecciona Genero para actualizar");
		}		
     }
	
	
	btnAlta4_onClick()
	{
		$('#principal').hide()	
		$('#altaCambioDiv').show();
	}
	
	
	btnGuardar4_onClick()
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
	


	
	 get genero()
	 {
		 var genero = 
		 {				    
			 id:this.idDetalle,
			 gcorto:this.gcortoDetalle,
			 glargo: this.glargoDetalle,
			 id:"",
			 gcorto:"",
			 glargo:"",
		 };
		 return genero;
	 }
	
	

	get id()
	{
		return $('#idInput').val();
	}
	
	get gcorto()
	{
		return $('#gcortoInput').val();
	}

	get glargo()
	{
		return $('#glargoInput').val();
	}
	
	set resultado(valor)
	{
		alert(valor);
	}
}
var vista = new GenerosVista();
