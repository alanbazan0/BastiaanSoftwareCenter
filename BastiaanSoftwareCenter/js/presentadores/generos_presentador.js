class GenerosPresentador
{
	constructor(vista)
	 {
		this.vista = vista; 
	 }
	 
	 consultar()
	 {
		 var repositorio = new GenerosRepositorio(this);		
		 repositorio.consultar(this,this.consultarResultado,this.vista.nombre,this.vista.nombreSegundo,this.vista.apellidoPaterno);
	 }
	 
	 consultarResultado(resultado)
	 {
		// this.vista.setDatos(resultado);
		 this.vista.datos = resultado;
	 }
	 
	 insertar()
	 {
		 var repositorio = new GenerosRepositorio(this);	
		 
		 
		 repositorio.insertar(this,this.insertarResultado,this.vista.genero);
		// repositorio.insertar(this,this.insertarResultado,this.vista.primerNombre, this.vista.segundoNombre, this.vista.primerApellido,this.vista.segundoApellido,this.vista.rfcDetalle,this.vista.nssDetalle,this.vista.curpDetalle,this.vista.codigoPostal,this.vista.numeroExterior, this.vista.numeroInterior,this.vista.calle,this.vista.colonia,this.vista.estado,this.vista.pais,this.vista.correo);
	 }
	 
	 insertarResultado(resultado)
	 {
		if( resultado == "0")		
			this.vista.mostrarMensaje("Error","Error al agregar genero.");
		else	
		{
			this.vista.mostrarMensaje("Aviso","genero guardado exitosamente: " + resultado);
			this.vista.salirDetalle();
			this.consultar();
		}
			
			
			
	 }
	 
	
	 
	 actualizar()
	 {
		 var repositorio = new GenerosRepositorio(this);	
		
		 repositorio.actualizar(this,this.actualizarResultado,this.vista.genero);

		 // repositorio.actualizar(this,this.actualizarResultado,this.vista.idCliente,this.vista.primerNombre, this.vista.segundoNombre, this.vista.primerApellido,this.vista.segundoApellido,this.vista.rfcDetalle,this.vista.nssDetalle,this.vista.curpDetalle,this.vista.codigoPostal,this.vista.numeroExterior, this.vista.numeroInterior,this.vista.calle,this.vista.colonia,this.vista.estado,this.vista.pais,this.vista.correo);
	 }
	 
	 actualizarResultado(resultado)
    {
		if( resultado == "0")		
			this.vista.mostrarMensaje("Error","Error al alctualizar resultado.");
		else	
		{
			this.vista.mostrarMensaje("Aviso","genero guardado exitosamente. Id: " + resultado);
			this.vista.salirDetalle();
			this.consultar();
		}
					
			
	 }
	 
	 
	 consultarPorId()
	 {
		 var repositorio = new GenerosRepositorio(this);		
		 repositorio.consultarPorId(this,this.consultarPorIdResultado,this.vista.nombre);
	 }
	 
	 consultarPorIdResultado(resultado)
	 {		
		 this.vista.genero = resultado;
	 }
	 
	 eliminar()
	 {
		 var repositorio = new GenerosRepositorio(this);		
		 repositorio.eliminar(this,this.eliminarResultado,this.vista.nombre);
	 }
	 
	 eliminarResultado(resultado)
	 {
		if( resultado == "error" || resultado == false || resultado == "NO_OK"){
			this.vista.resultado ="Error al eliminar genero.";
			}else{
				this.vista.resultado = "genero eliminado exitosamente. ";
			}
	 }
	 
}