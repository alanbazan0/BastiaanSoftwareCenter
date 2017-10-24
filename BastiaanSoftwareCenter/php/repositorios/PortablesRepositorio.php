<?php
namespace php\repositorios;

use php\interfaces\IPortablesRepositorio;
use php\modelos\Portables;

include "../interfaces/IPortablesRepositorio.php";    
include "../modelos/Portables.php";


class PortablesRepositorio implements IPortablesRepositorio
{
    protected $conexion;
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }
    
    
    public function insertar(Portables $portables)
    {
        $resultado = "";
        $consulta = " INSERT INTO BSTNTRN.BTCPORTABILIDAD"    
             . " BTCPORTABILIDADSERIEID, "
             . " BTCPORTABILIDADNUM, "
             . " BTCPORTABILIDADMPIO, "
             . " BTCPORTABILIDADCIA, "
             . " BTCPORTABILIDADPOB, "
             . " BTCPORTABILIDADEDO) "            
            . " VALUES( "
            . " (SELECT MAX(IFNULL(BTCPORTABILIDADNIRID,0))+1 AS 'ID' FROM BSTNTRN.BTCPORTABILIDAD ID),  "
            . "?, ?, ?, ?, ?) ";
                  $portables->consecutivo.' '. $portables->numero.' '. $portables->descripcion;
                                            $portables =$portables->poblacion.' '. $portables->municicipio.' '.$portables->estado;
                                            if($sentencia = $this->conexion->prepare($consulta))
                                            {
                                                $sentencia->bind_param("sssss",
                                                    $portables->consecutivo,
                                                    $portables->numero,
                                                    $portables->descripcion,
                                                    $portables->poblacion,
                                                    $portables->municipio,
                                                    $portables->estado);
                                                $resultado = $sentencia->execute();
                                            }else{
                                                echo "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
                                            }
                                            
                                            return $resultado;
    }
    
    public function eliminar(portables $portables)
    {
        $resultado = "";
        $consulta = " DELETE FROM BSTNTRN.BTCPORTABILIDAD "
            . "  WHERE BTCPORTABILIDADNIRID  = ? ";
            if($sentencia = $this->conexion->prepare($consulta))
            {
                $sentencia->bind_param("i",$portables->id);
                $resultado = $sentencia->execute();
            }else{
                echo "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
            }
            return $resultado;
    }
    
    public function actualizar(portables $portables)
    {
        
        $resultado = "";
        $consulta = " UPDATE BSTNTRN.BTCPORTABILIDAD SET"
                . " BTCPORTABILIDADSERIEID= ?, "
                . " BTCPORTABILIDADNUM= ? , "
                . " BTCPORTABILIDADMPIO= ? , "
                . " BTCPORTABILIDADCIA= ? , "
                . " BTCPORTABILIDADPOB= ? , "
                . " BTCPORTABILIDADEDO) "       
                . "  WHERE BTCPORTABILIDADNIRID = ? ";
                $portables->consecutivo.' '.$portables->numero.' '. $portables->descripcion;
                $portables =$portables->poblacion.' '. $portables->municicipio.' '.$portables->estado;
               
                if($sentencia = $this->conexion->prepare($consulta))
                   {
                    $sentencia->bind_param("ssssss",
                        $portables->consecutivo,
                        $portables->numero,
                        $portables->descripcion,
                        $portables->poblacion,
                        $portables->municipio,
                        $portables->estado);
                                        $resultado = $sentencia->execute();
                                    }else{
                                        echo "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
                                    }
                                    return $resultado;
    }
  
    public function consultar($id,$estado,$municipio)
    {
        
        $portables = array();
        $consulta =   " SELECT "
                    . " BTCPORTABILIDADNIRID id, "
                    . " BTCPORTABILIDADSERIEID consecutivo, "
                    . " BTCPORTABILIDADNUM numero, "
                    . " BTCPORTABILIDADMPIO municipio, "
                    . " BTCPORTABILIDADCIA descripcion, "
                    . " BTCPORTABILIDADPOB poblacion, "
                    . " BTCPORTABILIDADEDO estado "                                   
                    . " FROM BSTNTRN.BTCPORTABILIDAD "
                    . " WHERE BTCPORTABILIDADNIRID like  CONCAT('%',?,'%') "
                    . " AND BTCPORTABILIDADEDO like  CONCAT('%',?,'%') "
                    . " AND BTCPORTABILIDADMPIO like  CONCAT('%',?,'%') ";
        
        if($sentencia = $this->conexion->prepare($consulta))
        {
            $sentencia->bind_param("sss",$id,$estado,$municipio);
            if($sentencia->execute())
            {                
                if ($sentencia->bind_result($id, $consecutivo, $numero, $municipio, $descripcion, $poblacion, $estado)  )
                {                    
                    while($row = $sentencia->fetch())
                    {
                        $porta = (object) [
                            'id' =>  utf8_encode($id),
                            'consecutivo' => utf8_encode($consecutivo),
                            'numero' => utf8_encode($numero),
                            'municipio' => utf8_encode($municipio),
                            'descripcion' => utf8_encode($descripcion),
                            'poblacion' => utf8_encode($poblacion),
                            'estado' => utf8_encode($estado)
                        ];  
                        array_push($portables,$porta);
                    }
                }                
            }            
        }else{
            echo "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
        }
        return  $portables;
    }


    public function consultarPorId($id)
    {
        $portables = array();
        $consulta =   " SELECT "
                   . " BTCPORTABILIDADSERIEID consecutivo, "
                   . " BTCPORTABILIDADNUM numero, "
                   . " BTCPORTABILIDADMPIO municipio, "
                   . " BTCPORTABILIDADCIA descripcion, "
                   . " BTCPORTABILIDADPOB poblacion, "
                   . " BTCPORTABILIDADEDO estado) "                  
                   . " WHERE BTCPORTABILIDADNIRID  = ?";
        if($sentencia = $this->conexion->prepare($consulta))
        {
            $sentencia->bind_param("i",$id);
            if($sentencia->execute())
            {
                
                if ($sentencia->bind_result($id, $consecutivo, $numero, $municipio, $descripcion, $poblacion, $estado))
                {
                    
                    while($row = $sentencia->fetch())
                    {
                        $portables = new Portables();
                        $portable->consecutivo = utf8_encode($consecutivo);
                        $portable->numero = utf8_encode($numero);
                        $portable->municipio = utf8_encode($municipio);
                        $portable->descripcion = utf8_encode($descripcion);
                        $portable->poblacion = utf8_encode($poblacion);
                        $portable->estado = utf8_encode($estado);
                        array_push($portables,$portable);
                    }
                }
                
            }
            
        }else{
            echo "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
        }
        return $portables;
    }
    public function consultarConsecutivo($consecutivo)
    {}


    
}

