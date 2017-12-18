<?php
use php\clases\AdministradorConexion;
use php\clases\JsonMapper;
use php\modelos\Area;
use php\repositorios\AreasRepositorio;
use php\repositorios\CorreoRepositorio;

error_reporting(E_ALL);
ini_set('display_errors', 1);


include '../clases/JsonMapper.php';
include '../clases/Utilidades.php';
include '../clases/AdministradorConexion.php';
include '../repositorios/CorreoRepositorio.php';



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
        $repositorio = new CorreoRepositorio($conexion);
        switch ($accion)
        {            
            case 'consultarCorreoEntrada':
                $NombreUsuario = REQUEST('idNombre');
                $resultado = $repositorio->consultarCorreoEntrada($NombreUsuario);
                if($resultado!=null)
                    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
                    break;
            case 'consultarCorreoEntradaDia':
                $NombreUsuario = REQUEST('idNombre');
                $resultado = $repositorio->consultarCorreoEntradaDia($NombreUsuario);
                if($resultado!=null)
                    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
                    break;
            case 'consultarCorreoEntradaMes':
                $NombreUsuario = REQUEST('idNombre');
                $resultado = $repositorio->consultarCorreoEntradaMes($NombreUsuario);
                if($resultado!=null)
                    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
                    break;
            case 'consultarCorreoEntradaSemana':
                $NombreUsuario = REQUEST('idNombre');
                $resultado = $repositorio->consultarCorreoEntradaSemana($NombreUsuario);
                if($resultado!=null)
                    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
                    break;
            case 'consultarCorreoEntradaInfo':
                $NombreUsuario = REQUEST('idNombre');
                $resultado = $repositorio->consultarCorreoEntradaInfo($NombreUsuario);
                if($resultado!=null)
                    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
                    break;
            case 'consultarCorreoEntradaDiaInfo':
                $NombreUsuario = REQUEST('idNombre');
                $resultado = $repositorio->consultarCorreoEntradaDiaInfo($NombreUsuario);
                if($resultado!=null)
                    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
                    break;
            case 'consultarCorreoEntradaMesInfo':
                $NombreUsuario = REQUEST('idNombre');
                $resultado = $repositorio->consultarCorreoEntradaMesInfo($NombreUsuario);
                if($resultado!=null)
                    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
                    break;
            case 'consultarCorreoEntradaSemanaInfo':
                $NombreUsuario = REQUEST('idNombre');
                $resultado = $repositorio->consultarCorreoEntradaSemanaInfo($NombreUsuario);
                if($resultado!=null)
                    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
                    break;
            case 'insertarAltaClienteCorreo':
                $nombre = REQUEST('nombre');
                $nombre2 = REQUEST('nombre2');
                $paterno = REQUEST('paterno');
                $materno = REQUEST('materno');
                $correo = REQUEST('correo');
                $rfc = REQUEST('rfc');
                $curp = REQUEST('curp');
                $resultado = $repositorio->insertarAltaClienteCorreo($nombre,$nombre2,$paterno,$paterno,$materno,$rfc,$curp);
                if($resultado->valor!="")
                    $resultado= $repositorio->insertarAltaCorreo($correo,$resultado->valor);
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


