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
	
	
	consultar(contexto,functionRetorno, criteriosSeleccion)
	{		
		this.contexto = contexto;
		this.functionRetorno = functionRetorno;
		
		var parametros;
		parametros = "accion=consultar";
		parametros += "&criteriosSeleccion=" + encodeURIComponent(JSON.stringify(criteriosSeleccion));
		
		
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
	
	/*
	insertar(contexto,functionRetorno,primerNombre, segundoNombre, primerApellido,segundoApellido,rfcDetalle,nssDetalle,curpDetalle,codigoPostal,numeroExterior, numeroInterior,calle,colonia,estado,pais,correo)
	{				
		this.contexto = contexto;
		this.functionRetorno = functionRetorno;
		
		var parametros;
		parametros = "accion=insertar";
		parametros += "&nombre=" + primerNombre;
		parametros += "&nombreSegundo=" + segundoNombre;
		parametros += "&apellidoPaterno=" + primerApellido;
		parametros += "&apellidoMaterno=" + segundoApellido;
		parametros += "&rfc=" + rfcDetalle;
		parametros += "&nss=" + nssDetalle;
		parametros += "&curp=" + curpDetalle;
		parametros += "&cpId=" + codigoPostal;
		parametros += "&numExt=" + numeroExterior;
		parametros += "&numInt=" + numeroInterior;
		parametros += "&calle=" + calle;
		parametros += "&colonia=" + colonia;
		parametros += "&estado=" + estado;
		parametros += "&pais=" + pais;
		parametros += "&correoElectronico=" + correo;		
		var contextHandler = new AjaxContextHandler();
		var host = window.location.origin + "/BastiaanSoftwareCenter";	
		var ai = new Ajaxv2(host +"/php/repositorios/Clientes.php", this, this.insertarResultado, "POST", parametros, contextHandler);		
		contextHandler.AddAjaxv2Object(ai); 		
		ai.GetPost(true);
	}*/
	/*
	insertarResultado(resultado)
	{
		var datos = JSON.parse(resultado);
		this.functionRetorno.call(this.contexto,JSON.parse(resultado));
	}*/
	
	consultarPorId(contexto,functionRetorno, idCliente)
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
	
	actualizar(contexto,functionRetorno,idCliente,primerNombre, segundoNombre, primerApellido,segundoApellido,rfcDetalle,nssDetalle,curpDetalle,codigoPostal,numeroExterior, numeroInterior,calle,colonia,estado,pais,correo)
	{				
		this.contexto = contexto;
		this.functionRetorno = functionRetorno;
		
		var parametros;
		parametros = "accion=actualizar";
		parametros += "&id=" + idCliente;
		parametros += "&nombre=" + primerNombre;
		parametros += "&nombreSegundo=" + segundoNombre;
		parametros += "&apellidoPaterno=" + primerApellido;
		parametros += "&apellidoMaterno=" + segundoApellido;
		parametros += "&rfc=" + rfcDetalle;
		parametros += "&nss=" + nssDetalle;
		parametros += "&curp=" + curpDetalle;
		parametros += "&cpId=" + codigoPostal;
		parametros += "&numExt=" + numeroExterior;
		parametros += "&numInt=" + numeroInterior;
		parametros += "&calle=" + calle;
		parametros += "&colonia=" + colonia;
		parametros += "&estado=" + estado;
		parametros += "&pais=" + pais;
		parametros += "&correoElectronico=" + correo;		
		var contextHandler = new AjaxContextHandler();
		var host = window.location.origin + "/BastiaanSoftwareCenter";	
		var ai = new Ajaxv2(host +"/php/repositorios/Clientes.php", this, this.actualizarResultado, "POST", parametros, contextHandler);		
		contextHandler.AddAjaxv2Object(ai); 		
		ai.GetPost(true);
	}
	
	actualizarResultado(resultado) 
	{
		var datos = JSON.parse(resultado);
		this.functionRetorno.call(this.contexto,JSON.parse(resultado));
	}
	
	eliminar(contexto,functionRetorno,idCliente)
	{				
		this.contexto = contexto;
		this.functionRetorno = functionRetorno;
		
		var parametros;
		parametros = "accion=eliminar";
		parametros += "&id=" + idCliente;		
		var contextHandler = new AjaxContextHandler();
		var host = window.location.origin + "/BastiaanSoftwareCenter";	
		var ai = new Ajaxv2(host +"/php/repositorios/Clientes.php", this, this.eliminarResultado, "POST", parametros, contextHandler);		
		contextHandler.AddAjaxv2Object(ai); 		
		ai.GetPost(true);
	}
	
	eliminarResultado(resultado)
	{
		var datos = JSON.parse(resultado);
		this.functionRetorno.call(this.contexto,JSON.parse(resultado));
	}
	

}