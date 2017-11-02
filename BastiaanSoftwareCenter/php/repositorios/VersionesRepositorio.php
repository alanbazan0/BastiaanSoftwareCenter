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
                if( $sentencia->bind_param("isssss", $id,$version->versionDescripcionCorta,                       
                                                         $version->versionDescripcionLarga,
                                                         $version->versionNombrePrincipal,
                                                         $version->versionFecha,
                                                         $version->versionHora))
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
        $consulta = " DELETE FROM BSTNTRN.BTVERSION "
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
            if($sentencia->bind_param("ssssss",$version->versionDescripcionCorta,
                                               $version->versionDescripcionLarga,
                                               $version->versionNombrePrincipal,
                                               $version->versionFecha,
                                               $version->versionHora,
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
    
    public function consultar($criteriosSeleccion)
    {     
        $resultado = new Resultado();
        $versiones = array();     
       
        $consulta =  " SELECT "
                     . " BTVERSIONID id, "
                     . " BTVERSIONDSCC versionDescripcionCorta, "
                     . " BTVERSIONDSCL versionDescripcionLarga, "
                     . " BTVERSIONNOMP versionNombrePrincipal, "    
                     . " BTVERSIONFECHA versionFecha, "
                     . " BTVERSIONHORA versionHora "
                     . " FROM BSTNTRN.BTVERSION  "
                     . " WHERE BTVERSIONID like  CONCAT('%',?,'%') ";
                     
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("s",$criteriosSeleccion->id))
            {
                if($sentencia->execute())
                {                
                    if ($sentencia->bind_result($id, $versionDescripcionCorta, $versionDescripcionLarga, $versionNombrePrincipal, $versionFecha, $versionHora)  )
                    {                    
                        while($row = $sentencia->fetch())
                        {
                            $version = (object) [
                                'id' => utf8_encode($id),
                                'versionDescripcionCorta' =>  utf8_encode($versionDescripcionCorta),
                                'versionDescripcionLarga' => utf8_encode($versionDescripcionLarga),
                                'versionNombrePrincipal' => utf8_encode($versionNombrePrincipal),
                                'versionFecha' => utf8_encode($versionFecha),
                                'versionHora' => utf8_encode($versionHora)
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

    public function consultarPorLlaves($llaves)
    {
        
        $resultado = new Resultado();       
        $consulta =   " SELECT "
                     . " BTVERSIONID id, "
                     . " BTVERSIONDSCC versionDescripcionCorta, "
                     . " BTVERSIONDSCL versionDescripcionLarga, "
                     . " BTVERSIONNOMP versionNombrePrincipal, "
                     . " BTVERSIONFECHA versionFecha, "
                     . " BTVERSIONHORA versionHora "
                     . " FROM BTVERSION "
                     . " WHERE BTVERSIONID = ?";
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("i",$llaves->id))
            {
                if($sentencia->execute())
                {                    
                    if ($sentencia->bind_result($id, $versionDescripcionCorta, $versionDescripcionLarga, $versionNombrePrincipal, $versionFecha, $versionHora))
                    {                        
                        if($sentencia->fetch())
                        {
                            $version = new Version();
                            $version->id =  utf8_encode($id);
                            $version->versionDescripcionCorta = utf8_encode($versionDescripcionCorta);
                            $version->versionDescripcionLarga = utf8_encode($versionDescripcionLarga);
                            $version->versionNombrePrincipal = utf8_encode($versionNombrePrincipal);
                            $version->versionFecha = utf8_encode($versionFecha);
                            $version->versionHora = utf8_encode($versionHora);
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

