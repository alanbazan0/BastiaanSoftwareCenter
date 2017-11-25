<?php
namespace php\repositorios;

use Exception;
use php\interfaces\IVersionesRepositorio;
use php\modelos\Version;
use php\modelos\Resultado;


include "../interfaces/IVersionesRepositorio.php";
include "../modelos/Version.php";
include "../clases/Resultado.php";

class VersionesRepositorio implements IVersionesRepositorio
{
    protected $conexion;
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }
    
    public function calcularId()
    {   
        $resultado = new Resultado();
        $consulta =  "SELECT MAX(IFNULL(BTVERSIONID,0))+1 AS id FROM BSTNTRN.BTVERSION";
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
    
    public function insertar(Version $version)
    {            
        $resultado =  $this->calcularId();
        if($resultado->mensajeError=="")
        {
            $id = $resultado->valor;
            $consulta = " INSERT INTO BSTNTRN.BTVERSION"
                        . " (BTVERSIONID, "
                        . " BTVERSIONDSCC, "
                        . " BTVERSIONDSCL, "
                        . " BTVERSIONNOMP, "
                        . " BTVERSIONFECHA, "
                        . " BTVERSIONHORA) "
                        . " VALUE(?,?,?,?,?,?) ";
            if($sentencia = $this->conexion->prepare($consulta))
            {
                if( $sentencia->bind_param("isssss", $id,$version->descripcionCorta,                       
                                                         $version->descripcionLarga,
                                                         $version->nombrePila,
                                                         $version->fecha,
                                                         $version->hora))
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
    
    /* grid2 de criterios*/
    
    Public function insertarGrid2(Version $datos)
    {
   
            $consulta = " INSERT INTO BSTNTRN.BTCRITERIO"
                . "(BTVERSIONID, "
                . "  BTCAMPOID, "
                . "  BTCRITERIOPRESENTACION, "
                . "  BTCRITERIOORDEN, "
                . "  BTCRITERIOTITULO) "
                . "  VALUE(?,?,?,?,?) ";          
             if($sentencia = $this->conexion->prepare($consulta))
               {
                 if( $sentencia->bind_param("issss",
                                            $datos->version,
                                            $datos->campoId,
                                            $datos->presentacion,
                                            $datos->orden,
                                            $datos->titulo
                                            ))
                                                {
                                                if(!$sentencia->execute())
                                                    $resultado->mensajeError = "Falla la ejecucion (" . $this->conexion->errno . ") " . $this->conexion->error .$datos->campoId;
                                                }
                                            else
                                                $resultado->mensajeError = "Falla� el enlace de parametros";
                                         }
                                        
        return $resultado;
    } 

    public function eliminar($llaves)
    {
        $resultado = new Resultado();
        $consulta = " DELETE FROM BSTNTRN.BTCRITERIO"
                    . "  WHERE BTVERSIONID = ? ";
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

    public function actualizar(Version $version)
    {     
        $resultado = new Resultado();
        $consulta = " UPDATE BSTNTRN.BTVERSION SET"
                    . " BTVERSIONDSCC= ?, "
                    . " BTVERSIONDSCL= ?, "
                    . " BTVERSIONNOMP= ?, "
                    . " BTVERSIONFECHA= ?, "
                    . " BTVERSIONHORA = ? "
                    . " WHERE BTVERSIONID = ? ";   
                    
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("ssssss",$version->descripcionCorta,
                                               $version->descripcionLarga,
                                               $version->nombrePila,
                                               $version->fecha,
                                               $version->hora,
                                               $version->id))
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
    
    
    /* grid 3 */
    public function consultarPorCampo()
    {
        $resultado = new Resultado();
        $campos = array();
        
        $consulta = " SELECT "
            ." BTCAMPOID campoId, "
            ." BTCAMPONUMERO campoNumero, "
            ." BTTABLAID tablaId, "
            ." BTCAMPOTIPO tipoCampo, "
            ." BTCAMPOTAMANO tamanoCampo, "
            ." BTCAMPOTITULO tituloCampo " 
            ." FROM BSTNTRN.BTCAMPO ";
       if($sentencia = $this->conexion->prepare($consulta))
                     {
                        if(true)
                         {
                            if($sentencia->execute())
                               {
                                if ($sentencia->bind_result($campoId, $campoNumero, $tablaId, $tipoCampo, $tamanoCampo, $tituloCampo)  )
                                     {
                                        while($row = $sentencia->fetch())
                                          {
                                             $campo = (object) [
                                                 'campoId' => utf8_encode($campoId),
                                                 'campoNumero' =>  utf8_encode($campoNumero),
                                                 'tablaId' => utf8_encode($tablaId),
                                                 'tipoCampo' => utf8_encode($tipoCampo),
                                                 'tamanoCampo' => utf8_encode($tamanoCampo),
                                                 'tituloCampo' => utf8_encode($tituloCampo)
                                                                 ];
                                             array_push($campos,$campo);
                                          }
                                        $resultado->valor = $campos;
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
    /* fin */
    public function consultar($criteriosSeleccion)
    {     
        $resultado = new Resultado();
        $versiones = array();     
       
        $consulta =  " SELECT "
                     . " BTVERSIONID id, "
                     . " BTVERSIONDSCC descripcionCorta, "
                     . " BTVERSIONDSCL descripcionLarga, "
                     . " BTVERSIONNOMP nombrePila, "    
                     . " BTVERSIONFECHA fecha, "
                     . " BTVERSIONHORA hora "
                     . " FROM BSTNTRN.BTVERSION  "
                     . " WHERE BTVERSIONID like  CONCAT('%',?,'%') ";
                     
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("s",$criteriosSeleccion->id))
            {
                if($sentencia->execute())
                {                
                    if ($sentencia->bind_result($id, $descripcionCorta, $descripcionLarga, $nombrePila, $fecha, $hora)  )
                    {                    
                        while($row = $sentencia->fetch())
                        {
                            $version = (object) [
                                'id' => utf8_encode($id),
                                'descripcionCorta' =>  utf8_encode($descripcionCorta),
                                'descripcionLarga' => utf8_encode($descripcionLarga),
                                'nombrePila' => utf8_encode($nombrePila),
                                'fecha' => utf8_encode($fecha),
                                'hora' => utf8_encode($hora)
                            ];  
                            array_push($versiones,$version);
                        }
                        $resultado->valor = $versiones; 
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

    
    /* grid 2 */
   
    public function consultarPorVersion($criteriosVersion)
    {
        $resultado = new Resultado();
        $registros = array();
        
        $consulta =   " SELECT BTCRITERIOID id,CR.BTCAMPOID campoId, BTCRITERIOORDEN orden, BTCRITERIOPRESENTACION presentacion, BTCRITERIOTITULO titulo, BTTABLAID tablaId, BTCAMPOTIPO tipoDato, BTCAMPOTAMANO tamano " .
                        "FROM BSTNTRN.BTCRITERIO CR ".
                        "   INNER JOIN BSTNTRN.BTCAMPO C ON CR.BTCAMPOID = C.BTCAMPOID " .
                        "WHERE BTVERSIONID = ? ".
                        "ORDER BY BTCRITERIOORDEN";
        
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("i",$criteriosVersion->id))
            {
                if($sentencia->execute())
                {
                    if ($sentencia->bind_result($id, $campoId, $orden, $presentacion, $titulo,  $tablaId, $tipoDato, $tamano))
                    {
                        while($sentencia->fetch())
                        {
                            $registro = (object) [
                                'id' =>  utf8_encode($id),
                                'campoId' => utf8_encode($campoId),
                                'orden' => utf8_encode($orden),
                                'presentacion' => utf8_encode($presentacion),
                                'titulo' => utf8_encode($titulo),
                                'tablaId' => utf8_encode($tablaId),
                                'tipoDato' => utf8_encode($tipoDato),
                                'tamano' => utf8_encode($tamano)
                            ];
                            array_push($registros,$registro);
                        }
                        $resultado->valor = $registros;
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
                     . " BTVERSIONID id, "
                     . " BTVERSIONDSCC descripcionCorta, "
                     . " BTVERSIONDSCL descripcionLarga, "
                     . " BTVERSIONNOMP nombrePila, "
                     . " BTVERSIONFECHA fecha, "
                     . " BTVERSIONHORA hora "
                     . " FROM BTVERSION "
                     . " WHERE BTVERSIONID = ?";
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("i",$llaves->id))
            {
                if($sentencia->execute())
                {                    
                    if ($sentencia->bind_result($id, $descripcionCorta, $descripcionLarga, $nombrePila, $fecha, $hora))
                    {                        
                        if($sentencia->fetch())
                        {
                            $version = new Version();
                            $version->id =  utf8_encode($id);
                            $version->descripcionCorta = utf8_encode($descripcionCorta);
                            $version->descripcionLarga = utf8_encode($descripcionLarga);
                            $version->nombrePila = utf8_encode($nombrePila);
                            $version->fecha = utf8_encode($fecha);
                            $version->hora = utf8_encode($hora);
                            $resultado->valor = $version;                           
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

