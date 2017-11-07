<?php
namespace php\repositorios;
use php\interfaces\ICamposRepositorio;
use php\modelos\Resultado;

include "../interfaces/ICamposRepositorio.php";
include "../clases/Resultado.php";



class CamposRepositorio implements  ICamposRepositorio
{
    protected $conexion;
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }
    
    
    public function consultarPorTablas($tablas)
    {
        $resultado = new Resultado();
        $registros = array();
        
        $consulta =   " SELECT "
                     ." BTCAMPOID campoId, "
                     ." BTCAMPONUMERO campoNumero, "
                     ." BTTABLAID tablaId, "
                     ." BTCAMPOTIPO tipoCampo, " 
                     ." BTCAMPOTAMANO tamanoCampo, " 
                     ." BTCAMPOTITULO tituloCampo " .
                      "FROM BSTNTRN.BTCAMPO ";
                           /*"WHERE BTTABLAID = BTCLIENTE"; */
  
         if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("s",$tablas))
            {
                if($sentencia->execute())
                {
                    if ($sentencia->bind_result($campoId, $campoNumero, $tablaId, $tipoCampo, $tamanoCampo, $tituloCampo ))
                    {
                        while($sentencia->fetch())
                        {
                            $registro = (object) [
                                'campoId' =>  utf8_encode($campoId),
                                'campoNumero' => utf8_encode($campoNumero),
                                'tablaId' => utf8_encode($tablaId),
                                'tipoCampo' => utf8_encode($tipoCampo),
                                'tamanoCampo' => utf8_encode($tamanoCampo),
                                'tituloCampo' => utf8_encode($tituloCampo)
                            ];
                            array_push($registros,$registro);
                        }
                        $resultado->valor = $registros;
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
