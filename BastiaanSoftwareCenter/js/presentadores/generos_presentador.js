class GenerosPresentador
{
	 constructor(vistas)
	 {
		this.vistas = vistas; 
	 }
	 
	 consultar()
	 {
		 var repositorio = new GenerosRepositorio(this);		
		 repositorio.consultar(this,this.consultarResultado,this.vistas.id,this.vistas.gcorto,this.vistas.glargo);
	 }

	 consultarResultado(resultado)
	 {
		// this.vistas.setDatos(resultado);
		 this.vistas.datos = resultado;
	 }
	 
	 insertar()
	 {
		 var repositorio = new GenerosRepositorio(this);		
		// repositorio.insertar(this,this.insertarResultado,this.vistas.id, this.vistas.gcorto, this.vistas.glargo);
			
	 }
	 
	 actualizar()
 	 {
		 var repositorio = new GenerosRepositorio(this);	
		
		 repositorio.insertar(this,this.actualizarResultado,this.vista.id);
		// repositorio.actualizar(this,this.actualizarResultado,this.vista.idCliente,this.vista.primerNombre, this.vista.segundoNombre, this.vista.primerApellido,this.vista.segundoApellido,this.vista.rfcDetalle,this.vista.nssDetalle,this.vista.curpDetalle,this.vista.codigoPostal,this.vista.numeroExterior, this.vista.numeroInterior,this.vista.calle,this.vista.colonia,this.vista.estado,this.vista.pais,this.vista.correo);
 	 }
	 
	 insertarResultado(resultado)
	 {
		if( resultado == "error" || resultado == false || resultado == "NO_OK"){
			this.vistas.resultado ="Error al agregar portables.";
			}else{
				this.vistas.resultado = "Generos guardado exitosamente. ";
			}
	 }
}	 