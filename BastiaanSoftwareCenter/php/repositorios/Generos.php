<?php
use php\clases\AdministradorConexion;
use php\repositorios\GenerosRepositorio;
use php\clases\JsonMapper;
use php\modelos\Generos;


error_reporting(E_ALL);
ini_set('display_errors', 1);


include '../clases/Utilidades.php';
include '../clases/AdministradorConexion.php';
include '../repositorios/GenerosRepositorio.php';

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
        $repositorio = new GenerosRepositorio($conexion);
        switch ($accion)
        {
            case 'consultarPorId':
                $id = REQUEST('id');
                
                $generos = $repositorio->consultarPorNombre($nombre) ;
                if($generos!=null)
                    echo json_encode($generos, JSON_UNESCAPED_UNICODE);
                    break;
            case 'consultarPorId':
                $id = REQUEST('id');
                $generos = $repositorio->consultarPorId($id) ;
                if($generos!=null)
                    echo json_encode($generos, JSON_UNESCAPED_UNICODE);
                    break;
            case 'insertar':
                $json = json_decode(REQUEST('id'));
                $mapper = new JsonMapper();
                $id = $mapper->map($json, new id());
             
               /*$generos = new Generos();
                $generos->gcorto = utf8_encode(REQUEST('gcorto'));
                $generos->glargo = utf8_encode(REQUEST('glargo'));
                $generos->id = utf8_encode(REQUEST('id'));
                $generos = $repositorio->insertar($generos) ;
                if($generos!=null)
                    echo json_encode($generos, JSON_UNESCAPED_UNICODE);
                    
                    */break;
            case 'eliminar':
                $generos = new Generos();
                $generos->id = utf8_decode(REQUEST('id'));
                $generos = $repositorio->eliminar($generos) ;
                if($generos!=null)
                    echo json_encode($generos, JSON_UNESCAPED_UNICODE);
                    break;
            case 'actualizar':
                $generos = new Generos();
                $generos->gcorto = utf8_encode(REQUEST('gcorto'));
                $generos->glargo = utf8_encode(REQUEST('glargo'));
                $generos->id = utf8_encode(REQUEST('id'));
                $generos = $repositorio->actualizar($generos) ;
                if($generos!=null)
                    echo json_encode($generos, JSON_UNESCAPED_UNICODE);
                    break;
            case 'consultar':        
                $id=REQUEST('id');
                $gcorto=REQUEST('gcorto');
                $glargo=REQUEST('glargo');
                $generos = $repositorio->consultar($id,$gcorto,$glargo ) ;
                if($generos!=null)
                    echo json_encode($generos, JSON_UNESCAPED_UNICODE);
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


