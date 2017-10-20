class PortablePresentador
{
	 constructor(vistas)
	 {
		this.vistas = vistas; 
	 }
	 
	 consultar()
	 {
		 var repositorio = new PortablesRepositorio(this);		
		 repositorio.consultar(this,this.consultarResultado,this.vistas.id,this.vistas.estado,this.vistas.municipio);
	 }

	 
	 consultarResultado(resultado)
	 {
		// this.vistas.setDatos(resultado);
		 this.vistas.datos = resultado;
	 }
	 
	 insertar()
	 {
		 var repositorio = new PortablesRepositorio(this);		
		 repositorio.insertar(this,this.insertarResultado,this.vistas.id, this.vistas.consecutivo, this.vistas.numero, this.vistas.descripcion, this.vistas.poblacion, this.vistas.municipio, this.vistas.estado);
			
	 }
	 
	 insertarResultado(resultado)
	 {
		if( resultado == "error" || resultado == false || resultado == "NO_OK"){
			this.vistas.resultado ="Error al agregar portables.";
			}else{
				this.vistas.resultado = "Portables guardado exitosamente. ";
			}
	 }
}	 