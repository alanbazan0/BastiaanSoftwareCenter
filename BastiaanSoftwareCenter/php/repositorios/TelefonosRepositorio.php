<?php
namespace php\repositorios;

use Exception;
use php\interfaces\ITelefonosRepositorio;
use php\modelos\Telefono;
use php\modelos\Resultado;


include "../interfaces/ITelefonosRepositorio.php";
include "../modelos/Telefono.php";
include "../clases/Resultado.php";

class TelefonosRepositorio implements ITelefonosRepositorio
{
    protected $conexion;
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }
    
    public function calcularId()
    {   
       
        $resultado = new Resultado();
        $consulta =  "SELECT MAX(IFNULL(BTTTELEFONOID,0))+1 AS id FROM BSTNTRN.BTTTELEFONO";
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
    
    public function insertar(Telefono $telefono)
    {            
        $resultado =  $this->calcularId();
        if($resultado->mensajeError=="")
        {
            $id = $resultado->valor;
            $consulta = " INSERT INTO BSTNTRN.BTTTELEFONO "
                        . " (BTTTELEFONOID, "
                        . " BTTTELEFONODESC) "
                        . " VALUE(?,?) ";
            if($sentencia = $this->conexion->prepare($consulta))
            {
                if( $sentencia->bind_param("is",$id, $telefono->detalle))
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
        $consulta = " DELETE FROM BSTNTRN.BTTTELEFONO "
                    . "  WHERE BTTTELEFONOID = ? ";
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

    public function actualizar(Telefono $telefono)
    {     
        $resultado = new Resultado();
        $consulta = " UPDATE BSTNTRN.BTTTELEFONO SET"
                    . " BTTTELEFONODESC = ? "
                    . " WHERE BTTTELEFONOID = ? ";
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("ss",$telefono->detalle,
                                            $telefono->id))
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
        $telefonos = array();     
       
        $consulta =   " SELECT "
                    . " BTTTELEFONOID id, "
                    . " BTTTELEFONODESC detalle "
                    . " FROM BSTNTRN.BTTTELEFONO  "
                    . " WHERE BTTTELEFONOID like  CONCAT('%',?,'%') ";
             
                    
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("s",$criteriosSeleccion->detalle))
            {
                if($sentencia->execute())
                {                
                    if ($sentencia->bind_result($id, $detalle )  )
                    {                    
                        while($row = $sentencia->fetch())
                        {
                            $telefono = (object) [
                                'id' =>  utf8_encode($id),
                                'detalle' => utf8_encode($detalle)
                            ];  
                            array_push($telefonos,$telefono);
                        }
                        $resultado->valor = $telefonos; 
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
                    . " BTTTELEFONOID id, "
                    . " BTTTELEFONODESC detalle "
                    . " FROM BTTTELEFONO " 
                    . " WHERE BTTTELEFONOID  = ?";
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("i",$llaves->id))
            {
                if($sentencia->execute())
                {                    
                    if ($sentencia->bind_result($id, $detalle ))
                    {                        
                        if($sentencia->fetch())
                        {
                            $telefono = new Telefono();
                            $telefono->id = utf8_encode($id);
                            $telefono->detalle = utf8_encode($detalle);
                            $resultado->valor = $telefono;
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
    public function consultarCatalagoTipoTelefono()
    {
        $resultado = new Resultado();
        $TiposTelefonos = array();
        
        $consulta =   " SELECT BTTTELEFONOID idTelefono, "
            . " BTTTELEFONODESC descripcionTipo "
                . " FROM BSTNTRN.BTTTELEFONO ";
                
                if($sentencia = $this->conexion->prepare($consulta))
                {
                    if($sentencia->execute())
                    {
                        if ($sentencia->bind_result($idTelefono, $descripcionTipo))
                        {
                            while($row = $sentencia->fetch())
                            {
                                $TipoTelefono = (object) [
                                    'id' =>  utf8_encode($idTelefono),
                                    'descripcion' => utf8_encode($descripcionTipo)
                                    
                                ];
                                array_push($TiposTelefonos,$TipoTelefono);
                            }
                            $resultado->valor = $TiposTelefonos;
                        }
                        else
                            $resultado->mensajeError = "Falló el enlace del resultado.";
                    }
                    else
                        $resultado->mensajeError = "Falló la ejecución (" . $this->conexion->errno . ") " . $this->conexion->error;
                        
                }
                else
                    $resultado->mensajeError = "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
                    
                    
                    return $resultado;
    }

    
}

