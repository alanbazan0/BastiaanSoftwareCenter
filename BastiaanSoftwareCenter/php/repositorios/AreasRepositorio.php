<?php
namespace php\repositorios;

use Exception;
use php\interfaces\IAreasRepositorio;
use php\modelos\Area;
use php\modelos\Resultado;


include "../interfaces/IAreasRepositorio.php";
include "../modelos/Area.php";
include "../clases/Resultado.php";

class AreasRepositorio implements IAreasRepositorio
{
    protected $conexion;
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }
    
    public function calcularId()
    {
        $resultado = new Resultado();
        $consulta =  "SELECT MAX(IFNULL(SIOAREAIDN,0))+1 AS id FROM BSTNTRN.SIOAREA";
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
    
    public function insertar(Area $area)
    {
        $resultado =  $this->calcularId();
        if($resultado->mensajeError=="")
        {
            $id = $resultado->valor;
            $consulta = " INSERT INTO BSTNTRN.SIOAREA "
                . " (SIOAREAIDN, "
                . " SIOAREAID, "
                . " SIOAREADSC) "
                . " VALUE(?,?,?) ";
         if($sentencia = $this->conexion->prepare($consulta))
           {
             if( $sentencia->bind_param("iss",$id,
                 $area->nombreArea,
                 $area->descripcionArea))
                {
                   if(!$sentencia->execute())
                    $resultado->mensajeError = "Falló la ejecución (" . $this->conexion->errno . ") " . $this->conexion->error;
                }
                   else
                    $resultado->mensajeError = "Falló el enlace de parÃ¡metros";
                }
                   else
               $resultado->mensajeError = "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
        }
        return $resultado;
    }
    
    public function eliminar($llaves)
    {
        $resultado = new Resultado();
        $consulta = " DELETE FROM BSTNTRN.SIOAREA "
            . "  WHERE SIOAREAIDN  = ? ";
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
                    $resultado->mensajeError = "Falló el enlace de parÃ¡metros";
            }
            else
                $resultado->mensajeError = "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
                
                return $resultado;
    }
    
    public function actualizar(Area $area)
    {
        $resultado = new Resultado();
        $consulta = " UPDATE BSTNTRN.SIOAREA SET"
                . " SIOAREAID = ?, "
                . " SIOAREADSC = ? "
                . " WHERE SIOAREAIDN = ? ";
                 if($sentencia = $this->conexion->prepare($consulta))
                    {
                       if($sentencia->bind_param("sss",$area->nombreArea,
                          $area->descripcionArea,
                          $area->id))
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
        $areas = array();
        
        $consulta =   " SELECT "
                    . " SIOAREAIDN idArea, "
                    . " SIOAREAID nombreArea, "
                    . " SIOAREADSC descripcionArea "
                    . " FROM BSTNTRN.SIOAREA  "
                    . " WHERE SIOAREAIDN like  CONCAT('%',?,'%') "
                    . " AND SIOAREAID like  CONCAT('%',?,'%') ";
                    if($sentencia = $this->conexion->prepare($consulta))
                    {
                   if($sentencia->bind_param("ss",$criteriosSeleccion->idArea,$criteriosSeleccion->nombreArea))
                    {
                      if($sentencia->execute())
                        {
                          if ($sentencia->bind_result($idArea, $nombreArea, $descripcionArea )  )
                             {
                               while($row = $sentencia->fetch())
                                {
                                    $area = (object) [
                                        'id' =>  utf8_encode($idArea),
                                        'nombreArea' => utf8_encode($nombreArea),
                                        'descripcionArea' => utf8_encode($descripcionArea)
                                                      ];
                                     array_push($areas,$area);
                                      }
                               $resultado->valor = $areas;
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
                    . " SIOAREAIDN id, "
                    . " SIOAREAID nombreArea, "
                    . " SIOAREADSC descripcionArea "
                    . " FROM SIOAREA "
                    . " WHERE SIOAREAIDN  = ?";
                 if($sentencia = $this->conexion->prepare($consulta))
                    {
                      if($sentencia->bind_param("i",$llaves->id))
                       {
                         if($sentencia->execute())
                           {
                            if ($sentencia->bind_result($id, $nombreArea, $descripcionArea ))
                             {
                              if($sentencia->fetch())
                                {
                                  $area = new Area();
                                  $area->id = utf8_encode($id);
                                  $area->primerNombre = utf8_encode($nombreArea);
                                  $area->segundoNombre = utf8_encode($descripcionArea);
                                  $resultado->valor = $area;
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

