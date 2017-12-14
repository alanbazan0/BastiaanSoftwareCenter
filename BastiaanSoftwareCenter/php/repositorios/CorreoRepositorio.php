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
                        $resultado->mensajeError = "No se encontr� ning�n resultado";
                }
                else
                    $resultado->mensajeError = "Fall� el enlace del resultado";
            }
            else
                $resultado->mensajeError = "Fall� la ejecuci�n (" . $this->conexion->errno . ") " . $this->conexion->error;
        }
        else
            $resultado->mensajeError = "Fall� la preparaci�n: (" . $this->conexion->errno . ") " . $this->conexion->error;
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
                     ." TO_BASE64(EMENTRCUER) contenido, CNUSERID id, EMENTRTO acorreo FROM BSTNTRN.EMENTR where CNUSERID= ? ORDER BY EMENTFEC DESC ";
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
                            $resultado->mensajeError = "Falló el enlace del resultado.";
                    }
                    else
                        $resultado->mensajeError = "Falló la ejecución (" . $this->conexion->errno . ") " . $this->conexion->error;
                }
                else
                    $resultado->mensajeError = "Falló el enlace de parámetros";
            }
            else
                $resultado->mensajeError = "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
                
                
                return $resultado;
    }
    public function consultarCorreoEntradaDia($NombreUsuario)
    {
        $resultado = new Resultado();
        $correos = array();
        $consulta = "SELECT EMENTFEC fecha, EMENTRNOM nombre, EMENTRCORREO correo, EMENTRASUN asunto, TO_BASE64(EMENTRCUER) contenido, CNUSERID id, EMENTRTO acorreo FROM BSTNTRN.EMENTR" 
                    ." where CNUSERID= ?  and  DATE(EMENTFEC) = CURDATE()  ORDER BY EMENTFEC DESC";
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
                            $resultado->mensajeError = "Falló el enlace del resultado.";
                    }
                    else
                        $resultado->mensajeError = "Falló la ejecución (" . $this->conexion->errno . ") " . $this->conexion->error;
                }
                else
                    $resultado->mensajeError = "Falló el enlace de parámetros";
            }
            else
                $resultado->mensajeError = "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
                
                
                return $resultado;
    }
    public function consultarCorreoEntradaMes($NombreUsuario)
    {
        $resultado = new Resultado();
        $correos = array();
        $consulta = "SELECT EMENTFEC fecha, EMENTRNOM nombre, EMENTRCORREO correo, EMENTRASUN asunto, TO_BASE64(EMENTRCUER) contenido, CNUSERID id, EMENTRTO acorreo FROM BSTNTRN.EMENTR"
                    ." where CNUSERID= ?  and  month(EMENTFEC) =  month(NOW())  ORDER BY EMENTFEC DESC";
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
                            $resultado->mensajeError = "Falló el enlace del resultado.";
                    }
                    else
                        $resultado->mensajeError = "Falló la ejecución (" . $this->conexion->errno . ") " . $this->conexion->error;
                }
                else
                    $resultado->mensajeError = "Falló el enlace de parámetros";
            }
            else
                $resultado->mensajeError = "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
                
                
                return $resultado;
    }
    public function consultarCorreoEntradaSemana($NombreUsuario)
    {
        $resultado = new Resultado();
        $correos = array();
        $consulta = "SELECT EMENTFEC fecha, EMENTRNOM nombre, EMENTRCORREO correo, EMENTRASUN asunto, TO_BASE64(EMENTRCUER) contenido, CNUSERID id, EMENTRTO acorreo FROM BSTNTRN.EMENTR" 
                    ." where CNUSERID= ?  and  WEEK(EMENTFEC) =  WEEK(NOW())  ORDER BY EMENTFEC DESC ";
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
                            $resultado->mensajeError = "Falló el enlace del resultado.";
                    }
                    else
                        $resultado->mensajeError = "Falló la ejecución (" . $this->conexion->errno . ") " . $this->conexion->error;
                }
                else
                    $resultado->mensajeError = "Falló el enlace de parámetros";
            }
            else
                $resultado->mensajeError = "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
                
                
                return $resultado;
    }
    public function consultarCorreoEntradaInfo($NombreUsuario)
    {
        $resultado = new Resultado();
        $correos = array();
        $resultado->valor=0;
        $consulta = "SELECT count(EMENTRCONTID) total2 FROM BSTNTRN.EMENTR where CNUSERID= ? ORDER BY EMENTFEC DESC ";
            if($sentencia = $this->conexion->prepare($consulta))
            {
                if($sentencia->bind_param("s",$NombreUsuario))
                {
                    if($sentencia->execute())
                    {
                        if ($sentencia->bind_result($total2))
                        {                  
                            while($row = $sentencia->fetch())
                            {
                                $correo = (object) [
                                    'total' => utf8_encode($total2)
                                ];   
                            }
                            
                            $resultado->valor=$correo;
                        }
                        else
                            $resultado->mensajeError = "Falló el enlace del resultado.";
                    }
                    else
                        $resultado->mensajeError = "Falló la ejecución (" . $this->conexion->errno . ") " . $this->conexion->error;
                }
                else
                    $resultado->mensajeError = "Falló el enlace de parámetros";
            }
            else
                $resultado->mensajeError = "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
                
                
                return $resultado;
    }
    public function consultarCorreoEntradaDiaInfo($NombreUsuario)
    {
        $resultado = new Resultado();
        $correos = array();
        
        $resultado->valor=0;
        $consulta = "SELECT count(*) dia FROM BSTNTRN.EMENTR where CNUSERID= ?  and  DATE(EMENTFEC) = CURDATE()  ORDER BY EMENTFEC DESC";
            if($sentencia = $this->conexion->prepare($consulta))
            {
                if($sentencia->bind_param("s",$NombreUsuario))
                {
                    if($sentencia->execute())
                    {
                        if ($sentencia->bind_result($dia))
                        {                           
                            while($row = $sentencia->fetch())
                            {
                                $correo = (object) [
                                    'dia' => utf8_encode($dia)
                                ];
                            }
                            
                            $resultado->valor=$correo;
                        }
                        else
                            $resultado->mensajeError = "Falló el enlace del resultado.";
                    }
                    else
                        $resultado->mensajeError = "Falló la ejecución (" . $this->conexion->errno . ") " . $this->conexion->error;
                }
                else
                    $resultado->mensajeError = "Falló el enlace de parámetros";
            }
            else
                $resultado->mensajeError = "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
                
                
                return $resultado;
    }
    public function consultarCorreoEntradaMesInfo($NombreUsuario)
    {
        $resultado = new Resultado();
        $correos = array();
        
        $resultado->valor=0;
        $consulta = "SELECT count(*) mes  FROM BSTNTRN.EMENTR where CNUSERID= ?  and  month(EMENTFEC) =  month(NOW())  ORDER BY EMENTFEC DESC";
            if($sentencia = $this->conexion->prepare($consulta))
            {
                if($sentencia->bind_param("s",$NombreUsuario))
                {
                    if($sentencia->execute())
                    {
                        if ($sentencia->bind_result($mes))
                        {
                            while($row = $sentencia->fetch())
                            {
                                $correo = (object) [
                                    'mes' => utf8_encode($mes)
                                ];
                            }
                            
                            $resultado->valor=$correo;
                        }
                        else
                            $resultado->mensajeError = "Falló el enlace del resultado.";
                    }
                    else
                        $resultado->mensajeError = "Falló la ejecución (" . $this->conexion->errno . ") " . $this->conexion->error;
                }
                else
                    $resultado->mensajeError = "Falló el enlace de parámetros";
            }
            else
                $resultado->mensajeError = "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
                
                
                return $resultado;
    }
    public function consultarCorreoEntradaSemanaInfo($NombreUsuario)
    {
        $resultado = new Resultado();
        $correos = array();
        
        $resultado->valor=0;
        $consulta = "SELECT count(*) semana FROM BSTNTRN.EMENTR where CNUSERID= ?  and  WEEK(EMENTFEC) =  WEEK(NOW())  ORDER BY EMENTFEC DESC ";
            if($sentencia = $this->conexion->prepare($consulta))
            {
                if($sentencia->bind_param("s",$NombreUsuario))
                {
                    if($sentencia->execute())
                    {
                        if ($sentencia->bind_result($semana))
                        {                            
                            
                            while($row = $sentencia->fetch())
                            {
                                $correo = (object) [
                                    'semana' => utf8_encode($semana)
                                ];
                            }
                            
                            $resultado->valor=$correo;
                        }
                        else
                            $resultado->mensajeError = "Falló el enlace del resultado.";
                    }
                    else
                        $resultado->mensajeError = "Falló la ejecución (" . $this->conexion->errno . ") " . $this->conexion->error;
                }
                else
                    $resultado->mensajeError = "Falló el enlace de parámetros";
            }
            else
                $resultado->mensajeError = "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
                
                
                return $resultado;
    }
}

