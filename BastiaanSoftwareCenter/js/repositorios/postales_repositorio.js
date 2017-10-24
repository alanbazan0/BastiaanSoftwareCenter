class PostalesRepositorio 
{	
	constructor()
	{
		
	}
	
	insertar(contexto,functionRetorno, id)
	{				
		this.contexto = contexto;
		this.functionRetorno = functionRetorno;
		
		var parametros;
		parametros += "accion=insertar" + encodeURIComponent(JSON.stringify(id)) ;
		
		var contextHandler = new AjaxContextHandler();
		var host = window.location.origin + "/BastiaanSoftwareCenter";	
		var ai = new Ajaxv2(host +"/php/repositorios/Postales.php", this, this.insertarResultado, "POST", parametros, contextHandler);		
		contextHandler.AddAjaxv2Object(ai); 		
		ai.GetPost(true);
	}
	
	insertarResultado(resultado)
	{
		var datos = JSON.parse(resultado);
		this.functionRetorno.call(this.contexto,JSON.parse(resultado));
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
		var ai = new Ajaxv2(host +"/php/repositorios/Postales.php", this, this.consultarResultado, "POST", parametros, contextHandler);		
		contextHandler.AddAjaxv2Object(ai); 		
		ai.GetPost(true);
	}
	
	consultarResultado(resultado)
	{
		var datos = JSON.parse(resultado);
		this.functionRetorno.call(this.contexto,JSON.parse(resultado));
	}
	

	insertar(contexto,functionRetorno,nopostal,asentamiento,municipio,estado,cuidad)
	{				
		this.contexto = contexto;
		this.functionRetorno = functionRetorno;
		
		var parametros;
		parametros = "accion=insertar";
		parametros += "&nopostal=" + nopostal;
		parametros += "&id=" + id;
		parametros += "&asentamiento=" + asentamiento;
		parametros += "&municipio=" + municipio;
		parametros += "&estado=" + estado;
		parametros += "&ciudad=" + ciudad;
		var contextHandler = new AjaxContextHandler();
		var host = window.location.origin + "/BastiaanSoftwareCenter";	
		var ai = new Ajaxv2(host +"/php/repositorios/Postales.php", this, this.insertarResultado, "POST", parametros, contextHandler);		
		contextHandler.AddAjaxv2Object(ai); 		
		ai.GetPost(true);
	}
	
	insertarResultado(resultado)
	{
		var datos = JSON.parse(resultado);
		this.functionRetorno.call(this.contexto,JSON.parse(resultado));
	}
	
	consultarPorId(contexto,functionRetorno, id)
	{		
		this.contexto = contexto;
		this.functionRetorno = functionRetorno;
		
		var parametros;
		parametros = "accion=consultarPorId";
		parametros += "&id=" + idCliente;
		var contextHandler = new AjaxContextHandler();
		var host = window.location.origin + "/BastiaanSoftwareCenter";	
		var ai = new Ajaxv2(host +"/php/repositorios/Clientes.php", this, this.consultarPorIdResultado, "POST", parametros, contextHandler);		
		contextHandler.AddAjaxv2Object(ai); 		
		ai.GetPost(true);
	}
	
	consultarPorIdResultado(resultado)
	{
		var datos = JSON.parse(resultado);
		this.functionRetorno.call(this.contexto,JSON.parse(resultado));
	}
	
	actualizar(contexto,functionRetorno,id, nopostal, asentamiento, municipio, estado, ciudad)
	{				
		this.contexto = contexto;
		this.functionRetorno = functionRetorno;
		
		var parametros;
		parametros = "accion=actualizar";
		parametros += "&nopostal=" + nopostal;
		parametros += "&id=" + id;
		parametros += "&asentamiento=" + asentamiento;
		parametros += "&municipio=" + municipio;
		parametros += "&estado=" + estado;
		parametros += "&ciudad=" + ciudad;	
		var contextHandler = new AjaxContextHandler();
		var host = window.location.origin + "/BastiaanSoftwareCenter";	
		var ai = new Ajaxv2(host +"/php/repositorios/Postal.php", this, this.actualizarResultado, "POST", parametros, contextHandler);		
		contextHandler.AddAjaxv2Object(ai); 		
		ai.GetPost(true);
	}
	
	actualizarResultado(resultado) 
	{
		var datos = JSON.parse(resultado);
		this.functionRetorno.call(this.contexto,JSON.parse(resultado));
	}
	
	eliminar(contexto,functionRetorno,id)
	{				
		this.contexto = contexto;
		this.functionRetorno = functionRetorno;
		
		var parametros;
		parametros = "accion=eliminar";
		parametros += "&id=" + idCliente;		
		var contextHandler = new AjaxContextHandler();
		var host = window.location.origin + "/BastiaanSoftwareCenter";	
		var ai = new Ajaxv2(host +"/php/repositorios/Postales.php", this, this.eliminarResultado, "POST", parametros, contextHandler);		
		contextHandler.AddAjaxv2Object(ai); 		
		ai.GetPost(true);
	}
	
	eliminarResultado(resultado)
	{
		var datos = JSON.parse(resultado);
		this.functionRetorno.call(this.contexto,JSON.parse(resultado));
	}
	

}