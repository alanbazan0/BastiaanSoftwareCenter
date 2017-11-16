<?php
namespace php\repositorios;

use Exception;
use php\interfaces\IRecesosRepositorio;
use php\modelos\Resultado;
use php\modelos\Receso;
include "../interfaces/IRecesosRepositorio.php";
include "../modelos/Receso.php";
include "../clases/Resultado.php";

class RecesosRepositorio implements IRecesosRepositorio
{
    protected $conexion;
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }
    
    public function insertar(Receso $receso)
    {
        $resultado = "";
        
        $consulta = " INSERT INTO BSTNTRN.BTCRECESO "
            . " (BTCRECESOID, "
            . " BTCRECESONOMP, "
            . " BTCRECESONOMC, "
            . " BTCRECESONOML, "
            . " BTCRECESOMAXTMP, "
            . " BTCRECESOMAXREC) "
            . " VALUE(?, ?, ?, ?, ?, ?)";
                 if($sentencia = $this->conexion->prepare($consulta))
                            {
                                if( $sentencia->bind_param("ssssss",$receso->id,
                                    $receso->rDescripcion,
                                    $receso->rCorto,
                                    $receso->rLargo,
                                    $receso->rTiempo,
                                    $receso->rRecesos))
                                  {
                                    if(!$sentencia->execute())
                                        $resultado->mensajeError = "Fall� la ejecuci�n (" . $this->conexion->errno . ") " . $this->conexion->error;
                                  }
                                else
                                    $resultado->mensajeError = "Fall� el enlace de par�metros";
                            }
                            else
                        $resultado->mensajeError = "Fall� la preparaci�n: (" . $this->conexion->errno . ") " . $this->conexion->error;
                                
               return $resultado;
    }
    
    public function eliminar($llaves)
    {
        $resultado = new Resultado();
        $consulta = " DELETE FROM BSTNTRN.BTCRECESO "
                    . "  WHERE BTCRECESOID = ? ";
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

    public function actualizar(Receso $receso)
    {     
        $resultado = new Resultado();
        $consulta = " UPDATE BSTNTRN.BTCRECESO SET"
                    . " BTCRECESONOMP= ?, "
                    . " BTCRECESONOMC= ?, "
                    . " BTCRECESONOML= ?, "
                    . " BTCRECESOMAXTMP= ?, "
                    . " BTCRECESOMAXREC= ? "
                    . " WHERE BTCRECESOID = ? "; 
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("ssssss",
                                               $receso->rDescripcion,
                                               $receso->rCorto,
                                               $receso->rLargo,
                                               $receso->rTiempo,
                                               $receso->rRecesos,
                                               $receso->id))
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
        $recesos = array();     
       
        $consulta =   " SELECT "
                     . " BTCRECESOID id, "
                     . " BTCRECESONOMP rDescripcion, "
                     . " BTCRECESONOMC rCorto, "
                     . " BTCRECESONOML rLargo, "
                     . " BTCRECESOMAXTMP rTiempo, "
                     . " BTCRECESOMAXREC rRecesos  "
                     . " FROM BSTNTRN.BTCRECESO  "
                     . " WHERE BTCRECESOID like  CONCAT('%',?,'%') ";
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("s",$criteriosSeleccion->id))
            {
                if($sentencia->execute())
                {                
                    if ($sentencia->bind_result($id, $rDescripcion, $rCorto, $rLargo, $rTiempo, $rRecesos))
                    {                    
                        while($row = $sentencia->fetch())
                        {
                            $receso = (object) [
                                'id' => utf8_encode($id),
                                'rDescripcion' =>  utf8_encode($rDescripcion),
                                'rCorto' => utf8_encode($rCorto),
                                'rLargo' => utf8_encode($rLargo),
                                'rTiempo' => utf8_encode($rTiempo),
                                'rRecesos' => utf8_encode($rRecesos)
                            ];  
                            array_push($recesos,$receso);
                        }
                        $resultado->valor = $recesos; 
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
                     . " BTCRECESOID id, "
                     . " BTCRECESONOMP rDescripcion, "
                     . " BTCRECESONOMC rCorto, "
                     . " BTCRECESONOML rLargo, "
                     . " BTCRECESOMAXTMP rTiempo,"
                     . " BTCRECESOMAXREC rRecesos  "
                     . " FROM BTCRECESO "
                     . " WHERE BTCRECESOID = ?";
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("s",$llaves->id))
            {
                if($sentencia->execute())
                {                    
                    if ($sentencia->bind_result($id, $rDescripcion, $rCorto, $rLargo, $rTiempo, $rRecesos))
                    {                        
                        if($sentencia->fetch())
                        {
                            $receso = new Receso();
                            $receso->id =  utf8_encode($id);
                            $receso->rDescripcion =  utf8_encode($rDescripcion);
                            $receso->rCorto =  utf8_encode($rCorto);
                            $receso->rLargo =  utf8_encode($rLargo);
                            $receso->rTiempo =  utf8_encode($rTiempo);
                            $receso->rRecesos =  utf8_encode($rRecesos);
                            $resultado->valor = $receso;                           
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

