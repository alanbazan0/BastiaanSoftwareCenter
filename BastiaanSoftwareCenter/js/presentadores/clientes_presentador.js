class ClientesPresentador
{
	 constructor(vista)
	 {
		this.vista = vista; 
	 }
	 
	 consultar()
	 {
		 var repositorio = new ClientesRepositorio(this);		
		 repositorio.consultar(this,this.consultarResultado,this.vista.criteriosSeleccion);
	 }
	 
	 consultarResultado(resultado)
	 {
		if(resultado.mensajeError=="")
			this.vista.datos = resultado.valor;
		else
			this.vista.mostrarMensaje("Error",resultado.mensajeError);
	 }
	 
	
	 insertar()
	 {
		 var repositorio = new ClientesRepositorio(this);			 
		 repositorio.insertar(this,this.insertarResultado,this.vista.cliente);	
	 }
	 
	 insertarResultado(resultado)
	 {
		if( resultado == "0")		
			this.vista.mostrarMensaje("Error","Error al agregar cliente.");
		else	
		{
			this.vista.mostrarMensaje("Aviso","Cliente guardado exitosamente. Id: " + resultado);
			this.vista.salirFormulario();
			this.consultar();
		}	
			
			
	 }
	 
	
	 
	 actualizar()
	 {
		 var repositorio = new ClientesRepositorio(this);	
		
		 repositorio.insertar(this,this.actualizarResultado,this.vista.cliente);
		// repositorio.actualizar(this,this.actualizarResultado,this.vista.idCliente,this.vista.primerNombre, this.vista.segundoNombre, this.vista.primerApellido,this.vista.segundoApellido,this.vista.rfcDetalle,this.vista.nssDetalle,this.vista.curpDetalle,this.vista.codigoPostal,this.vista.numeroExterior, this.vista.numeroInterior,this.vista.calle,this.vista.colonia,this.vista.estado,this.vista.pais,this.vista.correo);
	 }
	 
	 actualizarResultado(resultado)
	 {
		if( resultado == "error" || resultado == false || resultado == "NO_OK"){
			this.vista.resultado ="Error al agregar cliente.";
			}else{
				this.vista.resultado = "Cliente actualizado exitosamente. ";
			}
	 }
	   
	 consultarPorId()
	 {
		 var repositorio = new ClientesRepositorio(this);		
		 repositorio.consultarPorId(this,this.consultarPorIdResultado,this.vista.idCliente);
	 }
	 
	 consultarPorIdResultado(resultado)
	 {		
		 this.vista.cliente = resultado;
	 }
	 
	 eliminar()
	 {
		 var repositorio = new ClientesRepositorio(this);		
		 repositorio.eliminar(this,this.eliminarResultado,this.vista.idSeleccionado);		
	 }
	 
	 eliminarResultado(resultado)
	 {
		if(resultado.mensajeError=="")
		{
			this.vista.mostrarMensaje("Aviso", "El registro ha sido eliminado correctamente.");
			this.consultar();
		}
		else
			this.vista.mostrarMensaje("Error","Ocurrió un error al eliminar el registro." + resultado.mensajeError);		
	 }
	 
}