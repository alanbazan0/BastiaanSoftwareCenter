class ClientesRepositorio 
{	
	constructor()
	{
		
	}
	
	consultar(CallBackContext,CallBackFunction, nombreCompleto)
	{		
		this.CallBackContext = CallBackContext;
		this.CallBackFunction = CallBackFunction;
		
		var parametros;
		parametros = "accion=consultar";
		parametros+= "&nombreCompleto=" + nombreCompleto;
		
		
		var contextHandler = new AjaxContextHandler();
		var host = window.location.origin + "/BastiaanSoftwareCenter";
		//var ai = new Ajaxv2("http://127.0.0.1:7000/BastiaanSoftwareCenter/php/repositorios/clientes.php", this, this.consultarResultado, "POST", parametros, contextHandler);		
		var ai = new Ajaxv2(host +"/php/repositorios/Clientes.php", this, this.consultarResultado, "POST", parametros, contextHandler);		
		contextHandler.AddAjaxv2Object(ai); 		
		ai.GetPost(true);
	}
	
	consultarResultado(resultado)
	{
		var datos = JSON.parse(resultado);
		this.CallBackFunction.call(this.CallBackContext,JSON.parse(resultado));
	}
	

}