<?php
namespace php\repositorios;

use php\interfaces\IPostalesRepositorio;
use php\modelos\Postales;

include "../interfaces/IpostalesRepositorio.php";
include "../modelos/Postales.php";

class PostalesRepositorio implements IPostalesRepositorio
{
    protected $conexion;
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }
    
    public function insertar(Postales $postales)
    {     
        $resultado = "";
        $consulta = " INSERT INTO BSTNTRN.BTCPOSTAL"
                    . " (BTCPOSTALID, "
                    . " BTCPOSTALASENT, "
                    . " BTCPOSTALMPIO, "
                    . " BTCPOSTALESTADO, "
                    . " BTCPOSTALCIUDAD, "
                    . " BTCPOSTALIDN) "
                    . " VALUE( "
                    . " (SELECT MAX(IFNULL(BTCPOSTALID,0))+1 AS 'ID' FROM BSTNTRN.BTCPOSTAL ID),  "
                    . " '', ?, ?, ?, ?, ?) ";
                    $postales =$postales->id .' '. $postales->asentamiento.' '. $postales->municipio.' '. $postales->estado;
                    $postales =$postales->cuidad.' '. $postales->nopostal;
         if($sentencia = $this->conexion->prepare($consulta))
         {
             $sentencia->bind_param("ssssss",$postales->id,
                                             $postales->asentamiento, 
                                             $postales->municipio,
                                             $postales->estado,
                                             $postales->cuidad,
                                             $postales->nopostal);                
             $resultado = $sentencia->execute();           
         }else{
             echo "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
         }
         
        return $resultado;
    }
    
    public function eliminar(Postales $postales)
    {
        $resultado = "";
        $consulta = " DELETE FROM BSTNTRN.BTCPOSTAL "
                    . "  WHERE BTCPOSTALID  = ? ";
         if($sentencia = $this->conexion->prepare($consulta))
         {
             $sentencia->bind_param("i",$postales->id);
             $resultado = $sentencia->execute();           
         }else{
             echo "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
         }
        return $resultado;
    }

    public function actualizar(Postales $postales)
    {     
                
        $resultado = "";
        $consulta = " UPDATE BSTNTRN.BTCPOSTALES SET"
                    . " BTCPOSTALID=  ? , "
                    . " BTCPOSTALASENT=  ? , "
                    . " BTCPOSTALMPIO= ? , "
                    . " BTCPOSTALESTADO= ? , "
                    . " BTCPOSTALCIUDAD=? , "
                    . " BTCPOSTALIDN=? "
                    . "  WHERE BTCPOSTALID = ? ";
         if($sentencia = $this->conexion->prepare($consulta))
         {
             $sentencia->bind_param("ssssss",$postales->id,
                 $postales->asentamiento,
                 $postales->municipio,
                 $postales->estado,
                 $postales->cuidad,
                 $postales->nopostal);
             $resultado = $sentencia->execute();           
         }else{
             echo "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
         }
        return $resultado;        
    }
    
    public function consultar($id,$estado,$municipio)
    {
        
        $postales = array();
        $consulta =   " SELECT "
                    . " BTCPOSTALID id, "
                    . " BTCPOSTALASENT asentamiento, "
                    . " BTCPOSTALESTADO estado, "
                    . " BTCPOSTALMPIO municipio, "
                    . " BTCPOSTALCIUDAD ciudad, "
                    . " BTCPOSTALIDN nopostal "
                    . " FROM BSTNTRN.BTCPOSTAL  "
                    . " WHERE BTCPOSTALID like  CONCAT('%',?,'%') "
                    . " AND BTCPOSTALESTADO like  CONCAT('%',?,'%') "
                    . " AND BTCPOSTALCIUDAD like  CONCAT('%',?,'%') ";
        
        if($sentencia = $this->conexion->prepare($consulta))
        {
            $sentencia->bind_param("sss",$id,$estado,$municipio);
            if($sentencia->execute())
            {                
                if ($sentencia->bind_result($id, $asentamiento, $estado, $municipio, $ciudad, $nopostal)  )
                {                    
                    while($row = $sentencia->fetch())
                    {
                        $postal = (object) [
                            'id' =>  utf8_encode($id),
                            'asentamiento' => utf8_encode($asentamiento),
                            'estado' => utf8_encode($estado),
                            'municipio' => utf8_encode($municipio),
                            'ciudad' => utf8_encode($ciudad),
                            'nopostal' => utf8_encode($nopostal)
                        ];  
                        array_push($postales,$postal);
                    }
                }                
            }            
        }else{
            echo "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
        }
        return  $postales;
    }


    public function consultarPorId($id)
    {
        $postaless = array();
        $consulta =   " SELECT "
                   . " BTCPOSTALID id, "
                   . " BTCPOSTALASENT asentamiento, "
                   . " BTCPOSTALESTADO estado, "
                   . " BTCPOSTALMPIO municipio, "
                   . " BTCPOSTALCIUDAD ciudad, "
                   . " BTCPOSTALIDN nopostal, "
                   . " WHERE BTCPOSTALID  = ?";
        if($sentencia = $this->conexion->prepare($consulta))
        {
            $sentencia->bind_param("i",$id);
            if($sentencia->execute())
            {
                
                if ($sentencia->bind_result($id, $asentamiento, $estado, $municipio, $ciudad, $nopostal))
                {
                    
                    while($row = $sentencia->fetch())
                    {
                        $postales = new Postales();
                        $postales->id = utf8_encode($id);
                        $postales->asentamiento = utf8_encode($asentamiento);
                        $postales->estado = utf8_encode($estado);
                        $postales->municipio = utf8_encode($municipio);
                        $postales->ciudad = utf8_encode($ciudad);
                        $postales->nopostal = utf8_encode($nopostal);
                        array_push($postales,$postales);
                    }
                }
                
            }
            
        }else{
            echo "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
        }
        return $postales;
    }
    public function consultarNoPostal($noPostal)
    {}


    
}

