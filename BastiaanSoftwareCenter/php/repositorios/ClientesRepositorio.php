<?php
namespace php\repositorios;

use php\Interfaces\IClientesRepositorio;
use php\modelos\Cliente;


include "../interfaces/IClientesRepositorio.php";
include "../modelos/Cliente.php";

class ClientesRepositorio implements IClientesRepositorio
{
    protected $conexion;
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }
    
    public function insertar(Cliente $cliente)
    {
        
        
    }
    
    public function eliminar(Cliente $cliente)
    {
        
    }

    public function actualizar(Cliente $cliente)
    {
        
    }
    public function consultar($nombreCompleto)
    {
        $clientes = array();
        $consulta = "SELECT BTCLIENTENUMERO id, BTCLIENTEPNOMBRE nombre, BTCLIENTEAPATERNO apellidoPaterno " .
            "FROM BTCLIENTE " .
            "WHERE BTCLIENTENCOMPLETO  LIKE  CONCAT('%',?,'%')";
        if($sentencia = $this->conexion->prepare($consulta))
        {
            $sentencia->bind_param("s",$nombreCompleto);
            if($sentencia->execute())
            {
                
                if ($sentencia->bind_result($id, $nombre, $apellidoPaterno))
                {
                    
                    while($row = $sentencia->fetch())
                    {
                        $cliente = (object) [
                            'id' =>  utf8_encode($id),
                            'nombre' => utf8_encode($nombre),
                            'apellidoPaterno' => utf8_encode($apellidoPaterno)
                        ];                       
                        array_push($clientes,$cliente);
                    }
                }
                
            }
            
        }
        return $clientes;
    }

    public function consultarPorNombre($nombre)
    {
        $clientes = array();
        $consulta = "SELECT BTCLIENTENUMERO id, BTCLIENTEPNOMBRE nombre, BTCLIENTEAPATERNO apellidoPaterno " .
            "FROM BTCLIENTE " .
            "WHERE BTCLIENTEPNOMBRE  LIKE  CONCAT('%',?,'%')";
        if($sentencia = $this->conexion->prepare($consulta))
        {
            $sentencia->bind_param("s",$nombre);
            if($sentencia->execute())
            {
                
                if ($sentencia->bind_result($id, $nombre, $apellidoPaterno))
                {
                    
                    while($row = $sentencia->fetch())
                    {
                        $cliente = new Cliente();
                        $cliente->id = utf8_encode($id);
                        $cliente->nombre = utf8_encode($nombre);
                        $cliente->apellidoPaterno = utf8_encode($apellidoPaterno);
                        array_push($clientes,$cliente);
                    }
                }
                
            }
            
        }
        return $clientes;
    }

    public function consultarPorId($id)
    {
        $clientes = array();
        $consulta = "SELECT BTCLIENTENUMERO id, BTCLIENTEPNOMBRE nombre, BTCLIENTEAPATERNO apellidoPaterno " .
            "FROM BTCLIENTE " .
            "WHERE BTCLIENTENUMERO  = ?";
        if($sentencia = $this->conexion->prepare($consulta))
        {
            $sentencia->bind_param("i",$id);
            if($sentencia->execute())
            {
                
                if ($sentencia->bind_result($id, $nombre, $apellidoPaterno))
                {
                    
                    while($row = $sentencia->fetch())
                    {
                        $cliente = new Cliente();
                        $cliente->id = utf8_encode($id);
                        $cliente->nombre = utf8_encode($nombre);
                        $cliente->apellidoPaterno = utf8_encode($apellidoPaterno);
                        array_push($clientes,$cliente);
                    }
                }
                
            }
            
        }
        return $clientes;
    }



    
}

