<?php
namespace php\repositorios;

use Exception;
use php\interfaces\IBajasRepositorio;
use php\modelos\Baja;
use php\modelos\Resultado;


include "../interfaces/IBajasRepositorio.php";
include "../modelos/Baja.php";
include "../clases/Resultado.php";

class BajasRepositorio implements IBajasRepositorio
{
    protected $conexion;
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }
    
    public function calcularId()
    {   
       
        $resultado = new Resultado();
        $consulta =  "SELECT MAX(IFNULL(BTMBAJAID,0))+1 AS id FROM BSTNTRN.BTMBAJA";
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
    
    public function insertar(Baja $baja)
    {            
        $resultado =  $this->calcularId();
        if($resultado->mensajeError=="")
        {
            $id = $resultado->valor;
            $consulta = " INSERT INTO BSTNTRN.BTMBAJA "
                        . " (BTMBAJAID, "
                        . " BTMBAJADESC) "
                        . " VALUE(?,?) ";
            if($sentencia = $this->conexion->prepare($consulta))
            {
                if( $sentencia->bind_param("is",$id, $baja->motivo))
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
        $consulta = " DELETE FROM BSTNTRN.BTMBAJA "
                    . "  WHERE BTMBAJAID = ? ";
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

    public function actualizar(Baja $baja)
    {     
        $resultado = new Resultado();
        $consulta = " UPDATE BSTNTRN.BTMBAJA SET"
                    . " BTMBAJADESC = ? "
                    . " WHERE BTMBAJAID = ? ";
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("ss",$baja->motivo,
                                            $baja->id))
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
        $bajas = array();     
       
        $consulta =   " SELECT "
                    . " BTMBAJAID id, "
                    . " BTMBAJADESC motivo "
                    . " FROM BSTNTRN.BTMBAJA  "
                    . " WHERE BTMBAJAID like  CONCAT('%',?,'%') ";
             
                    
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("s",$criteriosSeleccion->motivo))
            {
                if($sentencia->execute())
                {                
                    if ($sentencia->bind_result($id, $motivo )  )
                    {                    
                        while($row = $sentencia->fetch())
                        {
                            $baja = (object) [
                                'id' =>  utf8_encode($id),
                                'motivo' => utf8_encode($motivo)
                            ];  
                            array_push($bajas,$baja);
                        }
                        $resultado->valor = $bajas; 
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
                    . " BTMBAJAID id, "
                    . " BTMBAJADESC motivo "
                    . " FROM BTMBAJA " 
                    . " WHERE BTMBAJAID  = ?";
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("i",$llaves->id))
            {
                if($sentencia->execute())
                {                    
                    if ($sentencia->bind_result($id, $motivo ))
                    {                        
                        if($sentencia->fetch())
                        {
                            $baja = new Baja();
                            $baja->id = utf8_encode($id);
                            $baja->motivo = utf8_encode($motivo);
                            $resultado->valor = $baja;
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

