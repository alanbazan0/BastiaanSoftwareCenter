<?php
namespace php\interfaces;


interface IAsteriskRepositorio
{
    public function consultarIdLlamada($extension);
    public function calcularId();
    
}
