<?php
namespace php\interfaces;

use php\modelos\Version;

interface IVersionesRepositorio
{
    public function insertar(Version $version);
    public function insertarGrid2(Version $datosGrid2);
    public function actualizar(Version $version);
    public function eliminar($id);
    public function consultarPorLlaves($id);
    public function consultar($criteriosSeleccion);
    /* grid2 */
    public function consultarPorVersion($criteriosVersion);
     /* grid3 */
   public function consultarPorCampo();    
}
