class PortablesRepositorio 
{	
	constructor()
	{
		
	}
	
	consultar(contexto,functionRetorno, id, estado, municipio)
	{		
		this.contexto = contexto;
		this.functionRetorno = functionRetorno;
		
		var parametros;
		parametros = "accion=consultar";
		parametros += "&id=" + id;
		parametros += "&municipio=" + municipio;
		parametros += "&estado=" + estado;
		
		
		var contextHandler = new AjaxContextHandler();
		var host = window.location.origin + "/BastiaanSoftwareCenter";	
		var ai = new Ajaxv2(host +"/php/repositorios/Portables.php", this, this.consultarResultado, "POST", parametros, contextHandler);		
		contextHandler.AddAjaxv2Object(ai); 		
		ai.GetPost(true);
	}
	
	consultarResultado(resultado)
	{
		var datos = JSON.parse(resultado);
		this.functionRetorno.call(this.contexto,JSON.parse(resultado));
	}
	
	
	insertar(contexto,functionRetorno,nopostal,id,asentamiento,municipio,estado,ciudad)
	{				
		this.contexto = contexto;
		this.functionRetorno = functionRetorno;
		
		var parametros;
		parametros = "accion=insertar";
		parametros += "&id=" + id;
		parametros += "&consecutivo=" + consecutivo;	
		parametros += "&numero=" + numero;
		parametros += "&descripcion=" + descripcion;
		parametros += "&poblacion=" + poblacion;
		parametros += "&municipio=" + municipio;
		parametros += "&estado=" + estado;
		var contextHandler = new AjaxContextHandler();
		var host = window.location.origin + "/BastiaanSoftwareCenter";	
		var ai = new Ajaxv2(host +"/php/repositorios/Portables.php", this, this.insertarResultado, "POST", parametros, contextHandler);		
		contextHandler.AddAjaxv2Object(ai); 		
		ai.GetPost(true);
	}
	
	insertarResultado(resultado)
	{
		var datos = JSON.parse(resultado);
		this.functionRetorno.call(this.contexto,JSON.parse(resultado));
	}
	

}