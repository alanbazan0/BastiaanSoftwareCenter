<?php
use php\clases\AdministradorConexion;
use php\repositorios\PortablesRepositorio;
use php\modelos\Portables;

error_reporting(E_ALL);
ini_set('display_errors', 1);


include '../clases/Utilidades.php';
include '../clases/AdministradorConexion.php';
include '../repositorios/PortablesRepositorio.php';

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
        $repositorio = new PortablesRepositorio($conexion);
        switch ($accion)
        {
            case 'consultarPorId':
                $id = REQUEST('id');
                
                $portables = $repositorio->consultarPorNombre($nombre) ;
                if($portables!=null)
                    echo json_encode($portables, JSON_UNESCAPED_UNICODE);
                    break;
            case 'consultarPorId':
                $id = REQUEST('id');
                
                $portables = $repositorio->consultarPorId($id) ;
                if($portables!=null)
                    echo json_encode($portables, JSON_UNESCAPED_UNICODE);
                    break;
            case 'insertar':
                $portables = new Portables();
                $portables->descripcion= utf8_encode(REQUEST('descripcion'));
                $portables->estado = utf8_encode(REQUEST('estado'));
                $portables->municipio = utf8_encode(REQUEST('municipio'));
                $portables->poblacion = utf8_encode(REQUEST('poblacion'));
                $portables->consecutivo = utf8_encode(REQUEST('consecutivo'));
                $portables->id = utf8_encode(REQUEST('id'));
                $portables = $repositorio->insertar($portables) ;
                if($portables!=null)
                    echo json_encode($portables, JSON_UNESCAPED_UNICODE);
                    break;
            case 'eliminar':
                $portables = new Portables();
                $portables->id = utf8_decode(REQUEST('id'));
                $portables = $repositorio->eliminar($portables) ;
                if($portables!=null)
                    echo json_encode($portables, JSON_UNESCAPED_UNICODE);
                    break;
            case 'actualizar':
                $portables = new Portables();
                $portables->descripcion= utf8_encode(REQUEST('descripcion'));
                $portables->estado = utf8_encode(REQUEST('estado'));
                $portables->municipio = utf8_encode(REQUEST('municipio'));
                $portables->poblacion = utf8_encode(REQUEST('poblacion'));
                $portables->consecutivo = utf8_encode(REQUEST('consecutivo'));
                $portables->id = utf8_encode(REQUEST('id'));
                $portables = $repositorio->actualizar($portables) ;
                if($portables!=null)
                    echo json_encode($portables, JSON_UNESCAPED_UNICODE);
                    break;
            case 'consultar':        
                $id=REQUEST('id');
                $estado=REQUEST('estado');
                $municipio=REQUEST('municicipio');
                $portables = $repositorio->consultar($id,$estado,$municipio ) ;
                if($portables!=null)
                    echo json_encode($portables, JSON_UNESCAPED_UNICODE);
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


