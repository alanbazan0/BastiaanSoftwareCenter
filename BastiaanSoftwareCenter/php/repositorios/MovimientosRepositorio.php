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
    
  
    public function calcularId()
    {
        $resultado = new Resultado();
        $consulta =  "SELECT MAX(IFNULL(BTMPERSONALIDN,0))+1 AS id FROM BSTNTRN.BTMPERSONAL";
        
   
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
   
    /*
    public function Segundos()
    {
        $resultado = new Resultado();
        $consulta =  "SELECT MAX(IFNULL(BTMPERSONALIDN,0))+1 AS id FROM BSTNTRN.BTMPERSONAL";
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
    
    */
    public function insertar(Movimiento $movimiento)
    {
        $resultado =  $this->calcularId();
        if($resultado->mensajeError=="")
        {
        $id = $resultado->valor;
        $consulta = " INSERT INTO BSTNTRN.BTMPERSONAL "
            . " (BTMPERSONALIDN,  "
            . " SIOUSUARIOID,  "
            . " BTMPERSONALRECID, "
            . " BTMPERSONALFINI, "
            . " BTMPERSONALHINI, "
            . " BTMPERSONALFFIN, "
            . " BTMPERSONALHFIN, "
            . " BTMPERSONALDUR, "
            . " BTMPERSONALDURS, "
            . " BTMPERSONALFECHA, "    
            . " BTCRECESONOMC)"
            . " VALUE(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                 if($sentencia = $this->conexion->prepare($consulta))
                            {
                                if( $sentencia->bind_param("issssssssss",$id,
                                    $movimiento->agente,
                                    $movimiento->recesoId,
                                    $movimiento->fInicial,
                                    $movimiento->hInicial,
                                    $movimiento->fFinal,
                                    $movimiento->hFinal,
                                    $movimiento->dPersonal,
                                    $movimiento->dsPersonal,
                                    $movimiento->fPersonal,
                                    $movimiento->recesoC))
                               
                                  {
                                    if(!$sentencia->execute())
                                        $resultado->mensajeError = "Fall� la ejecuci�n (" . $this->conexion->errno . ") " . $this->conexion->error;
                                  }
                                else
                                    $resultado->mensajeError = "Fall� el enlace de par�metros";
                            }
                            else
                        $resultado->mensajeError = "Fall� la preparaci�n: (" . $this->conexion->errno . ") " . $this->conexion->error;
                  }              
               return $resultado;
    }
    
    public function eliminar($llaves)
    {
        $resultado = new Resultado();
        $consulta = " DELETE FROM BSTNTRN.BTMPERSONAL "
                    . "  WHERE BTMPERSONALIDN = ? ";
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
                    . " SIOUSUARIOID = ?,  "
                    . " BTMPERSONALRECID = ?, "
                    ." BTMPERSONALFINI = ?, "
                    ." BTMPERSONALHINI = ?, "
                    ." BTMPERSONALFFIN = ?, "        
                    ." BTMPERSONALHFIN = ?, "
                    ." BTMPERSONALDUR = ?, "
                    ." BTMPERSONALDURS = ?, "
                    ." BTMPERSONALFECHA = ?, "
                    ." BTCRECESONOMC = ? "
                    ." WHERE BTMPERSONALIDN = ? ";            
         if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("sssssssssss",$movimiento->agente,
                                                    $movimiento->recesoId,
                                                    $movimiento->fInicial,
                                                    $movimiento->hInicial,
                                                    $movimiento->fFinal,
                                                    $movimiento->hFinal,
                                                    $movimiento->dPersonal,
                                                    $movimiento->dsPersonal,
                                                    $movimiento->fPersonal,
                                                    $movimiento->recesoC,
                                                    $movimiento->id))
                                               
                        {
                           if($sentencia->execute()){
                               $resultado->valor=true;
                        }else
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
       
            $consulta = " SELECT BTMPERSONALIDN id, SIOUSUARIONCOMPLETO agenteId, B.SIOUSUARIOID agente ,  BTCRECESONOMC recesoC, BTMPERSONALRECID recesoId,  DATE_FORMAT(BTMPERSONALFINI,'%d/%m/%Y') fInicial ,BTMPERSONALHINI hInicial, BTMPERSONALHFIN hFinal, DATE_FORMAT(BTMPERSONALFFIN,'%d/%m/%Y') fFinal, BTMPERSONALDUR dPersonal, FORMAT(BTMPERSONALDURS, 0) dsPersonal,  BTMPERSONALFECHA fPersonal".
                        " FROM BSTNTRN.BTMPERSONAL A".
                        " INNER JOIN BSTNTRN.SIOUSUARIO B ON A.SIOUSUARIOID = B.SIOUSUARIOID " .
                        " WHERE BTMPERSONALIDN  like CONCAT('%',?,'%') ".
                        " AND (BTMPERSONALFINI like CONCAT('%',?,'%') ".
                        " OR BTMPERSONALFFIN like CONCAT('%',?,'%')) ".
                        " ORDER BY BTMPERSONALIDN ";
            
            
           // " DATE_FORMAT(SIOUSUARIOFNAC,'%d/%m/%Y') fechaNacimiento, "
                  
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("sss",$criteriosSeleccion->id, $criteriosSeleccion->fInicial, $criteriosSeleccion->fFinal))
            {
                if($sentencia->execute())
                {                
                    if ($sentencia->bind_result($id, $agenteId, $agente,  $recesoC, $recesoId, $fInicial, $hInicial, $hFinal, $fFinal, $dPersonal, $dsPersonal, $fPersonal))
                    {                    
                        while($row = $sentencia->fetch())
                        {
                            $movimiento = (object) [
                                'id' => utf8_encode($id),
                                'agenteId' =>  utf8_encode($agenteId),
                                'agente' =>  utf8_encode($agente), 
                                'recesoC' =>  utf8_encode($recesoC), 
                                'recesoId' => utf8_encode($recesoId),
                                'fInicial' => utf8_encode($fInicial),
                                'hInicial' => utf8_encode($hInicial), 
                                'hFinal' => utf8_encode($hFinal), 
                                'fFinal' => utf8_encode($fFinal), 
                                'dPersonal' => utf8_encode($dPersonal),
                                'dsPersonal' => utf8_encode($dsPersonal),
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
 
    public function  consultarPorUsuario($criteriosUsuarios)

    {
        $resultado = new Resultado();
        $usuarios = array();
        
        $consulta = " SELECT SIOUSUARIOID id, SIOUSUARIONCOMPLETO agenteId".
            " FROM BSTNTRN.SIOUSUARIO ".
            " WHERE SIOUSUARIOID like CONCAT ('%',?,'%') ".
             "AND  SIOUSUARIONCOMPLETO  like CONCAT('%',?,'%')";
        
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("ss",$criteriosUsuarios->agenteId,
                                            $criteriosUsuarios->agente))
            {
                if($sentencia->execute())
                {
                    if ($sentencia->bind_result($id, $agenteId)  )
                    {
                        while($row = $sentencia->fetch())
                        {
                            $usuario = (object) [
                                'id' => utf8_encode($id),
                                'agenteId' =>  utf8_encode($agenteId)
                            ];
                            array_push($usuarios,$usuario);
                        }
                        $resultado->valor = $usuarios;
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
        $consulta =  " SELECT BTMPERSONALIDN id, SIOUSUARIONCOMPLETO agenteId, B.SIOUSUARIOID agente ,  BTCRECESONOMC recesoC, BTMPERSONALRECID recesoId, BTMPERSONALFINI fInicial, BTMPERSONALHINI hInicial, BTMPERSONALHFIN hFinal, BTMPERSONALFFIN fFinal, BTMPERSONALDUR dPersonal, BTMPERSONALDURS dsPersonal,  BTMPERSONALFECHA fPersonal".
            " FROM BSTNTRN.BTMPERSONAL A".
            " INNER JOIN BSTNTRN.SIOUSUARIO B ON A.SIOUSUARIOID = B.SIOUSUARIOID " .
            " WHERE BTMPERSONALIDN like CONCAT('%',?,'%') ";
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("s",$llaves->id))
            {
                if($sentencia->execute())
                {                    
                    if ($sentencia->bind_result($id, $agenteId, $agente, $recesoC, $recesoId, $fInicial, $hInicial, $hFinal, $fFinal, $dPersonal, $dsPersonal, $fPersonal))
                    {                        
                        if($sentencia->fetch())
                        {
                            $movimiento = new Movimiento();
                            $movimiento->id =  utf8_encode($id);
                            $movimiento->agenteId =  utf8_encode($agenteId);
                            $movimiento->agente =  utf8_encode($agente);
                            $movimiento->recesoC =  utf8_encode($recesoC);
                            $movimiento->recesoId =  utf8_encode($recesoId);
                            $movimiento->fInicial =  utf8_encode($fInicial);
                            $movimiento->hInicial =  utf8_encode($hInicial);
                            $movimiento->hFinal =  utf8_encode($hFinal);
                            $movimiento->fFinal =  utf8_encode($fFinal);
                            $movimiento->dPersonal =  utf8_encode($dPersonal);
                            $movimiento->dsPersonal =  utf8_encode($dsPersonal);
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
