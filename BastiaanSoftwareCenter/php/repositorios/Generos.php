<?php
use php\clases\AdministradorConexion;
use php\clases\JsonMapper;
use php\modelos\Genero;
use php\repositorios\GenerosRepositorio;

error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../clases/JsonMapper.php';
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
            case 'consultarPorNombre':
                $nombre = REQUEST('nombre');
                
                $generos = $repositorio->consultarPorNombre($nombre) ;
                if($generos!=null)
                    echo json_encode($generos, JSON_UNESCAPED_UNICODE);
                    break;
            case 'consultarPorId':
                $nombreSegundo = REQUEST('nombre');
                
                $generos = $repositorio->consultarPorId($nombreSegundo) ;
                if($generos!=null)
                    echo json_encode($generos, JSON_UNESCAPED_UNICODE);
                    break;
            case 'insertar':
                $json = json_decode(REQUEST('genero'));
                $mapper = new JsonMapper();
                $genero = $mapper->map($json, new Genero());
              /*  $cliente = new Cliente();
                $cliente->nombre = utf8_encode(REQUEST('nombre'));
                $cliente->nombreSegundo = utf8_encode(REQUEST('nombreSegundo'));
                $cliente->apellidoPaterno = utf8_encode(REQUEST('apellidoPaterno'));
                $cliente->apellidoMaterno = utf8_encode(REQUEST('apellidoMaterno'));
                $cliente->rfc = utf8_encode(REQUEST('rfc'));
                $cliente->nss = utf8_encode(REQUEST('nss'));
                $cliente->curp = utf8_encode(REQUEST('curp'));
                $cliente->cpId = utf8_encode(REQUEST('cpId'));
                $cliente->numExt = utf8_encode(REQUEST('numExt'));
                $cliente->numInt = utf8_encode(REQUEST('numInt'));
                $cliente->calle = utf8_encode(REQUEST('calle'));
                $cliente->colonia = utf8_encode(REQUEST('colonia'));
                $cliente->estado = utf8_encode(REQUEST('estado'));
                $cliente->pais = utf8_encode(REQUEST('pais'));
                $cliente->correoElectronico = utf8_encode(REQUEST('correoElectronico'));
               
              
                    */
                $nombre = $repositorio->insertar($genero) ;
                if($nombre!=null)
                    echo json_encode($nombre, JSON_UNESCAPED_UNICODE);
                    break;
            case 'eliminar':
                $genero = new Genero();
                $genero->id = utf8_encode(REQUEST('id'));
                $generos = $repositorio->eliminar($genero) ;
                if($generos!=null)
                    echo json_encode($generos, JSON_UNESCAPED_UNICODE);
                    break;
            case 'actualizar':
                $json = json_decode(REQUEST('genero'));
                $mapper = new JsonMapper();
                $genero = $mapper->map($json, new Genero());
              
                /*$cliente = new Cliente();
                $cliente->nombre = utf8_encode(REQUEST('nombre'));
                $cliente->nombreSegundo = utf8_encode(REQUEST('nombreSegundo'));
                $cliente->apellidoPaterno = utf8_encode(REQUEST('apellidoPaterno'));
                $cliente->apellidoMaterno = utf8_encode(REQUEST('apellidoMaterno'));
                $cliente->rfc = utf8_encode(REQUEST('rfc'));
                $cliente->nss = utf8_encode(REQUEST('nss'));
                $cliente->curp = utf8_encode(REQUEST('curp'));
                $cliente->cpId = utf8_encode(REQUEST('cpId'));
                $cliente->numExt = utf8_encode(REQUEST('numExt'));
                $cliente->numInt = utf8_encode(REQUEST('numInt'));
                $cliente->calle = utf8_encode(REQUEST('calle'));
                $cliente->colonia = utf8_encode(REQUEST('colonia'));
                $cliente->estado = utf8_encode(REQUEST('estado'));
                $cliente->pais = utf8_encode(REQUEST('pais'));
                $cliente->correoElectronico = utf8_encode(REQUEST('correoElectronico'));
                $cliente->id = utf8_encode(REQUEST('id'));
                $clientes = $repositorio->actualizar($cliente) ;
                if($clientes!=null)
                    echo json_encode($clientes, JSON_UNESCAPED_UNICODE);
                   */ 
                $nombre = $repositorio->actualizar($genero) ;
                if($nombre!=null)
                    echo json_encode($nombre, JSON_UNESCAPED_UNICODE);
                break;
            case 'consultar':
                $nombre=REQUEST('nombre');
                $nombreSegundo=REQUEST('nombreSegundo');
                $apellidoPaterno=REQUEST('apellidoPaterno');
                $generos = $repositorio->consultar($nombre,$nombreSegundo,$apellidoPaterno ) ;
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


