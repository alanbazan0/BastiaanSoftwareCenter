<?php
namespace php\repositorios;

use php\interfaces\IUsuariosRepositorio;
use php\modelos\Usuario;


include "../interfaces/IUsuariosRepositorio.php";
include "../modelos/Usuario.php";


class UsuariosRepositorio implements IUsuariosRepositorio
{    
    protected $conexion;   
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }
    
    public function insertar(Usuario $usuario)
    {
        
    }

    public function eliminar(Usuario $usuario)
    {
        
    }

    public function actualizar(Usuario $usuario)
    {
        
    }

    public function consultar($nombreUsuario, $contrasena)
    {
        $usuario = null;
        $consulta = "SELECT IBDAGENTECNUSERID nombreUsuario, IBDAGENTEPASS contrasena, IBDAGENTENOM nombre " .
                    "FROM IBDAGENTE " .
                    "WHERE IBDAGENTECNUSERID = ? AND IBDAGENTEPASS = ?";
        if($sentencia = $this->conexion->prepare($consulta))
        {
            $sentencia->bind_param("ss",$nombreUsuario,$contrasena);
            if($sentencia->execute())
            {
                
                if ($sentencia->bind_result($nombreUsuario, $contrasena, $nombre))
                {           
                    
                    if ($row = $sentencia->fetch())
                    {
                        $usuario = new Usuario();
                        $usuario->nombreUsuario = utf8_encode($nombreUsuario);
                        $usuario->contrasena = utf8_encode($contrasena);
                        $usuario->nombre = utf8_encode($nombre);                  
                    }
                }
              
            }
           
        }       
        return $usuario;
    }    
    
}