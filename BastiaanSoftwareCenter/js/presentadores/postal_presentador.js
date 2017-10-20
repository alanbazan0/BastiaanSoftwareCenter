class PostalPresentador
{
	 constructor(vistas)
	 {
		this.vistas = vistas; 
	 }
	 
	 consultar()
	 {
		 var repositorio = new PostalesRepositorio(this);		
		 repositorio.consultar(this,this.consultarResultado,this.vistas.id,this.vistas.estado,this.vistas.municipio);
	 }
	 
	 consultarResultado(resultado)
	 {
		// this.vistas.setDatos(resultado);
		 this.vistas.datos = resultado;
	 }
	 
	 insertar()
	 {
		 var repositorio = new PostalesRepositorio(this);		
		 repositorio.insertar(this,this.insertarResultado,this.vistas.id, this.vistas.asentamiento, this.vistas.municipio,this.vistas.estado,this.vistas.cuidad,this.vistas.nopostal);
	 }
	 
	 insertarResultado(resultado)
	 {
		if( resultado == "error" || resultado == false || resultado == "NO_OK"){
			this.vistas.resultado ="Error al agregar postal.";
			}else{
				this.vistas.resultado = "Postal guardado exitosamente. ";
			}
	 }
	 
}