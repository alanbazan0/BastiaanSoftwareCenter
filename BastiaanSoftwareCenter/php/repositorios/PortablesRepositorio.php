<?php
namespace php\repositorios;

use Exception;
use php\interfaces\IPortablesRepositorio;
use php\modelos\Portable;
use php\modelos\Resultado;


include "../interfaces/IPortablesRepositorio.php";
include "../modelos/Portable.php";
include "../clases/Resultado.php";

class PortablesRepositorio implements IPortablesRepositorio
{
    protected $conexion;
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }
    
    public function calcularId()
    {
        $resultado = new Resultado();
        $consulta =  "SELECT MAX(IFNULL(BTCPORTABILIDADSERIEID,0))+1 AS idConsecutivo FROM BSTNTRN.BTCPORTABILIDAD";
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->execute())
            {
                if ($sentencia->bind_result($idConsecutivo))
                {
                    if($sentencia->fetch())
                    {
                        $resultado->valor = $idConsecutivo;
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
    
    public function insertar(Portable $portable)
    {
        $resultado =  $this->calcularId();
        if($resultado->mensajeError=="")
        {
            $idConsecutivo = $resultado->valor;
            $consulta = " INSERT INTO BSTNTRN.BTCPORTABILIDAD "
                    . " (BTCPORTABILIDADNIRID, "
                    . " BTCPORTABILIDADSERIEID, "
                    . " BTCPORTABILIDADNUM, "
                    . " BTCPORTABILIDADCIA, "
                    . " BTCPORTABILIDADPOB, "
                    . " BTCPORTABILIDADMPIO, "
                        . " BTCPORTABILIDADEDO) "
                            . " VALUE(?,?,?,?,?,?,?) ";
                            if($sentencia = $this->conexion->prepare($consulta))
                            {
                                if( $sentencia->bind_param("sisssss",$portable->idMunicipio,
                                    $idConsecutivo,
                                    $portable->numeroPortabilidad,
                                    $portable->descripcionPortabilidad,
                                    $portable->ciudadPortabilidad,
                                    $portable->municipioPortabilidad,
                                    $portable->estadoPortabilidad))
                                {
                                    if(!$sentencia->execute())
                                        $resultado->mensajeError = "Fall� la ejecuci�n (" . $this->conexion->errno . ") " . $this->conexion->error;
                                }
                                else
                                    $resultado->mensajeError = "Fall� el enlace de parámetros";
                            }
                            else
                                $resultado->mensajeError = "Fall� la preparaci�n: (" . $this->conexion->errno . ") " . $this->conexion->error;
        }
        return $resultado;
    }
    
    public function eliminar($llaves)
    {
        $resultado = new Resultado();
        $consulta = " DELETE FROM BSTNTRN.BTCPORTABILIDAD "
            . "  WHERE BTCPORTABILIDADSERIEID  = ? ";
            if($sentencia = $this->conexion->prepare($consulta))
            {
                if($sentencia->bind_param("i",$llaves->idConsecutivo))
                {
                    if($sentencia->execute())
                    {
                        $resultado->valor = $llaves->idConsecutivo;
                    }
                    else
                        $resultado->mensajeError = "Fall� la ejecuci�n (" . $this->conexion->errno . ") " . $this->conexion->error;
                }
                else
                    $resultado->mensajeError = "Fall� el enlace de parámetros";
            }
            else
                $resultado->mensajeError = "Fall� la preparaci�n: (" . $this->conexion->errno . ") " . $this->conexion->error;
                
                return $resultado;
    }
    
    public function actualizar(Portable $portable)
    {
        $resultado = new Resultado();
        $consulta = " UPDATE BSTNTRN.BTCPORTABILIDAD SET"
        . " BTCPORTABILIDADNIRID = ?, "
                . " BTCPORTABILIDADNUM = ?, "
                    . " BTCPORTABILIDADCIA = ?, "
                        . " BTCPORTABILIDADPOB = ?, "
                            . " BTCPORTABILIDADMPIO = ?, "
                                . " BTCPORTABILIDADEDO = ? "
                    . " WHERE BTCPORTABILIDADSERIEID = ? ";
                    if($sentencia = $this->conexion->prepare($consulta))
                    {
                        if( $sentencia->bind_param("sssssss",$portable->idMunicipio,
                            $portable->numeroPortabilidad,
                            $portable->descripcionPortabilidad,
                            $portable->ciudadPortabilidad,
                            $portable->municipioPortabilidad,
                            $portable->estadoPortabilidad,
                            $portable->idConsecutivo))
                        {
                            if($sentencia->execute())
                            {
                                $resultado->valor=true;
                            }
                            else
                                $resultado->mensajeError = "Fall� la ejecuci�n (" . $this->conexion->errno . ") " . $this->conexion->error;
                        }
                        else  $resultado->mensajeError = "Fall� el enlace de par�metros";
                    }
                    else
                        $resultado->mensajeError = "Fall� la preparaci�n: (" . $this->conexion->errno . ") " . $this->conexion->error;
                        return $resultado;
    }
    
    public function consultar($criteriosSeleccion)
    {
        $resultado = new Resultado();
        $portables = array();
        
        $consulta =   " SELECT "
            . " BTCPORTABILIDADNIRID idMunicipio, "
            . " BTCPORTABILIDADSERIEID idConsecutivo, "
            . " BTCPORTABILIDADNUM numeroPortabilidad, "
            . " BTCPORTABILIDADCIA descripcionPortabilidad, "
            . " BTCPORTABILIDADPOB ciudadPortabilidad, "
            . " BTCPORTABILIDADMPIO municipioPortabilidad, "
            . " BTCPORTABILIDADEDO estadoPortabilidad "
            . " FROM BSTNTRN.BTCPORTABILIDAD  "
            . " WHERE BTCPORTABILIDADNIRID like  CONCAT('%',?,'%') "
            . " AND BTCPORTABILIDADSERIEID like  CONCAT('%',?,'%') ";
       if($sentencia = $this->conexion->prepare($consulta))
 {
 if($sentencia->bind_param("ss",$criteriosSeleccion->idMunicipio,$criteriosSeleccion->idConsecutivo))
    {
                                        if($sentencia->execute())
                                        {
                                            if ($sentencia->bind_result($idMunicipio, $idConsecutivo, $numeroPortabilidad, $descripcionPortabilidad, $ciudadPortabilidad, $municipioPortabilidad, $estadoPortabilidad )  )
                                            {
                                                while($row = $sentencia->fetch())
                                                {
                                                    $portable = (object) [
                                                        'idMunicipio' =>  utf8_encode($idMunicipio),
                                                        'idConsecutivo' =>  utf8_encode($idConsecutivo),
                                                        'numeroPortabilidad' => utf8_encode($numeroPortabilidad),
                                                        'descripcionPortabilidad' =>  utf8_encode($descripcionPortabilidad),
                                                        'ciudadPortabilidad' =>  utf8_encode($ciudadPortabilidad),
                                                        'municipioPortabilidad' => utf8_encode($municipioPortabilidad),
                                                        'estadoPortabilidad' => utf8_encode($estadoPortabilidad)
                                                    ];
                                                    array_push($portables,$portable);
                                                }
                                                $resultado->valor = $portables;
                                            }
                                            else
                                                $resultado->mensajeError = "Fall� el enlace del resultado.";
                                        }
                                        else
                                            $resultado->mensajeError = "Fall� la ejecuci�n (" . $this->conexion->errno . ") " . $this->conexion->error;
                                    }
                                    else
                                        $resultado->mensajeError = "Fall� el enlace de par�metros";
                                }
                                else
                                    $resultado->mensajeError = "Fall� la preparaci�n: (" . $this->conexion->errno . ") " . $this->conexion->error;
                                    
                                    
                                    return $resultado;
    }
    
    public function consultarPorLlaves($llaves)
    {
        $resultado = new Resultado();
        $consulta =   " SELECT "
        . " BTCPORTABILIDADNIRID idMunicipio, "
            . " BTCPORTABILIDADSERIEID idConsecutivo, "
                . " BTCPORTABILIDADNUM numeroPortabilidad, "
                    . " BTCPORTABILIDADCIA descripcionPortabilidad, "
                        . " BTCPORTABILIDADPOB ciudadPortabilidad, "
                            . " BTCPORTABILIDADMPIO municipioPortabilidad, "
                                . " BTCPORTABILIDADEDO estadoPortabilidad "
                                    . " FROM BSTNTRN.BTCPORTABILIDAD  "
                            . " WHERE BTCPORTABILIDADSERIEID  = ?";
                            if($sentencia = $this->conexion->prepare($consulta))
                            {
                                if($sentencia->bind_param("i",$llaves->idConsecutivo))
                                {
                                    if($sentencia->execute())
                                    {
                                        if ($sentencia->bind_result($idMunicipio, $idConsecutivo, $numeroPortabilidad, $descripcionPortabilidad, $ciudadPortabilidad, $municipioPortabilidad, $estadoPortabilidad )  )
                                        {
                                            if($sentencia->fetch())
                                            {
                                                $portable = new Portable();
                                                $portable->idMunicipio = utf8_encode($idMunicipio);
                                                $portable->idConsecutivo = utf8_encode($idConsecutivo);
                                                $portable->numeroPortabilidad = utf8_encode($numeroPortabilidad);
                                                $portable->descripcionPortabilidad = utf8_encode($descripcionPortabilidad);
                                                $portable->ciudadPortabilidad = utf8_encode($ciudadPortabilidad);
                                                $portable->municipioPortabilidad = utf8_encode($municipioPortabilidad);
                                                $portable->estadoPortabilidad = utf8_encode($estadoPortabilidad);
                                                $resultado->valor = $portable;
                                            }
                                            else
                                                $resultado->mensajeError = "No se encontr� ning�n resultado.";
                                        }
                                        else
                                            $resultado->mensajeError = "Fall� el enlace del resultado";
                                    }
                                    else
                                        $resultado->mensajeError = "Fall� la ejecuci�n (" . $this->conexion->errno . ") " . $this->conexion->error;
                                }
                                else
                                    $resultado->mensajeError = "Fall� el enlace de par�metros";
                            }
                            else
                                $resultado->mensajeError = "Fall� la preparaci�n: (" . $this->conexion->errno . ") " . $this->conexion->error;
                                return $resultado;
    }
    
    public function consultarPortabilidad($criteriosSeleccion)
    {
        $resultado = new Resultado();
        $portables = array();
        
        $consulta = "SELECT "
            . " BTCPORTABILIDADNIRID idMunicipio, "
            . " BTCPORTABILIDADSERIEID idConsecutivo, "
            . " BTCPORTABILIDADNUM numeroPortabilidad, "
            . " BTCPORTABILIDADCIA descripcionPortabilidad, "
            . " BTCPORTABILIDADPOB ciudadPortabilidad, "
            . " BTCPORTABILIDADMPIO municipioPortabilidad, "
            . " BTCPORTABILIDADEDO estadoPortabilidad, "
            . " BTCPORTABILIDADTRED redPortabilidad, "
            ." (CASE WHEN SUBSTRING(?, 1, 2) = 55 THEN 'LOCAL' ELSE 'FORANEO' END) tipoLlamadaPortabilidad "
            ." FROM BSTNTRN.BTCPORTABILIDAD "
            ." WHERE BTCPORTABILIDADNIRSERIE =  SUBSTRING(?, 1, 6) "
            ." AND (SUBSTRING(?, 7, 10) between BTCPORTABILIDADNUMINI  and BTCPORTABILIDADNUMFIN )";
                                                        
                
                if($sentencia = $this->conexion->prepare($consulta))
                {
                    if($sentencia->bind_param("sss",$criteriosSeleccion,$criteriosSeleccion,$criteriosSeleccion))
                    {
                        if($sentencia->execute())
                        {
                            if ($sentencia->bind_result($idMunicipio, $idConsecutivo, $numeroPortabilidad, $descripcionPortabilidad, $ciudadPortabilidad, $municipioPortabilidad, $estadoPortabilidad, $redPortabilidad, $tipoLlamadaPortabilidad )  )
                            {
                                while($row = $sentencia->fetch())
                                {
                                    $portable = (object) [
                                        'idMunicipio' =>  utf8_encode($idMunicipio),
                                        'idConsecutivo' =>  utf8_encode($idConsecutivo),
                                        'numeroPortabilidad' => utf8_encode($numeroPortabilidad),
                                        'descripcionPortabilidad' =>  utf8_encode($descripcionPortabilidad),
                                        'ciudadPortabilidad' =>  utf8_encode($ciudadPortabilidad),
                                        'municipioPortabilidad' => utf8_encode($municipioPortabilidad),
                                        'estadoPortabilidad' => utf8_encode($estadoPortabilidad),
                                        'redPortabilidad' => utf8_encode($redPortabilidad),
                                        'tipoLlamadaPortabilidad' => utf8_encode($tipoLlamadaPortabilidad)
                                    ];
                                    array_push($portables,$portable);
                                }
                                $resultado->valor = $portables;
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
    
    
}

