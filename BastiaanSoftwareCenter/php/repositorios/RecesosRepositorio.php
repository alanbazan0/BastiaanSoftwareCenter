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
    public function consultar2()
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
                                    . " FROM BSTNTRN.BTCRECESO  ";
                                        if($sentencia = $this->conexion->prepare($consulta))
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
                                            $resultado->mensajeError = "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
                                            
                                            
                                            return $resultado;
    } 
    public function ActuaizaSolictarReceso($NombreUsuario,$idTipoSolicitud,$DescTipoSolicitud,$EstatusSolicitud,$LlamadaId)
    {
        $resultado = new Resultado();
        $consulta = "UPDATE  BSTNTRN.BTESTAGNT "
                    ." SET BTESTAGNTT=?, BTESTAGNTCALLID=?, BTESTAGNTMOTIVO=?, BTESTAGNTMOTIVOID=? "
                    ." WHERE BTESTAGNTUSR=?";
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("sssss",
                $EstatusSolicitud,
                $LlamadaId,
                $DescTipoSolicitud,
                $idTipoSolicitud,
                $NombreUsuario))
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
    
   
    public function InsertarSolictarReceso($NombreUsuario,$idTipoSolicitud,$DescTipoSolicitud,$EstatusSolicitud,$LlamadaId)
    {
        $resultado = new Resultado();
        $consulta = "INSERT INTO BSTNTRN.BTESTAGNT (BTESTAGNTT, BTESTAGNTCALLID, BTESTAGNTUSR, BTESTAGNTMOTIVO, BTESTAGNTMOTIVOID)"
                     ."VALUES (?,?,?,?,?)";
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("sssss",
                $EstatusSolicitud,
                $LlamadaId,
                $NombreUsuario,
                $DescTipoSolicitud,
                $idTipoSolicitud))
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
    public function consultarIdUsuarioExt($id)
    {
        $resultado = new Resultado();
        $recesos = array();
        
        $consulta =   " SELECT BTESTAGNTUSR FROM BSTNTRN.BTESTAGNT where BTESTAGNTUSR=? ";
                                        if($sentencia = $this->conexion->prepare($consulta))
                                        {
                                            if($sentencia->bind_param("s",$id))
                                            {
                                                if($sentencia->execute())
                                                {
                                                    if ($sentencia->bind_result($BTESTAGNTUSR))
                                                    {
                                                        while($row = $sentencia->fetch())
                                                        {
                                                            $receso = (object) [
                                                                'id' => utf8_encode($BTESTAGNTUSR)
                                                            ];
                                                            array_push($recesos,$receso);
                                                        }
                                                        $max = sizeof($recesos);
                                                        if($max>0)
                                                            $resultado->valor = true;
                                                        else
                                                            $resultado->valor = false;
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
    public function actualizaEstatusReceso($NombreUsuario,$EstatusSolicitud)
    {
        $resultado = new Resultado();
        $consulta = "UPDATE  BSTNTRN.BTESTAGNT "
                    ." SET BTESTAGNTT=? "
                    ." WHERE BTESTAGNTUSR=? ";
                if($sentencia = $this->conexion->prepare($consulta))
                {
                    if($sentencia->bind_param("ss",
                        $EstatusSolicitud,
                        $NombreUsuario
                        ))
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
    
    public function consultarDatosReceso($NombreUsuario)
    {
        $resultado = new Resultado();
        $recesos = array();
        $consulta = "select BTESTAGNTMOTIVOID from BSTNTRN.BTESTAGNT "
                    ." WHERE BTESTAGNTUSR=? ";
                    if($sentencia = $this->conexion->prepare($consulta))
                    {
                        if($sentencia->bind_param("s",$NombreUsuario))
                        {
                            if($sentencia->execute())
                            {
                                if ($sentencia->bind_result($BTESTAGNTMOTIVOID))
                                {
                                    while($row = $sentencia->fetch())
                                    {
                                        $receso = (object) [
                                            'id' => utf8_encode($BTESTAGNTMOTIVOID)
                                        ];
                                        array_push($recesos,$receso);
                                    }
                                    $resultado->valor = $recesos[0]->id;
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
    public function insertarMovimientos($NombreUsuario,$idTipoSolicitud,$dscTipoSolicutd)
    {
        $resultado = new Resultado();
        $resultado2 = new Resultado();
        $resultado2 =  $this->calcularIdBTMPERSONAL();
        if($resultado2->mensajeError=="")
        {
            $consulta = "INSERT INTO BSTNTRN.BTMPERSONAL (BTMPERSONALIDN, SIOUSUARIOID, BTMPERSONALRECID, BTMPERSONALFINI,BTMPERSONALHINI,BTCRECESONOMC) "
                        ." VALUES (?,?,?, CURDATE(),current_time(),?)";
                if($sentencia = $this->conexion->prepare($consulta))
                {
                    if($sentencia->bind_param("isss",$resultado2->valor,$NombreUsuario,$idTipoSolicitud,$dscTipoSolicutd))
                    {
                        if($sentencia->execute())
                        {
                            $resultado->valor=$resultado2->valor;
                        }
                        else
                            $resultado->mensajeError = "Falló la ejecución (" . $this->conexion->errno . ") " . $this->conexion->error;
                    }
                    else  $resultado->mensajeError = "Falló el enlace de parámetros";
                }
                else
                    $resultado->mensajeError = "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
        }
                return $resultado;
    }
    public function calcularIdBTMPERSONAL()
    {
        $resultado = new Resultado();
        $consulta =  "SELECT COALESCE(MAX(BTMPERSONALIDN)+1,1) AS id FROM BSTNTRN.BTMPERSONAL";
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
                        $resultado->mensajeError = "No se encontr� ning�n resultado";
                }
                else
                    $resultado->mensajeError = "Fall� el enlace del resultado";
            }
            else
                $resultado->mensajeError = "Fall� la ejecuci�n (" . $this->conexion->errno . ") " . $this->conexion->error;
        }
        else
            $resultado->mensajeError = "Fall� la preparaci�n: (" . $this->conexion->errno . ") " . $this->conexion->error;
            return $resultado;
    }
    
    public function consultaMovimientos($NombreUsuario)
    {
        $resultado = new Resultado();
        $recesos = array();
        $consulta = " SELECT SIOUSUARIOID usuario, BTMPERSONALRECID idReceso , BTMPERSONALFINI fechaInicial,  BTMPERSONALHINI horaInicial,"
                     ."BTMPERSONALFFIN fechaFinal, BTMPERSONALHFIN horaFin , BTMPERSONALDUR duracion, BTMPERSONALDURS duracionSeg,"
                     ."BTCRECESONOMC descTipoReceso FROM BSTNTRN.BTMPERSONAL where SIOUSUARIOID = ? and BTMPERSONALFINI=CURDATE() ORDER BY BTMPERSONALIDN ASC";
            if($sentencia = $this->conexion->prepare($consulta))
            {
                if($sentencia->bind_param("s",$NombreUsuario))
                {
                    if($sentencia->execute())
                    {
                        if ($sentencia->bind_result($usuario,$idReceso,$fechaInicial,$horaInicial,$fechaFinal,$horaFin,$duracion,$duracionSeg,$descTipoReceso))
                        {
                            while($row = $sentencia->fetch())
                            {
                                $receso = (object) [
                                    'usuario' => utf8_encode($usuario),
                                    'idReceso' => utf8_encode($idReceso),
                                    'fechaInicial' => utf8_encode($fechaInicial),
                                    'horaInicial' => utf8_encode($horaInicial),
                                    'fechaFinal' => utf8_encode($fechaFinal),
                                    'horaFin' => utf8_encode($horaFin),
                                    'duracion' => utf8_encode($duracion),
                                    'duracionSeg' => utf8_encode($duracionSeg),
                                    'descTipoReceso' => utf8_encode($descTipoReceso)
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
    public function ConsultarStatus($NombreUsuario)
    {
        $resultado = new Resultado();
        $recesos = array();
        $consulta = " SELECT  BTESTAGNTT estatusId, BTESTAGNTCALLID llamadaId, BTESTAGNTUSR usuarioID, BTESTAGNTMOTIVO dscReceso, BTESTAGNTMOTIVOID recesoId " 
                    ." FROM BSTNTRN.BTESTAGNT where BTESTAGNTUSR=? ";
                if($sentencia = $this->conexion->prepare($consulta))
                {
                    if($sentencia->bind_param("s",$NombreUsuario))
                    {
                        if($sentencia->execute())
                        {
                            if ($sentencia->bind_result($estatusId,$llamadaId,$usuarioID,$dscReceso,$recesoId))
                            {
                                while($row = $sentencia->fetch())
                                {
                                    $receso = (object) [
                                        'estatusId' => utf8_encode($estatusId),
                                        'llamadaId' => utf8_encode($llamadaId),
                                        'usuarioID' => utf8_encode($usuarioID),
                                        'dscReceso' => utf8_encode($dscReceso),
                                        'recesoId' => utf8_encode($recesoId)
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
    public function actualizarEstatus($NombreUsuario,$EstatusSolicitud)
    {
        $resultado = new Resultado();
        $consulta = "UPDATE  BSTNTRN.BTESTAGNT "
            ." SET BTESTAGNTT=? "
                ." WHERE BTESTAGNTUSR=? ";
                if($sentencia = $this->conexion->prepare($consulta))
                {
                    if($sentencia->bind_param("ss",
                        $EstatusSolicitud,
                        $NombreUsuario
                        ))
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
    public function consultaMovimientosInsert($NombreUsuario,$idTipoReceso,$idMovimiento)
    {
        $resultado = new Resultado();
        $recesos = array();
        $consulta = " SELECT SIOUSUARIOID usuario, BTMPERSONALRECID idReceso , BTMPERSONALFINI fechaInicial,  BTMPERSONALHINI horaInicial,"
            ."BTMPERSONALFFIN fechaFinal, BTMPERSONALHFIN horaFin , BTMPERSONALDUR duracion, BTMPERSONALDURS duracionSeg,"
                ."BTCRECESONOMC descTipoReceso FROM BSTNTRN.BTMPERSONAL where SIOUSUARIOID = ? and BTMPERSONALRECID=? and BTMPERSONALIDN=?";
                if($sentencia = $this->conexion->prepare($consulta))
                {
                    if($sentencia->bind_param("sss",$NombreUsuario,$idTipoReceso,$idMovimiento))
                    {
                        if($sentencia->execute())
                        {
                            if ($sentencia->bind_result($usuario,$idReceso,$fechaInicial,$horaInicial,$fechaFinal,$horaFin,$duracion,$duracionSeg,$descTipoReceso))
                            {
                                while($row = $sentencia->fetch())
                                {
                                    $receso = (object) [
                                        'usuario' => utf8_encode($usuario),
                                        'idReceso' => utf8_encode($idReceso),
                                        'fechaInicial' => utf8_encode($fechaInicial),
                                        'horaInicial' => utf8_encode($horaInicial),
                                        'fechaFinal' => utf8_encode($fechaFinal),
                                        'horaFin' => utf8_encode($horaFin),
                                        'duracion' => utf8_encode($duracion),
                                        'duracionSeg' => utf8_encode($duracionSeg),
                                        'descTipoReceso' => utf8_encode($descTipoReceso)
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
    public function actualizarMovimientos($NombreUsuario,$fechaInicialGuardada,$horaInicialGuardada,$duracion,$duracionSeg)
    {
        $resultado = new Resultado();
        $consulta = "UPDATE  BSTNTRN.BTMPERSONAL "
                    ." SET BTMPERSONALFFIN = CURDATE() ,BTMPERSONALHFIN= current_time(),BTMPERSONALDUR= ?,BTMPERSONALDURS= ? "
                    ." WHERE SIOUSUARIOID= ? and BTMPERSONALFINI= ? and BTMPERSONALHINI= ? ";
                if($sentencia = $this->conexion->prepare($consulta))
                {
                    if($sentencia->bind_param("sssss",
                        $duracion,$duracionSeg,$NombreUsuario,$fechaInicialGuardada,$horaInicialGuardada
                        ))
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
    
}

