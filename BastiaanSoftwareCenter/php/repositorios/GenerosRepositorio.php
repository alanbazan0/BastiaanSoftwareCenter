<?php
namespace php\repositorios;

use Exception;
use php\Interfaces\IGenerosRepositorio;
use php\modelos\Genero;
use php\modelos\Resultado;

include "../interfaces/IGenerosRepositorio.php";    
include "../modelos/Genero.php";
include "../clases/Resultado.php";

class GenerosRepositorio implements IGenerosRepositorio
{
    protected $conexion;
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }
    
    
    public function insertar(Genero $genero)
    {
        $resultado = "";
    
        $consulta = " INSERT INTO BSTNTRN.BTGENERO" 
             . " (BTGENEROID, "
             . " BTGENERONOMC, "
             . " BTGENERONOML) "                   
             . " VALUE(?, ?, ?) ";
               if($sentencia = $this->conexion->prepare($consulta))
                 {
                 if( $sentencia->bind_param("sss",$genero->id,
                  $genero->gCorto,
                  $genero->gLargo))
                  {
                      if(!$sentencia->execute())
                          $resultado->mensajeError = "Falló la ejecución (" . $this->conexion->errno . ") " . $this->conexion->error;
                  }
                  else
                      $resultado->mensajeError = "Falló el enlace de parámetros";
                 }
                 else
                     $resultado->mensajeError = "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
    
    return $resultado;
}

    
    public function eliminar($llaves)
    {
        $resultado = "";
        $consulta = " DELETE FROM BSTNTRN.BTGENERO "
            . "  WHERE BTGENEROID = ? ";
            if($sentencia = $this->conexion->prepare($consulta))
            {
                if($sentencia->bind_param("s",$llaves->id))
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
    
    public function actualizar(Genero $genero)
    {
        $resultado = new Resultado();
        $consulta = " UPDATE BSTNTRN.BTGENERO SET"
                    . " BTGENERONOMC = ?, "
                    . " BTGENERONOML = ? "
                    . " WHERE BTGENEROID  = ?";
                if($sentencia = $this->conexion->prepare($consulta))
                {
                    if($sentencia->bind_param("sss",
                        $genero->gCorto,
                        $genero->gLargo,
                        $genero->id))
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
        $generos = array();
        $consulta =   " SELECT "
                    . " BTGENEROID id, "
                    . " BTGENERONOMC gCorto, "
                    . " BTGENERONOML gLargo "        
                    . " FROM BSTNTRN.BTGENERO "
                    . " WHERE BTGENEROID like  CONCAT('%',?,'%') "
                    . " AND BTGENERONOMC like  CONCAT('%',?,'%') "
                    . " AND BTGENERONOML like  CONCAT('%',?,'%') ";
        
                    if($sentencia = $this->conexion->prepare($consulta))
                    {
                        if($sentencia->bind_param("sss",$criteriosSeleccion->id,$criteriosSeleccion->gCorto,$criteriosSeleccion->gLargo))
                        {
                            if($sentencia->execute())
                            {
                                if ($sentencia->bind_result($id, $gCorto, $gLargo )  )
                                {
                                    while($row = $sentencia->fetch())
                    {
                        $genero = (object) [
                            'id' =>  utf8_encode($id),
                            'gCorto' =>  utf8_encode($gCorto),
                            'gLargo' =>  utf8_encode($gLargo)                            
                        ];  
                        array_push($generos,$genero);
                    }
                    $resultado->valor = $generos;
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
        $consulta = " SELECT "
                   . " BTGENEROID id, "
                   . " BTGENERONOMC gCorto, "
                   . " BTGENERONOML gLargo "
                   . " FROM BSTNTRN.BTGENERO "
                   . " WHERE BTGENEROID  = ?";
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("s",$llaves->id))
            {
              if($sentencia->execute())
                {
                  
                if ($sentencia->bind_result($id, $gCorto, $gLargo))
                {
                    
                    if ($sentencia->fetch())
                    {
                        $genero = new Genero();
                        $genero->id = utf8_encode($id);
                        $genero->gCorto = utf8_encode($gCorto);
                        $genero->gLargo = utf8_encode($gLargo);
                        $resultado->valor = $genero;
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

