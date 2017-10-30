<?php
namespace php\repositorios;

use php\interfaces\IGenerosRepositorio;
use php\modelos\Genero;


include "../interfaces/IGenerosRepositorio.php";
include "../modelos/Genero.php";

class GenerosRepositorio implements IGenerosRepositorio
{

    protected $conexion;
     public function __construct($conexion)
     {
        $this->conexion = $conexion;
      }
    
   
    
    public function insertar(Genero $genero)
       {     
       
         $resultado = "";
          $consulta = " INSERT INTO BSTNTRN.BTGENERO "
                    . " (BTGENEROID, "
                    . " BTGENERONOMC, "
                    . " BTGENERONOML) "
                    . " VALUES(?,?,?) ";
         if($sentencia = $this->conexion->prepare($consulta))
         {
             $sentencia->bind_param("sss",$genero->nombre,
                                          $genero->nombreSegundo,
                                          $genero->apellidoPaterno);                
             $resultado = $sentencia->execute();           
         }
         else
         {
             echo "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
         }
        return $genero;
    }
    
    public function eliminar(Genero $genero)
    {
        $resultado = "";
        $consulta = " DELETE FROM BSTNTRN.BTGENERO "
                    . "  WHERE BTGENEROID  = ? ";
         if($sentencia = $this->conexion->prepare($consulta))
         {
             $sentencia->bind_param("s",$genero->nombre);
             $resultado = $sentencia->execute();           
         }else{
             echo "Fall� la preparaci�n: (" . $this->conexion->errno . ") " . $this->conexion->error;
         }
        return $resultado;
    }

    public function actualizar(Genero $genero)
    {     
        $resultado = "";
        $consulta = " UPDATE BSTNTRN.BTGENERO SET"
                    . " BTGENERONOMC=  ? , "
                    . " BTGENERONOML=?  "
                    . " WHERE BTGENEROID  = ? ";
         if($sentencia = $this->conexion->prepare($consulta))
         {
             $sentencia->bind_param("ss",$genero->nombreSegundo,
                                         $genero->apellidoPaterno);                
             $resultado = $sentencia->execute();           
         }else{
             echo "Fall� la preparaci�n: (" . $this->conexion->errno . ") " . $this->conexion->error;
         }
        return $resultado;        
    }
    
  
    public function consultar($nombre,$nombreSegundo,$apellidoPaterno)
    {
        $generos = array();
        $consulta =   " SELECT "
                    . " BTGENEROID nombre, "
                    . " BTGENERONOMC nombreSegundo, "
                    . " BTGENERONOML apellidoPaterno "
                    . " FROM BSTNTRN.BTGENERO "
                    . " WHERE BTGENEROID like  CONCAT('%',?,'%') "
                    . " AND BTGENERONOMC like  CONCAT('%',?,'%') "
                    . " AND BTGENERONOML like  CONCAT('%',?,'%') ";
        if($sentencia = $this->conexion->prepare($consulta))
        {
            $sentencia->bind_param("sss",$nombre,$nombreSegundo,$apellidoPaterno);
            if($sentencia->execute())
            {                
                if ($sentencia->bind_result($nombre, $nombreSegundo, $apellidoPaterno)  )
                {                    
                    while($row = $sentencia->fetch())
                    {
                        $genero = (object) [
                            'nombre' => utf8_encode($nombre),
                            'nombreSegundo' => utf8_encode($nombreSegundo),
                            'apellidoPaterno' => utf8_encode($apellidoPaterno)
                        ];  
                        array_push($generos,$genero);
                    }
                }                
            }            
        }else{
            echo "Fall� la preparaci�n: (" . $this->conexion->errno . ") " . $this->conexion->error;
        }
        return  $generos;
    }

    public function consultarPorNombre($nombre)
    {
        $generos = array();
        $consulta =   " SELECT "
                          . " BTGENEROID nombre, "
                          . " BTGENERONOMC nombreSegundo, "
                          . " BTGENERONOML apellidoPaterno "
                          . " FROM BSTNTRN.BTGENERO "
                          . " WHERE BTGENEROID like  CONCAT('%',?,'%') ";
        
        if($sentencia = $this->conexion->prepare($consulta))
        {
            $sentencia->bind_param("s",$nombre);
            if($sentencia->execute())
            {
                
                if ($sentencia->bind_result($nombre, $nombreSegundo, $apellidoPaterno )  )
                {
                    
                    while($row = $sentencia->fetch())
                    {
                        $genero = new Genero();
                        $genero->nombre = utf8_encode($nombre);
                        $genero->nombreSegundo = utf8_encode($nombreSegundo);
                        $genero->apellidoPaterno = utf8_encode($apellidoPaterno);  
                        array_push($generos,$genero);
                    }
                }
                
            }
            
        }else{
            echo "Fall� la preparaci�n: (" . $this->conexion->errno . ") " . $this->conexion->error;
        }
        return $generos;
    }

    public function consultarPorId($nombre)
    {
        $generos = array();
        $consulta =   " SELECT "
            . " BTGENEROID nombre, "
                . " BTGENERONOMC nombreSegundo, "
                    . " BTGENERONOML apellidoPaterno "
                        . " FROM BSTNTRN.BTGENERO "
                            . " WHERE BTGENEROID like  CONCAT('%',?,'%') ";
                            
                            if($sentencia = $this->conexion->prepare($consulta))
                            {
                                $sentencia->bind_param("s",$nombre);
                                if($sentencia->execute())
                                {
                                    
                                    if ($sentencia->bind_result($nombre, $nombreSegundo, $apellidoPaterno )  )
                                    {
                                        
                                        while($row = $sentencia->fetch())
                                        {
                                            $genero = new Genero();
                                            $genero->nombre = utf8_encode($nombre);
                                            $genero->nombreSegundo = utf8_encode($nombreSegundo);
                                            $genero->apellidoPaterno = utf8_encode($apellidoPaterno);
                                            array_push($generos,$genero);
                                        }
                                    }
                                    
                                }
                                
                            }else{
                                echo "Fall� la preparaci�n: (" . $this->conexion->errno . ") " . $this->conexion->error;
                            }
                            return $generos;
    }


    
}

