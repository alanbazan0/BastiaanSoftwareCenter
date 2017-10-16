class ClientesPresentador
{
	 constructor(vista)
	 {
		this.vista = vista; 
	 }
	 
	 consultar()
	 {
		 var repositorio = new ClientesRepositorio(this);		
		 repositorio.consultar(this.consultarResultado,this.vista.getNombreCompleto());
	 }
	 
	 consultarResultado(resultado)
	 {
		 this.origen.vista.setDatos(resultado);
	 }
	 
	 
}