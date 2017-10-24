class GenerosRepositorio 
{	
	constructor()
	{
		
	}
	
	consultar(contexto,functionRetorno, id, gcorto, glargo)
	{		
		this.contexto = contexto;
		this.functionRetorno = functionRetorno;
		
		var parametros;
		parametros = "accion=consultar";
		parametros += "&id=" + id;
		parametros += "&gcorto=" + gcorto;
		parametros += "&glargo=" + glargo;
		
		
		var contextHandler = new AjaxContextHandler();
		var host = window.location.origin + "/BastiaanSoftwareCenter";	
		var ai = new Ajaxv2(host +"/php/repositorios/Generos.php", this, this.consultarResultado, "POST", parametros, contextHandler);		
		contextHandler.AddAjaxv2Object(ai); 		
		ai.GetPost(true);
	}
	
	consultarResultado(resultado)
	{
		var datos = JSON.parse(resultado);
		this.functionRetorno.call(this.contexto,JSON.parse(resultado));
	}
	
	
	insertar(contexto,functionRetorno, id,gcorto,glargo)
	{				
		this.contexto = contexto;
		this.functionRetorno = functionRetorno;
		
		var parametros;
		parametros = "accion=insertar";
		parametros += "&id=" + id;
		parametros += "&gcorto=" + gcorto;
		parametros += "&glargo=" + glargo;
		var contextHandler = new AjaxContextHandler();
		var host = window.location.origin + "/BastiaanSoftwareCenter";	
		var ai = new Ajaxv2(host +"/php/repositorios/Generos.php", this, this.insertarResultado, "POST", parametros, contextHandler);		
		contextHandler.AddAjaxv2Object(ai); 		
		ai.GetPost(true);
	}
	
	insertarResultado(resultado)
	{
		var datos = JSON.parse(resultado);
		this.functionRetorno.call(this.contexto,JSON.parse(resultado));
	}
	

}