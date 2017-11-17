<?php
namespace php\repositorios;

use Exception;
use php\interfaces\IMovimientosRepositorio;
use php\modelos\Resultado;
use php\modelos\Movimiento;
include "../interfaces/IMovimientosRepositorio.php";
include "../modelos/Movimiento.php";
include "../clases/Resultado.php";


class MovimientosRepositorio implements IMovimientosRepositorio
{
    protected $conexion;
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }
    
    public function insertar(Movimiento $movimiento)
    {
        $resultado = "";
        
        $consulta = " INSERT INTO BSTNTRN.BTMPERSONAL "
            . " (BTMPERSONALID, "
            . " BTMPERSONALUSUID, "
            . " BTMPERSONALRECID, "
            . " BTMPERSONALHINI, "
            . " BTMPERSONALHFIN, "
            . " BTMPERSONALFECHA) "
            . " VALUE(?, ?, ?, ?, ?, ?)";
                 if($sentencia = $this->conexion->prepare($consulta))
                            {
                                if( $sentencia->bind_param("ssssss",$movimiento->id,
                                    $movimiento->agenteId,
                                    $movimiento->recesoId,
                                    $movimiento->fInicial,
                                    $movimiento->fFinal,
                                    $movimiento->fPersonal))
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
        $consulta = " DELETE FROM BSTNTRN.BTMPERSONAL "
                    . "  WHERE BTMPERSONALID = ? ";
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

    public function actualizar(Movimiento $movimiento)
    {     
        $resultado = new Resultado();
        $consulta = " UPDATE BSTNTRN.BTMPERSONAL SET"
                    . " BTMPERSONALUSUID= ?, "
                    . " BTMPERSONALRECID= ?, "
                    . " BTMPERSONALHINI= ?, "
                    . " BTMPERSONALHFIN= ?, "
                    . " BTMPERSONALFECHA= ? "
                    . " WHERE BTMPERSONALID = ? "; 
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("ssssss",
                                               $movimiento->agenteId,
                                               $movimiento->recesoId,
                                               $movimiento->fInicial,
                                               $movimiento->fFinal,
                                               $movimiento->fPersonal,
                                               $movimiento->id))
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
        $movimientos = array();     
       
        $consulta =   " SELECT "
                     . " BTMPERSONALID id, "
                     . " BTMPERSONALUSUID agenteId, "
                     . " BTMPERSONALRECID recesoId, "
                     . " BTMPERSONALHINI fInicial, "
                     . " BTMPERSONALHFIN fFinal, "
                     . " BTMPERSONALFECHA fPersonal  "
                     . " FROM BSTNTRN.BTMPERSONAL  "
                     . " WHERE BTMPERSONALID like  CONCAT('%',?,'%') ";
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("s",$criteriosSeleccion->id))
            {
                if($sentencia->execute())
                {                
                    if ($sentencia->bind_result($id, $agenteId, $recesoId, $fInicial, $fFinal, $fPersonal))
                    {                    
                        while($row = $sentencia->fetch())
                        {
                            $movimiento = (object) [
                                'id' => utf8_encode($id),
                                'agenteId' =>  utf8_encode($agenteId),
                                'recesoId' => utf8_encode($recesoId),
                                'fInicial' => utf8_encode($fInicial),
                                'fFinal' => utf8_encode($fFinal),
                                'fPersonal' => utf8_encode($fPersonal)
                            ];  
                            array_push($movimientos,$movimiento);
                        }
                        $resultado->valor = $movimientos; 
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
    
    public function consultarPorReceso()
    {
        $resultado = new Resultado();
        $recesos = array();
  
        $consulta = " SELECT "
         . " BTCRECESOID recesoId, "
         . " BTCRECESONOMP rDescripcion, "
         . " BTCRECESONOMC rCorto, "
         . " BTCRECESONOML rLargo, "
         . " BTCRECESOMAXTMP rTiempo, "
         . " BTCRECESOMAXREC rRecesos  "
         . " FROM BSTNTRN.BTCRECESO  ";
            if($sentencia = $this->conexion->prepare($consulta))
                                    {
                                        if(true)
                                        {
                                            if($sentencia->execute())
                                            {
                                                if ($sentencia->bind_result($recesoId, $rDescripcion, $rCorto, $rLargo, $rTiempo, $rRecesos)  )
                                                {
                                                    while($row = $sentencia->fetch())
                                                    {
                                                        $receso = (object) [
                                                            'recesoId' => utf8_encode($recesoId),
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
                     . " BTMPERSONALID id, "
                     . " BTMPERSONALUSUID agenteId, "
                     . " BTMPERSONALRECID recesoId, "
                     . " BTMPERSONALHINI fInicial, "
                     . " BTMPERSONALHFIN fFinal,"
                     . " BTMPERSONALFECHA fPersonal  "
                     . " FROM BTMPERSONAL "
                     . " WHERE BTMPERSONALID = ?";
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("s",$llaves->id))
            {
                if($sentencia->execute())
                {                    
                    if ($sentencia->bind_result($id, $agenteId, $recesoId, $fInicial, $fFinal, $fPersonal))
                    {                        
                        if($sentencia->fetch())
                        {
                            $movimiento = new Movimiento();
                            $movimiento->id =  utf8_encode($id);
                            $movimiento->agenteId =  utf8_encode($agenteId);
                            $movimiento->recesoId =  utf8_encode($recesoId);
                            $movimiento->fInicial =  utf8_encode($fInicial);
                            $movimiento->fFinal =  utf8_encode($fFinal);
                            $movimiento->fPersonal =  utf8_encode($fPersonal);
                            $resultado->valor = $movimiento;                           
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

