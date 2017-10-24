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
            case 'consultarPorNombre':
                $nombre = REQUEST('nombre');
                
                $clientes = $repositorio->consultarPorNombre($nombre) ;
                if($clientes!=null)
                    echo json_encode($clientes, JSON_UNESCAPED_UNICODE);
                    break;
            case 'consultarPorId':
                $id = REQUEST('id');
                
                $clientes = $repositorio->consultarPorId($id) ;
                if($clientes!=null)
                    echo json_encode($clientes, JSON_UNESCAPED_UNICODE);
                    break;
            case 'insertar':
                $json = json_decode(REQUEST('cliente'));
                $mapper = new JsonMapper();
                $cliente = $mapper->map($json, new Cliente());
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
                $id = $repositorio->insertar($cliente) ;
                if($id!=null)
                    echo json_encode($id, JSON_UNESCAPED_UNICODE);
                    break;
            case 'eliminar':
                $cliente = new Cliente();
                $cliente->id = utf8_encode(REQUEST('id'));
                $clientes = $repositorio->eliminar($cliente) ;
                if($clientes!=null)
                    echo json_encode($clientes, JSON_UNESCAPED_UNICODE);
                    break;
            case 'actualizar':
                $cliente = new Cliente();
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
                    break;
            case 'consultar':
                $nombreCompleto=REQUEST('nombreCompleto');
                $rfc=REQUEST('rfc');
                $curp=REQUEST('curp');
                $clientes = $repositorio->consultar($nombreCompleto,$rfc,$curp ) ;
                if($clientes!=null)
                    echo json_encode($clientes, JSON_UNESCAPED_UNICODE);
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


