class ClientesRepositorio extends ObjetoBase
{	
	constructor(origen)
	{
		this.origen = origen;
	}
	
	consultar(funcion, nombreCompleto)
	{		
		this.funcionConsultar = funcion;
		var parametros;
		parametros = "accion=consultar";
		parametros+= "&nombreCompleto=" + nombreCompleto;
		
		
		var contextHandler = new AjaxContextHandler();
		
		var ai = new Ajaxv2("http://127.0.0.1:7000/BastiaanSoftwareCenter/php/repositorios/clientes.php", this, this.consultarResultado, "POST", parametros, contextHandler);		
		//var ai = new Ajaxv2(".../.../php/repositorios/clientes.php", this, this.consultarResultado, "POST", parametros, contextHandler);		
		contextHandler.AddAjaxv2Object(ai); 		
		ai.GetPost(true);
	}
	
	consultarResultado(resultado)
	{		
		this.funcionConsultar.call(this,resultado)
	}
	

}