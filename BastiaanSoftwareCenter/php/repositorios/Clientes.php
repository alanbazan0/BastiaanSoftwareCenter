<?php
use php\clases\AdministradorConexion;
use php\clases\JsonMapper;
use php\modelos\Cliente;
use php\repositorios\ClientesRepositorio;

error_reporting(E_ALL);
ini_set('display_errors', 1);


include '../clases/JsonMapper.php';
include '../clases/Utilidades.php';
include '../clases/AdministradorConexion.php';
include '../repositorios/ClientesRepositorio.php';



header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

$administrador_conexion = new AdministradorConexion();

$conexion;
try
{
    $conexion = $administrador_conexion->abrir();
    if($conexion)
    {
        $accion = REQUEST('accion');
        $repositorio = new ClientesRepositorio($conexion);
        switch ($accion)
        {
           
            case 'insertar':
                $json = json_decode(REQUEST('cliente'));
                $mapper = new JsonMapper();
                $cliente = $mapper->map($json, new Cliente());            
                $resultado = $repositorio->insertar($cliente);
                if($resultado!=null)
                    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
            break;
            case 'actualizar':
                $json = json_decode(REQUEST('cliente'));
                $mapper = new JsonMapper();
                $cliente = $mapper->map($json, new Cliente());
                $resultado = $repositorio->actualizar($cliente) ;
                if($resultado!=null)
                    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
            break;
            case 'eliminar':               
               $llaves = json_decode(REQUEST('llaves'));
               $resultado = $repositorio->eliminar($llaves);           
               if($resultado!=null)
                   echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
            break;           
            case 'consultarPorLlaves':
                $llaves = json_decode(REQUEST('llaves'));
                $resultado = $repositorio->consultarPorLlaves($llaves);
                if($resultado!=null)
                    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
            break;
            case 'consultar':
                $criteriosSeleccion = json_decode(REQUEST('criteriosSeleccion'));
                $resultado = $repositorio->consultar($criteriosSeleccion);
                if($resultado!=null)
                    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
           break;
        }
    }
    
}
catch(Exception $e)
{   
    echo $e->getMessage(), '\n';
}
finally
{
    $administrador_conexion->cerrar($conexion);
}


