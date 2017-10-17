<?php
namespace php\repositorios;

use php\interfaces\IClientesRepositorio;
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
        $resultado = "";
        $consulta = " INSERT INTO BSTNTRN.BTCLIENTE "
                    . " (BTCLIENTENUMERO, "
                    . " BTCLIENTEPNOMBRE, "
                    . " BTCLIENTESNOMBRE, "
                    . " BTCLIENTEAPATERNO, "
                    . " BTCLIENTEAMATERNO, "
                    . " BTCLIENTENCOMPLETO, "
                    . " BTCLIENTERFC, "
                    . " BTCLIENTENSS, "
                    . " BTCLIENTECURP, "
                    . " BTCLIENTECPID, "
                    . " BTCLIENTENEXTERIOR, "
                    . " BTCLIENTENINTERIOR, "
                    . " BTCLIENTECALLE, "
                    . " BTCLIENTECOLONIA, "
                    . " BTCLIENTEESTADO, "
                    . " BTCLIENTEPAIS, "
                    . " BTCLIENTEDCOMPLETA, "
                    . " BTCLIENTECORRELEC) "
                    . " VALUE( "
                    . " (SELECT MAX(IFNULL(BTCLIENTENUMERO,0))+1 AS 'ID' FROM BSTNTRN.BTCLIENTE ID),  "
                    . " ?,  ?,?, ?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
         if($sentencia = $this->conexion->prepare($consulta))
         {
             $sentencia->bind_param("sssssssssssssssss",$cliente->nombre,
                                                        $cliente->nombreSegundo, 
                                                        $cliente->apellidoPaterno,
                                                        $cliente->apellidoMaterno,
                                                        $cliente->nombreCompleto,
                                                        $cliente->rfc,
                                                        $cliente->nss,
                                                        $cliente->curp,
                                                        $cliente->cpId,
                                                        $cliente->numExt,
                                                        $cliente->numInt,
                                                        $cliente->calle,
                                                        $cliente->colonia,
                                                        $cliente->estado,
                                                        $cliente->pais,
                                                        $cliente->direccion,
                                                        $cliente->correoElectronico);                
             $resultado = $sentencia->execute();           
         }else{
             echo "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
         }
        return $resultado;
    }
    
    public function eliminar(Cliente $cliente)
    {
        $resultado = "";
        $consulta = " DELETE FROM BSTNTRN.BTCLIENTE "
                    . "  WHERE BTCLIENTENUMERO  = ? ";
         if($sentencia = $this->conexion->prepare($consulta))
         {
             $sentencia->bind_param("i",$cliente->id);
             $resultado = $sentencia->execute();           
         }else{
             echo "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
         }
        return $resultado;
    }

    public function actualizar(Cliente $cliente)
    {     
        $resultado = "";
        $consulta = " UPDATE BSTNTRN.BTCLIENTE SET"
                    . " BTCLIENTEPNOMBRE=  ? , "
                    . " BTCLIENTESNOMBRE=  ? , "
                    . " BTCLIENTEAPATERNO= ? , "
                    . " BTCLIENTEAMATERNO= ? , "
                    . " BTCLIENTENCOMPLETO=? , "
                    . " BTCLIENTERFC=? , "
                    . " BTCLIENTENSS=? , "
                    . " BTCLIENTECURP=? , "
                    . " BTCLIENTECPID=? , "
                    . " BTCLIENTENEXTERIOR=? , "
                    . " BTCLIENTENINTERIOR=? , "
                    . " BTCLIENTECALLE=? , "
                    . " BTCLIENTECOLONIA=? , "
                    . " BTCLIENTEESTADO=? , "
                    . " BTCLIENTEPAIS=? , "
                    . " BTCLIENTEDCOMPLETA=? , "
                    . " BTCLIENTECORRELEC=?  "
                    . "  WHERE BTCLIENTENUMERO  = ? ";
         if($sentencia = $this->conexion->prepare($consulta))
         {
             $sentencia->bind_param("ssssssssssssssssss",$cliente->nombre,
                                                        $cliente->nombreSegundo, 
                                                        $cliente->apellidoPaterno,
                                                        $cliente->apellidoMaterno,
                                                        $cliente->nombreCompleto,
                                                        $cliente->rfc,
                                                        $cliente->nss,
                                                        $cliente->curp,
                                                        $cliente->cpId,
                                                        $cliente->numExt,
                                                        $cliente->numInt,
                                                        $cliente->calle,
                                                        $cliente->colonia,
                                                        $cliente->estado,
                                                        $cliente->pais,
                                                        $cliente->direccion,
                                                        $cliente->correoElectronico,
                                                        $cliente->id);                
             $resultado = $sentencia->execute();           
         }else{
             echo "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
         }
        return $resultado;        
    }
    
    public function consultar($nombreCompleto,$rfc,$curp)
    {
        $clientes = array();
        $consulta =   " SELECT "
                    . " BTCLIENTENUMERO id, "
                    . " BTCLIENTEPNOMBRE nombre, "
                    . " BTCLIENTESNOMBRE nombreSegundo, "
                    . " BTCLIENTEAPATERNO apellidoPaterno, "
                    . " BTCLIENTEAMATERNO apellidoMaterno, "
                    . " BTCLIENTERFC rfc, "
                    . " BTCLIENTENSS nss, "
                    . " BTCLIENTECURP curp, "
                    . " BTCLIENTECPID cpId, "
                    . " BTCLIENTENEXTERIOR numExt, "
                    . " BTCLIENTENINTERIOR numInt, "
                    . " BTCLIENTECALLE calle, "
                    . " BTCLIENTECOLONIA colonia, "
                    . " BTCLIENTEESTADO estado, "
                    . " BTCLIENTEPAIS pais, "
                    . " BTCLIENTECORRELEC correoElectronico "
                    . " FROM BSTNTRN.BTCLIENTE  "
                    . " WHERE BTCLIENTENCOMPLETO like  CONCAT('%',?,'%') "
                    . " AND BTCLIENTERFC like  CONCAT('%',?,'%') "
                    . " AND BTCLIENTECURP like  CONCAT('%',?,'%') ";
        
        if($sentencia = $this->conexion->prepare($consulta))
        {
            $sentencia->bind_param("sss",$nombreCompleto,$rfc,$curp);
            if($sentencia->execute())
            {                
                if ($sentencia->bind_result($id, $nombre, $nombreSegundo, $apellidoPaterno, $apellidoMaterno,  $rfc, $nss, $curp, $cpId, $numExt, $numInt, $calle, $colonia, $estado, $pais,  $correoElectronico )  )
                {                    
                    while($row = $sentencia->fetch())
                    {
                        $cliente = (object) [
                            'id' =>  utf8_encode($id),
                            'nombre' => utf8_encode($nombre),
                            'nombreSegundo' => utf8_encode($nombreSegundo),
                            'apellidoPaterno' => utf8_encode($apellidoPaterno),
                            'apellidoMaterno' => utf8_encode($apellidoMaterno),
                            'rfc' => utf8_encode($rfc),
                            'nss' => utf8_encode($nss),
                            'curp' => utf8_encode($curp),
                            'cpId' => utf8_encode($cpId),
                            'numExt' => utf8_encode($numExt),
                            'numInt' => utf8_encode($numInt),
                            'calle' => utf8_encode($calle),
                            'colonia' => utf8_encode($colonia),
                            'estado' => utf8_encode($estado),
                            'pais' => utf8_encode($pais),
                            'correoElectronico' => utf8_encode($correoElectronico)
                        ];  
                        array_push($clientes,$cliente);
                    }
                }                
            }            
        }else{
            echo "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
        }
        return  $clientes;
    }

    public function consultarPorNombre($nombre)
    {
        $clientes = array();
        $consulta =   " SELECT "
                    . " BTCLIENTENUMERO id, "
                    . " BTCLIENTEPNOMBRE nombre, "
                    . " BTCLIENTESNOMBRE nombreSegundo, "
                    . " BTCLIENTEAPATERNO apellidoPaterno, "
                    . " BTCLIENTEAMATERNO apellidoMaterno, "
                    . " BTCLIENTENCOMPLETO nombreCompleto, "
                    . " BTCLIENTERFC rfc, "
                    . " BTCLIENTENSS nss, "
                    . " BTCLIENTECURP curp, "
                    . " BTCLIENTECPID cpId, "
                    . " BTCLIENTENEXTERIOR numExt, "
                    . " BTCLIENTENINTERIOR numInt, "
                    . " BTCLIENTECALLE calle, "
                    . " BTCLIENTECOLONIA colonia, "
                    . " BTCLIENTEESTADO estado, "
                    . " BTCLIENTEPAIS pais, "
                    . " BTCLIENTEDCOMPLETA direccion, "
                    . " BTCLIENTECORRELEC correoElectronico "
                    . " FROM BTCLIENTE " 
                    . " WHERE BTCLIENTEPNOMBRE  LIKE  CONCAT('%',?,'%')";
        
        if($sentencia = $this->conexion->prepare($consulta))
        {
            $sentencia->bind_param("s",$nombre);
            if($sentencia->execute())
            {
                
                if ($sentencia->bind_result($id, $nombre, $nombreSegundo, $apellidoPaterno, $apellidoMaterno, $nombreCompleto, $rfc, $nss, $curp, $cpId, $numExt, $numInt, $calle, $colonia, $estado, $pais, $direccion , $correoElectronico )  )
                {
                    
                    while($row = $sentencia->fetch())
                    {
                        $cliente = new Cliente();
                        $cliente->id = utf8_encode($id);
                        $cliente->nombre = utf8_encode($nombre);
                        $cliente->nombreSegundo = utf8_encode($nombreSegundo);
                        $cliente->apellidoPaterno = utf8_encode($apellidoPaterno);
                        $cliente->apellidoMaterno = utf8_encode($apellidoMaterno);
                        $cliente->nombreCompleto = utf8_encode($nombreCompleto);
                        $cliente->rfc = utf8_encode($rfc);
                        $cliente->nss = utf8_encode($nss);
                        $cliente->curp = utf8_encode($curp);
                        $cliente->cpId = utf8_encode($cpId);
                        $cliente->numExt = utf8_encode($numExt);
                        $cliente->numInt = utf8_encode($numInt);
                        $cliente->calle = utf8_encode($calle);
                        $cliente->colonia = utf8_encode($colonia);
                        $cliente->estado = utf8_encode($estado);
                        $cliente->pais = utf8_encode($pais);
                        $cliente->direccion = utf8_encode($direccion);
                        $cliente->correoElectronico = utf8_encode($correoElectronico);   
                        array_push($clientes,$cliente);
                    }
                }
                
            }
            
        }else{
            echo "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
        }
        return $clientes;
    }

    public function consultarPorId($id)
    {
        $clientes = array();
        $consulta =   " SELECT "
                    . " BTCLIENTENUMERO id, "
                    . " BTCLIENTEPNOMBRE nombre, "
                    . " BTCLIENTESNOMBRE nombreSegundo, "
                    . " BTCLIENTEAPATERNO apellidoPaterno, "
                    . " BTCLIENTEAMATERNO apellidoMaterno, "
                    . " BTCLIENTENCOMPLETO nombreCompleto, "
                    . " BTCLIENTERFC rfc, "
                    . " BTCLIENTENSS nss, "
                    . " BTCLIENTECURP curp, "
                    . " BTCLIENTECPID cpId, "
                    . " BTCLIENTENEXTERIOR numExt, "
                    . " BTCLIENTENINTERIOR numInt, "
                    . " BTCLIENTECALLE calle, "
                    . " BTCLIENTECOLONIA colonia, "
                    . " BTCLIENTEESTADO estado, "
                    . " BTCLIENTEPAIS pais, "
                    . " BTCLIENTEDCOMPLETA direccion, "
                    . " BTCLIENTECORRELEC correoElectronico "
                    . " FROM BTCLIENTE " 
                    . " WHERE BTCLIENTENUMERO  = ?";
        if($sentencia = $this->conexion->prepare($consulta))
        {
            $sentencia->bind_param("i",$id);
            if($sentencia->execute())
            {
                
                if ($sentencia->bind_result($id, $nombre, $nombreSegundo, $apellidoPaterno, $apellidoMaterno, $nombreCompleto, $rfc, $nss, $curp, $cpId, $numExt, $numInt, $calle, $colonia, $estado, $pais, $direccion , $correoElectronico ))
                {
                    
                    while($row = $sentencia->fetch())
                    {
                        $cliente = new Cliente();
                        $cliente->id = utf8_encode($id);
                        $cliente->nombre = utf8_encode($nombre);
                        $cliente->nombreSegundo = utf8_encode($nombreSegundo);
                        $cliente->apellidoPaterno = utf8_encode($apellidoPaterno);
                        $cliente->apellidoMaterno = utf8_encode($apellidoMaterno);
                        $cliente->nombreCompleto = utf8_encode($nombreCompleto);
                        $cliente->rfc = utf8_encode($rfc);
                        $cliente->nss = utf8_encode($nss);
                        $cliente->curp = utf8_encode($curp);
                        $cliente->cpId = utf8_encode($cpId);
                        $cliente->numExt = utf8_encode($numExt);
                        $cliente->numInt = utf8_encode($numInt);
                        $cliente->calle = utf8_encode($calle);
                        $cliente->colonia = utf8_encode($colonia);
                        $cliente->estado = utf8_encode($estado);
                        $cliente->pais = utf8_encode($pais);
                        $cliente->direccion = utf8_encode($direccion);
                        $cliente->correoElectronico = utf8_encode($correoElectronico);                        
                        array_push($clientes,$cliente);
                    }
                }
                
            }
            
        }else{
            echo "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
        }
        return $clientes;
    }



    
}

