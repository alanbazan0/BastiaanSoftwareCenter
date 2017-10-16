<?php
use php\clases\AdministradorConexion;
use php\repositorios\ClientesRepositorio;

error_reporting(E_ALL);
ini_set('display_errors', 1);


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
            case 'consultarPorNombre':
                $nombre = REQUEST('nombre');
               
                $clientes = $repositorio->consultarPorNombre($nombre) ;
                if($clientes!=null)
                    echo json_encode($clientes);
            break;
            case 'consultarPorId':
                $id = REQUEST('id');
                
                $clientes = $repositorio->consultarPorId($id) ;
                if($clientes!=null)
                    echo json_encode($clientes);
            break;
            case 'consultar':
                $nombreCompleto = REQUEST('nombreCompleto');
                $clientes = $repositorio->consultar($nombreCompleto);
                if($clientes!=null)
                    echo json_encode($clientes);
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


