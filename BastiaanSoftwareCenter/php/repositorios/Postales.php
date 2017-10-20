<?php
use php\clases\AdministradorConexion;
use php\repositorios\PostalesRepositorio;
use php\modelos\Postales;

error_reporting(E_ALL);
ini_set('display_errors', 1);


include '../clases/Utilidades.php';
include '../clases/AdministradorConexion.php';
include '../repositorios/PostalesRepositorio.php';



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
        $repositorio = new PostalesRepositorio($conexion);
        switch ($accion)
        {
            case 'consultarPorId':
                $id = REQUEST('id');
                
                $postales = $repositorio->consultarPorNombre($nombre) ;
                if($postales!=null)
                    echo json_encode($postales, JSON_UNESCAPED_UNICODE);
                    break;
            case 'consultarPorId':
                $id = REQUEST('id');
                
                $postales = $repositorio->consultarPorId($id) ;
                if($postales!=null)
                    echo json_encode($postales, JSON_UNESCAPED_UNICODE);
                    break;
            case 'insertar':
                $postales = new Postales();
                $postales->asentamiento = utf8_encode(REQUEST('asentamiento'));
                $postales->estado = utf8_encode(REQUEST('estado'));
                $postales->municipio = utf8_encode(REQUEST('municipio'));
                $postales->ciudad = utf8_encode(REQUEST('ciudad'));
                $postales->nopostal = utf8_encode(REQUEST('nopostal'));
                $postales->id = utf8_encode(REQUEST('id'));
                $postales = $repositorio->insertar($postales) ;
                if($postales!=null)
                    echo json_encode($postales, JSON_UNESCAPED_UNICODE);
                    break;
            case 'eliminar':
                $postales = new postales();
                $postales->id = utf8_encode(REQUEST('id'));
                $postales = $repositorio->eliminar($postales) ;
                if($postales!=null)
                    echo json_encode($postales, JSON_UNESCAPED_UNICODE);
                    break;
            case 'actualizar':
                $postales = new Postales();
                $postales->asentamiento = utf8_encode(REQUEST('asentamiento'));
                $postales->estado = utf8_encode(REQUEST('estado'));
                $postales->municipio = utf8_encode(REQUEST('municipio'));
                $postales->ciudad = utf8_encode(REQUEST('ciudad'));
                $postales->nopostal = utf8_encode(REQUEST('nopostal'));
                $postales->id = utf8_encode(REQUEST('id'));
                $postales = $repositorio->actualizar($postales) ;
                if($postales!=null)
                    echo json_encode($postales, JSON_UNESCAPED_UNICODE);
                    break;
            case 'consultar':        
                $id=REQUEST('id');
                $estado=REQUEST('estado');
                $municipio=REQUEST('municicipio');
                $postales = $repositorio->consultar($id,$estado,$municipio ) ;
                if($postales!=null)
                    echo json_encode($postales, JSON_UNESCAPED_UNICODE);
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


