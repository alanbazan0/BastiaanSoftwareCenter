class ClientesRepositorio 
{	
	constructor()
	{
		
	}
	
	insertar(contexto,functionRetorno, cliente)
	{		
		this.contexto = contexto;
		this.functionRetorno = functionRetorno;
		
		var parametros;
		parametros = "accion=insertar";
		parametros += "&cliente=" + encodeURIComponent(JSON.stringify(cliente));
		
		
		
		var contextHandler = new AjaxContextHandler();
		var host = window.location.origin + "/BastiaanSoftwareCenter";	
		var ai = new Ajaxv2(host +"/php/repositorios/Clientes.php", this, this.insertarResultado, "POST", parametros, contextHandler);		
		contextHandler.AddAjaxv2Object(ai); 		
		ai.GetPost(true);
	}
	
	insertarResultado(resultado)
	{
		var datos = JSON.parse(resultado);
		this.functionRetorno.call(this.contexto,JSON.parse(resultado));
	}
	
	
	consultar(contexto,functionRetorno, nombreCompleto, rfc, curp)
	{		
		this.contexto = contexto;
		this.functionRetorno = functionRetorno;
		
		var parametros;
		parametros = "accion=consultar";
		parametros += "&nombreCompleto=" + nombreCompleto;
		parametros += "&rfc=" + rfc;
		parametros += "&curp=" + curp;
		
		
		var contextHandler = new AjaxContextHandler();
		var host = window.location.origin + "/BastiaanSoftwareCenter";	
		var ai = new Ajaxv2(host +"/php/repositorios/Clientes.php", this, this.consultarResultado, "POST", parametros, contextHandler);		
		contextHandler.AddAjaxv2Object(ai); 		
		ai.GetPost(true);
	}
	
	consultarResultado(resultado)
	{
		var datos = JSON.parse(resultado);
		this.functionRetorno.call(this.contexto,JSON.parse(resultado));
	}
	

}