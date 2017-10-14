<?php
namespace php\clases;
use mysqli;


class AdministradorConexion
{
    private $servidor = "localhost";
    private	$basedatos = "bstntrn";
    private	$usuario = "root";
    private	$contrasena ="root";
    public function abrir()
    {
        return new mysqli($this->servidor,$this->usuario,$this->contrasena,$this->basedatos);
    }
    
    public function cerrar($connection)
    {
        if($connection)
            //mysqli_close($connection);
            $connection->close();
    }
    
}

