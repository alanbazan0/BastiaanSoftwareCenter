<?php
namespace php\repositorios;

use Exception;

use php\interfaces\IClientesTelefonosRepositorio;
use php\modelos\ClienteTelefono;
use php\modelos\Resultado;


include "../interfaces/IClientesTelefonosRepositorio.php";
include "../modelos/ClienteTelefono.php";
include "../clases/Resultado.php";


class ClientesTelefonosRepositorio implements IClientesTelefonosRepositorio

{
    protected $conexion;
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }
    
    public function calcularId()
    {   
       
        $resultado = new Resultado();
        $consulta =  "SELECT MAX(IFNULL(BTCLIENTETELCONSID,0))+1 AS id FROM BSTNTRN.BTCLIENTETEL";
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
    
    public function insertar(ClienteTelefono $clientetelefono)
    {            
        $resultado =  $this->calcularId();
        if($resultado->mensajeError=="")
        {
            $id = $resultado->valor;
            $consulta = " INSERT INTO BSTNTRN.BTCLIENTETEL "
                        . " (BTCLIENTETELNOCTEID, "
                        . " BTCLIENTETELCONSID, "
                        . " BTCLIENTETELNIR, "
                        . " BTCLIENTETELSERIE, " 
                        . " BTCLIENTETELNUM, "
                        . " BTCLIENTETELCIA, "
                        . " BTCLIENTETELTTELEFONOID, "
                        . " BTCLIENTETELNO) "
                        . " VALUE(?,?,?,?,?,?,?,?) ";
            if($sentencia = $this->conexion->prepare($consulta))
            {
                if( $sentencia->bind_param("sissssss",$clientetelefono->id,
                                                   $id,                                                   
                                                   $clientetelefono->nir,
                                                   $clientetelefono->serie,
                                                   $clientetelefono->telefonoCliente,
                                                   $clientetelefono->compania,
                                                   $clientetelefono->tipoTelefono,
                                                   $clientetelefono->numeracion))
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
        $consulta = " DELETE FROM BSTNTRN.BTCLIENTETEL "
                    . "  WHERE BTCLIENTETELNOCTEID = ? ";
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

    public function actualizar(ClienteTelefono $clientetelefono)
    {     
        $resultado = new Resultado();
        $consulta = " UPDATE BSTNTRN.BTCLIENTETEL SET"
                    //. " BTCLIENTETELCONSID = ? , "
                    . " BTCLIENTETELNIR = ? , "
                    . " BTCLIENTETELSERIE = ? , "
                    . " BTCLIENTETELNUM = ? , "
                    . " BTCLIENTETELCIA = ? , "
                    . " BTCLIENTETELTTELEFONOID = ? , "
                    . " BTCLIENTETELNO = ? "   
                    . " WHERE BTCLIENTETELNOCTEID = ? ";                  
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("sssssss",/*$clientetelefono->consecutivo,*/
                                                 $clientetelefono->nir,
                                                 $clientetelefono->serie,
                                                 $clientetelefono->telefonoCliente,
                                                 $clientetelefono->compania,
                                                 $clientetelefono->tipoTelefono,
                                                 $clientetelefono->numeracion,
                                                 $clientetelefono->id))
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
        $clientestelefonos = array();     
       
        $consulta =   " SELECT "
                      . " BTCLIENTETELNOCTEID id, "
                      //. " BTCLIENTETELCONSID consecutivo, "
                      . " BTCLIENTETELNIR nir, "
                      . " BTCLIENTETELSERIE serie, "
                      . " BTCLIENTETELNUM telefonoCliente,"
                      . " BTCLIENTETELNO numeracion,  "
                      . " BTCLIENTETELCIA compania, "
                      . " BTCLIENTETELTTELEFONOID tipoTelefono "
                      . " FROM BSTNTRN.BTCLIENTETEL "
                      . " WHERE BTCLIENTETELNOCTEID like CONCAT('%',?,'%') ";
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("s",$criteriosSeleccion->id))
            {
                if($sentencia->execute())
                {                
                    if ($sentencia->bind_result($id, /*$consecutivo*/  $nir, $serie, $telefonoCliente, $numeracion, $compania, $tipoTelefono)  )
                    {                    
                        while($row = $sentencia->fetch())
                        {
                            $clientetelefono = (object) [
                                'id' =>  utf8_encode($id),
                                //'consecutivo' => utf8_encode($consecutivo),
                                'nir' => utf8_encode($nir),
                                'serie' => utf8_encode($serie),
                                'telefonoCliente' => utf8_encode($telefonoCliente),
                                'numeracion' => utf8_encode($numeracion), 
                                'campania' => utf8_encode($compania),
                                'tipoTelefono' => utf8_encode($tipoTelefono)
                            ];  
                            array_push($clientestelefonos,$clientetelefono);
                        }
                        $resultado->valor = $clientestelefonos; 
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
                    . " BTCLIENTETELNOCTEID id, "
                    //. " BTCLIENTETELCONSID consecutivo, "
                    . " BTCLIENTETELNIR nir, "
                    . " BTCLIENTETELSERIE serie, "
                    . " BTCLIENTETELNUM telefonoCliente,"
                    . " BTCLIENTETELCIA compania, "
                    . " BTCLIENTETELTTELEFONOID tipoTelefono, "
                    . " BTCLIENTETELNO numeracion "
                    . " FROM BSTNTRN.BTCLIENTETEL "
                    . " WHERE BTCLIENTETELNOCTEID = ? ";  
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("i",$llaves))
            {
                if($sentencia->execute())
                {                    
                    if ($sentencia->bind_result($id, $nir, $serie, $telefonoCliente, $compania, $tipoTelefono, $numeracion))
                    {                        
                        if($sentencia->fetch())
                        {
                            $clientetelefono = new ClienteTelefono();
                            $clientetelefono->id = utf8_encode($id);
                           // $clientetelefono->consecutivo = utf8_encode($consecutivo);
                            $clientetelefono->telefonoCliente = utf8_encode($telefonoCliente);
                            $clientetelefono->nir = utf8_encode($nir);
                            $clientetelefono->serie = utf8_encode($serie);
                            $clientetelefono->compania = utf8_encode($compania);
                            $clientetelefono->tipoTelefono = utf8_encode($tipoTelefono);
                            $clientetelefono->numeracion = utf8_encode($numeracion);
                            $resultado->valor = $clientetelefono;
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

