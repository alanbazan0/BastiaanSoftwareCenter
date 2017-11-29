<?php
namespace php\repositorios;

use Exception;
use php\interfaces\IPostalesRepositorio;
use php\modelos\Postal;
use php\modelos\Resultado;


include "../interfaces/IPostalesRepositorio.php";
include "../modelos/Postal.php";
include "../clases/Resultado.php";

class PostalesRepositorio implements IPostalesRepositorio
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
    
    public function insertar(Postal $postal)
    {            
        $resultado =  $this->calcularId();
        if($resultado->mensajeError=="")
        {
            $id = $resultado->valor;
            $consulta = " INSERT INTO BSTNTRN.BTCPOSTAL "
                        . " (BTCPOSTALIDN, "
                        . " BTCPOSTALID, "
                        . " BTCPOSTALASENT, "
                        . " BTCPOSTALMPIO, "
                        . " BTCPOSTALESTADO, "
                        . " BTCPOSTALCIUDAD) "
                        . " VALUE(?,?,?,?,?,?) ";
            if($sentencia = $this->conexion->prepare($consulta))
            {
                if( $sentencia->bind_param("isssss", $id,$postal->nir,                       
                                                 $postal->asentamiento,
                                                 $postal->municipio,
                                                 $postal->estado,
                                                 $postal->ciudad))
                {
                    if(!$sentencia->execute())                
                        $resultado->mensajeError = "Falló la ejecución (" . $this->conexion->errno . ") " . $this->conexion->error;                       
                }
                else
                    $resultado->mensajeError = "Falló el enlace de parámetros";   
            }
            else
                $resultado->mensajeError = "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;   
        }   
        return $resultado;
    }
    
    public function eliminar($llaves)
    {
        $resultado = new Resultado();
        $consulta = " DELETE FROM BSTNTRN.BTCPOSTAL "
                    . "  WHERE BTCPOSTALIDN = ? ";
         if($sentencia = $this->conexion->prepare($consulta))
         {
             if($sentencia->bind_param("i",$llaves->id))
             {
                if($sentencia->execute())     
                {
                    $resultado->valor = $llaves->id;    
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

    public function actualizar(Postal $postal)
    {     
        $resultado = new Resultado();
        $consulta = " UPDATE BSTNTRN.BTCPOSTAL SET"
                    . " BTCPOSTALID = ?, "
                    . " BTCPOSTALASENT= ?, "
                    . " BTCPOSTALMPIO= ?, "
                    . " BTCPOSTALESTADO= ?, "
                    . " BTCPOSTALCIUDAD= ? "
                    . " WHERE BTCPOSTALIDN = ? ";
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("ssssss",$postal->nir,
                                               $postal->asentamiento,
                                               $postal->municipio,
                                               $postal->estado,
                                               $postal->ciudad,
                                               $postal->id))
            {
               if($sentencia->execute())
               {
                   $resultado->valor=true;
               }
               else
                   $resultado->mensajeError = "Falló la ejecución (" . $this->conexion->errno . ") " . $this->conexion->error;  
            }
            else  $resultado->mensajeError = "Falló el enlace de parámetros";  
        }
        else
            $resultado->mensajeError = "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;   
        return $resultado;        
    }
    
    public function consultar($criteriosSeleccion)
    {     
        $resultado = new Resultado();
        $postales = array();     
       
        $consulta =   " SELECT "
                     . " BTCPOSTALIDN id, "
                     . " BTCPOSTALID nir, "
                     . " BTCPOSTALASENT asentamiento, "
                     . " BTCPOSTALMPIO municipio, "    
                     . " BTCPOSTALESTADO estado, "
                     . " BTCPOSTALCIUDAD ciudad "
                     . " FROM BSTNTRN.BTCPOSTAL  "
                     . " WHERE BTCPOSTALID like  CONCAT('%',?,'%') ";
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("s",$criteriosSeleccion->nir))
            {
                if($sentencia->execute())
                {                
                    if ($sentencia->bind_result($id, $nir, $asentamiento, $municipio, $estado, $ciudad)  )
                    {                    
                        while($row = $sentencia->fetch())
                        {
                            $postal = (object) [
                                'id' => utf8_encode($id),
                                'nir' =>  utf8_encode($nir),
                                'asentamiento' => utf8_encode($asentamiento),
                                'municipio' => utf8_encode($municipio),
                                'estado' => utf8_encode($estado),
                                'ciudad' => utf8_encode($ciudad)
                            ];  
                            array_push($postales,$postal);
                        }
                        $resultado->valor = $postales; 
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

    public function consultarPorLlaves($llaves)
    {
        
        $resultado = new Resultado();       
        $consulta =   " SELECT "
                     . " BTCPOSTALIDN id, "
                     . " BTCPOSTALID nir, "
                     . " BTCPOSTALASENT asentamiento, "
                     . " BTCPOSTALESTADO estado, "
                     . " BTCPOSTALMPIO municipio, "
                     . " BTCPOSTALCIUDAD ciudad "
                     . " FROM BTCPOSTAL "
                     . " WHERE BTCPOSTALIDN = ?";
                    
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("i",$llaves->id))
            {
                if($sentencia->execute())
                {                    
                    if ($sentencia->bind_result($id, $nir, $asentamiento, $estado, $municipio,  $ciudad))
                    {                        
                        if($sentencia->fetch())
                        {
                            $postal = new Postal();
                            $postal->id =  utf8_encode($id);
                            $postal->nir =  utf8_encode($nir);
                            $postal->asentamiento =  utf8_encode($asentamiento);
                            $postal->estado =  utf8_encode($estado);
                            $postal->municipio =  utf8_encode($municipio);
                            $postal->ciudad =  utf8_encode($ciudad);
                            $resultado->valor = $postal;                           
                        }
                        else
                            $resultado->mensajeError = "No se encontró ningún resultado.";
                    }
                    else
                        $resultado->mensajeError = "Falló el enlace del resultado";
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

