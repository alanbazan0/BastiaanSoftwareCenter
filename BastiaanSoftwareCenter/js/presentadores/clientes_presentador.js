class ClientesPresentador
{
	 constructor(vista)
	 {
		this.vista = vista; 
	 }
	 
	 consultar()
	 {
		 var repositorio = new ClientesRepositorio(this);		
		 repositorio.consultar(this,this.consultarResultado,this.vista.nombreCompleto,this.vista.rfc,this.vista.curp);
	 }
	 
	 insertar()
	 {
		 var repositorio = new ClientesRepositorio(this);		
		 var cliente = 
		 {				    
			 id:this.vista.idDetalle,
			 nombre:this.vista.nombreDetalle,
			 nombreSegundo:"",
			 apellidoPaterno:"",
			 apellidoMaterno:"",
			 nombreCompleto:"",
			 rfc:"",
			 nss:"",
			 curp:"",
			 cpId:"",
			 numExt:"",
			 numInt:"",
			 calle:"",
			 colonia:"",
			 estado:"",
			 pais:"",
			 direccion:"",
			 correoElectronico:""
		 };
		 repositorio.insertar(this,this.insertarResultado,cliente);
	 }
	 
	 consultarResultado(resultado)
	 {
		// this.vista.setDatos(resultado);
		 this.vista.datos = resultado;
	 }
	 
	 insertarResultado(resultado)
	 {
		 if(resultado)
		 {
			 this.vista.salirDetalle();
		 }
		 else
		 {
			 this.vista.mostrarMensaje("ocurrió un error");
		 }
	 }
	
	 
}