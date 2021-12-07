<?php
require_once PROJECT_ROOT_PATH . "/model/DataBase.php";

class UserModel extends Database
{
    public function getUsers($limit = 100)
    {
        return $this->select(
            "SELECT * FROM clientes ORDER BY fechaDeCreacion ASC LIMIT ?",
            ["i", $limit]
        );
    }

}

class Cliente
{
    public $fechaDeCreacion;
    public $viable;
    public $nombre;
    public $correo;
    public $celular;
    public $medioPublicitario;
    public $zonaBusqueda;
    public $proyectoDeInteres;
    public $gestionDesdeSalaDeVentas;
    public $habeasData;
    public $fechaDeContacto;
    public $fechaDeContactoEfectivo;
    public $proyectoCalificado;
    public $fechaVisitaAgendada;
    public $fechaVisitaEfectiva;
    public $estado;
    public $fechaModificacionEstado;
    public $asignadoA;
}