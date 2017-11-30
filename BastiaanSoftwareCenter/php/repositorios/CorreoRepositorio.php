<?php
namespace php\repositorios;

use Exception;
use php\interfaces\IAreasRepositorio;
use php\interfaces\ICorreoRepositorio;
use php\modelos\Area;
use php\modelos\Resultado;


include "../interfaces/ICorreoRepositorio.php";
include "../modelos/Area.php";
include "../clases/Resultado.php";

class CorreoRepositorio implements ICorreoRepositorio
{
    protected $conexion;
    public function __construct($conexion) 
    {
        $this->conexion = $conexion;
    }
    
    public function calcularId()
    {
        $resultado = new Resultado();
        $consulta =  "SELECT MAX(IFNULL(SIOAREAIDN,0))+1 AS id FROM BSTNTRN.SIOAREA";
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->execute())
            {
                if ($sentencia->bind_result($id))
                {
                    if($sentencia->fetch())
                    {
                        $resultado->valor = $id;
                    }
                    else
                        $resultado->mensajeError = "No se encontró ningún resultado";
                }
                else
                    $resultado->mensajeError = "Falló el enlace del resultado";
            }
            else
                $resultado->mensajeError = "Falló la ejecución (" . $this->conexion->errno . ") " . $this->conexion->error;
        }
        else
            $resultado->mensajeError = "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
            return $resultado;
    }
    public function insertar(Area $area)
    {}

    public function consultarPorLlaves($id)
    {}

    public function eliminar($id)
    {}

    public function actualizar(Area $area)
    {}

    public function consultarCorreoEntrada($NombreUsuario)
    {
        $resultado = new Resultado();
        $correos = array();
        $consulta = "SELECT EMENTFEC fecha, EMENTRNOM nombre, EMENTRCORREO correo, EMENTRASUN asunto, "
                     ." TO_BASE64(EMENTRCUER) contenido, CNUSERID id, EMENTRTO acorreo FROM BSTNTRN.EMENTR where CNUSERID= ? ";
            if($sentencia = $this->conexion->prepare($consulta))
            {
                if($sentencia->bind_param("s",$NombreUsuario))
                {
                    if($sentencia->execute())
                    {
                        if ($sentencia->bind_result($fecha,$nombre,$correo,$asunto,$contenido,$id,$acorreo))
                        {
                            while($row = $sentencia->fetch())
                            {
                                $correor = (object) [
                                    'fecha' => utf8_encode($fecha) ,
                                    'nombre' => utf8_encode($nombre),
                                    'correo' => utf8_encode($correo),
                                    'asunto' => utf8_encode($asunto),
                                    'contenido' => utf8_encode($contenido),
                                    'id' => utf8_encode($id),
                                    'aCorreo' => utf8_encode($acorreo),
                                    'titulo' => utf8_encode($correo)." ".utf8_encode($asunto)
                                ];
                                array_push($correos,$correor);
                            }
                            $resultado->valor = $correos;
                        }
                        else
                            $resultado->mensajeError = "FallÃ³ el enlace del resultado.";
                    }
                    else
                        $resultado->mensajeError = "FallÃ³ la ejecuciÃ³n (" . $this->conexion->errno . ") " . $this->conexion->error;
                }
                else
                    $resultado->mensajeError = "FallÃ³ el enlace de parÃ¡metros";
            }
            else
                $resultado->mensajeError = "FallÃ³ la preparaciÃ³n: (" . $this->conexion->errno . ") " . $this->conexion->error;
                
                
                return $resultado;
    }
    
}

