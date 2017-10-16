class ClientesRepositorio
{	
	consultar(id, nombre, apellidoPaterno)
	{		
		var parametros;
		parametros = "accion=consultar";
		parametros+= "&id=" + id;
		parametros+= "&nombre=" + nombre;
		parametros+= "&apellidoPaterno=" + apellidoPaterno;
		
		var contextHandler = new AjaxContextHandler();
		var ai = new Ajaxv2(".../php/repositorios/Clientes.jsp", this, this.consultarResultado, "POST", parametros, contextHandler);		
		contextHandler.AddAjaxv2Object(ai); 		
		ai.GetPost(true);
	}
	
	consultarResultado(resultado)
	{
		
	}
}