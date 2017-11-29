class MovimientosRepositorio 
{	
	constructor()
	{
		
	}
	insertar(contexto,functionRetorno, movimiento)
	{		
		this.contexto = contexto;
		this.functionRetorno = functionRetorno;
		
	
		
		var parametros;
		parametros = "accion=insertar";
		parametros += "&movimiento=" + encodeURIComponent(JSON.stringify(movimiento));	
		
		var contextHandler = new AjaxContextHandler();
		var host = window.location.origin + "/BastiaanSoftwareCenter";	
		var ai = new Ajaxv2(host +"/php/repositorios/Movimientos.php", this, this.insertarResultado, "POST", parametros, contextHandler);		
		contextHandler.AddAjaxv2Object(ai); 		
		ai.GetPost(true);
	}
	
	insertarResultado(resultado)
	{
		var datos = JSON.parse(resultado);
		this.functionRetorno.call(this.contexto,JSON.parse(resultado));
	}
	
	
	/* Usuarios */ 
	consultarPorUsuario(contexto,functionRetorno, criteriosUsuarios)
	{		
		
		this.contexto = contexto;
		this.functionRetorno = functionRetorno;
		var parametros;
		parametros = "accion=consultarPorUsuario";
        parametros += "&criteriosUsuarios=" +  encodeURIComponent(JSON.stringify(criteriosUsuarios));
		var contextHandler = new AjaxContextHandler();
		var host = window.location.origin + "/BastiaanSoftwareCenter";	
		var ai = new Ajaxv2(host +"/php/repositorios/Movimientos.php", this, this.consultarPorUsuarioResultado, "POST", parametros, contextHandler);		
		contextHandler.AddAjaxv2Object(ai); 		
		ai.GetPost(true);
	}
	consultarPorUsuarioResultado(resultado)
	{
		var datosUsuarios = JSON.parse(resultado);
		this.functionRetorno.call(this.contexto,JSON.parse(resultado));
	}	
 /*  */
	
	

	consultar(contexto,functionRetorno, criteriosSeleccion)
	{		
		this.contexto = contexto;
		this.functionRetorno = functionRetorno;
		
		var parametros;
		parametros = "accion=consultar";
		parametros += "&criteriosSeleccion=" + encodeURIComponent(JSON.stringify(criteriosSeleccion));
		
		
		var contextHandler = new AjaxContextHandler();
		var host = window.location.origin + "/BastiaanSoftwareCenter";	
		var ai = new Ajaxv2(host +"/php/repositorios/Movimientos.php", this, this.consultarResultado, "POST", parametros, contextHandler);		
		contextHandler.AddAjaxv2Object(ai); 		
		ai.GetPost(true);
	}
	
	consultarResultado(resultado)
	{
		var datos = JSON.parse(resultado);
		this.functionRetorno.call(this.contexto,JSON.parse(resultado));
	}
	
	
	consultarPorReceso(contexto,functionRetorno, criteriosRecesos)
	{		
		this.contexto = contexto;
		this.functionRetorno = functionRetorno;
		var parametros;
		parametros = "accion=consultarPorReceso";
		var contextHandler = new AjaxContextHandler();
		var host = window.location.origin + "/BastiaanSoftwareCenter";	
		var ai = new Ajaxv2(host +"/php/repositorios/Movimientos.php", this, this.consultarPorRecesoResultado, "POST", parametros, contextHandler);		
		contextHandler.AddAjaxv2Object(ai); 		
		ai.GetPost(true);
	}
	consultarPorRecesoResultado(resultado)
	{
		var datos = JSON.parse(resultado);
		this.functionRetorno.call(this.contexto,JSON.parse(resultado));
	}	
	
	actualizar(contexto,functionRetorno, movimiento)
	{		
		this.contexto = contexto;
		this.functionRetorno = functionRetorno;
		
		var parametros;
		parametros = "accion=actualizar";
		parametros += "&movimiento=" + encodeURIComponent(JSON.stringify(movimiento));	
		
		var contextHandler = new AjaxContextHandler();
		var host = window.location.origin + "/BastiaanSoftwareCenter";	
		var ai = new Ajaxv2(host +"/php/repositorios/Movimientos.php", this, this.actualizarResultado, "POST", parametros, contextHandler);		
		contextHandler.AddAjaxv2Object(ai); 		
		ai.GetPost(true);
	}
	
	actualizarResultado(resultado)
	{
		var datos = JSON.parse(resultado);
		this.functionRetorno.call(this.contexto,JSON.parse(resultado));
	}
	
	
	
	consultarPorLlaves(contexto,functionRetorno, llaves)
	{		
		this.contexto = contexto;
		this.functionRetorno = functionRetorno;
		
		var parametros;
		parametros = "accion=consultarPorLlaves";
		parametros += "&llaves=" + encodeURIComponent(JSON.stringify(llaves));
		var contextHandler = new AjaxContextHandler();
		var host = window.location.origin + "/BastiaanSoftwareCenter";	
		var ai = new Ajaxv2(host +"/php/repositorios/Movimientos.php", this, this.consultarPorLlavesResultado, "POST", parametros, contextHandler);		
		contextHandler.AddAjaxv2Object(ai); 		
		ai.GetPost(true);
	}
	
	consultarPorLlavesResultado(resultado)
	{
		var datos = JSON.parse(resultado);
		this.functionRetorno.call(this.contexto,JSON.parse(resultado));
	}
	
	
	eliminar(contexto,functionRetorno,llaves)
	{				
		this.contexto = contexto;
		this.functionRetorno = functionRetorno;
		
		var parametros;
		parametros = "accion=eliminar";
		parametros += "&llaves=" + encodeURIComponent(JSON.stringify(llaves));
		var contextHandler = new AjaxContextHandler();
		var host = window.location.origin + "/BastiaanSoftwareCenter";	
		var ai = new Ajaxv2(host +"/php/repositorios/Movimientos.php", this, this.eliminarResultado, "POST", parametros, contextHandler);		
		contextHandler.AddAjaxv2Object(ai); 		
		ai.GetPost(true);
	}

	eliminarResultado(resultado)
	{
		var datos = JSON.parse(resultado);
		this.functionRetorno.call(this.contexto,JSON.parse(resultado));
	}

}