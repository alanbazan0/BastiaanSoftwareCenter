<?php
namespace php\repositorios;

use Exception;
use php\interfaces\IAsteriskRepositorio;
use php\modelos\Postal;
use php\modelos\Resultado;


include "../interfaces/IAsteriskRepositorio.php";
include "../modelos/Postal.php";
include "../clases/Resultado.php";

class AsteriskRepositorio implements IAsteriskRepositorio
{
    protected $conexion;
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }
    
    public function calcularId()
    {   
        $resultado = new Resultado();
        $consulta =  "SELECT MAX(IFNULL(BTCPOSTALIDN,0))+1 AS id FROM BSTNTRN.BTCPOSTAL";
        if($sentencia = $this->conexion->prepare($consulta))
        {        
            if($sentencia->execute())
            {
                if ($sentencia->bind_result($id))
                {
                    if($sentencia->fetch())
                    {
                        $resultado->valor = $id;
                    }                   
                    else
                        $resultado->mensajeError = "No se encontró ningún resultado";
                }
                else
                    $resultado->mensajeError = "Falló el enlace del resultado";
            }
            else
                $resultado->mensajeError = "Falló la ejecución (" . $this->conexion->errno . ") " . $this->conexion->error;                       
        }
        else
            $resultado->mensajeError = "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error; 
        return $resultado;
    }
    
        
    public function consultarIdLlamada($extension)
    {     
        $resultado = new Resultado();

        $consulta =   "select llamadasEntrantesNum 'TELEFONO', llamadasEntrantesId 'IDLLAMADA' " 
        . " from asteriskcdrdb.llamadasEntrantes " 
        . " where cast( llamadasEntrantesfecha as date) = curdate() and llamadasEntrantesExt = ? " 
        . " order by llamadasEntrantesIdn desc limit 1";
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("s",$extension))
            {
                if($sentencia->execute())
                {                
                    if ($sentencia->bind_result($IDLLAMADA)  )
                    {  
                        $resultado->valor = $IDLLAMADA; 
                    }           
                    else
                        $resultado->mensajeError = "Falló el enlace del resultado.";       
                }       
                else 
                    $resultado->mensajeError = "Falló la ejecución (" . $this->conexion->errno . ") " . $this->conexion->error;                       
            }
            else
                $resultado->mensajeError = "Falló el enlace de parámetros";    
        }
        else                 
            $resultado->mensajeError = "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;        
        
       
        return $resultado;     
    }    

}

