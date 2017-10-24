<?php
namespace php\repositorios;

use php\Interfaces\IGenerosRepositorio;
use php\modelos\Generos;


include "../interfaces/IGenerosRepositorio.php";    
include "../modelos/Generos.php";


class GenerosRepositorio implements IGenerosRepositorio
{
    protected $conexion;
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }
    
    
    public function insertar(Generos $generos)
    {
        $resultado = "";
        $consulta = " INSERT INTO BSTNTRN.BTGENERO"              
             . " BTGENERONOMC, "
             . " BTGENERONOML) "                   
             . " VALUES( "
             . " (SELECT MAX(IFNULL(BTCPORTABILIDADNIRID,0))+1 AS 'ID' FROM BSTNTRN.BTCPORTABILIDAD ID),  "
             . " ?, ?) ";
                $generos->gcorto.'  '.$generos->glargo;
               if($sentencia = $this->conexion->prepare($consulta))
                 {
                  $sentencia->bind_param("ss",$generos->id,
                  $generos->gcorto,
                  $generos->glargo);
                  $resultado = $sentencia->execute();
                  }else{
                          echo "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
                       }
                                            
                   return $resultado;
    }
    
    public function eliminar(Generos $generos)
    {
        $resultado = "";
        $consulta = " DELETE FROM BSTNTRN.BTGENERO "
            . "  WHERE BTGENEROID = ? ";
            if($sentencia = $this->conexion->prepare($consulta))
            {
                $sentencia->bind_param("i",$generos->id);
                $resultado = $sentencia->execute();
            }else{
                echo "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
            }
            return $resultado;
    }
    
    public function actualizar(Generos $generos)
    {
        
        $resultado = "";
        $consulta = " UPDATE BSTNTRN.BTGENERO SET"
                . " BTGENERONOMC= ? , "
                . " BTGENERONOML) "       
                . "  WHERE BTGENEROID = ? ";
                if($sentencia = $this->conexion->prepare($consulta))
                   {
                    $sentencia->bind_param("ss",$generos->id,
                        $generos->gcorto,
                        $generos->glargo);
                                        $resultado = $sentencia->execute();
                                    }else{
                                        echo "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
                                    }
                                    return $resultado;
    }
  
    public function consultar($id,$gcorto,$glargo)
    {
        
        $generos = array();
        $consulta =   " SELECT "
                    . " BTGENEROID id, "
                    . " BTGENERONOMC gcorto, "
                    . " BTGENERONOML glargo "        
                    . " FROM BSTNTRN.BTGENERO "
                    . " WHERE BTGENEROID like  CONCAT('%',?,'%') "
                    . " AND BTGENERONOMC like  CONCAT('%',?,'%') "
                    . " AND BTGENERONOML like  CONCAT('%',?,'%') ";
        
        if($sentencia = $this->conexion->prepare($consulta))
        {
            $sentencia->bind_param("sss",$id,$gcorto,$glargo);
            if($sentencia->execute())
            {                
                if ($sentencia->bind_result($id, $gcorto, $glargo)  )
                {                    
                    while($row = $sentencia->fetch())
                    {
                        $genero = (object) [
                            'id' =>  utf8_encode($id),
                            'gcorto' =>  utf8_encode($gcorto),
                            'glargo' =>  utf8_encode($glargo)                            
                        ];  
                        array_push($generos,$genero);
                    }
                }                
            }            
        }else{
            echo "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
        }
        return  $generos;
    }


    public function consultarPorId($id)
    {
        $generos = array();
        $consulta =   " SELECT "
                   . " BTGENEROID id, "
                   . " BTGENERONOMC gcorto, "
                   . " BTGENERONOML glargo) "                  
                   . " WHERE BTGENEROID  = ?";
        if($sentencia = $this->conexion->prepare($consulta))
        {
            $sentencia->bind_param("i",$id);
            if($sentencia->execute())
            {
                
                if ($sentencia->bind_result($id, $gcorto, $glargo))
                {
                    
                    while($row = $sentencia->fetch())
                    {
                        $generos = new Generos();
                        $generos->id = utf8_encode($id);
                        $generos->gcorto = utf8_encode($gcorto);
                        $generos->glargo = utf8_encode($glargo);                       
                        array_push($generos,$generos);
                    }
                }
                
            }
            
        }else{
            echo "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
        }
        return $generos;
    }
public function consultargcorto ($gcorto)
{}   
}

