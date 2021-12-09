<?php
require_once PROJECT_ROOT_PATH . "/model/DataBase.php";

class UserModel extends Database
{
    public function getUsers($tabla = "", $parametros = [], $limit = 100)
    {
        if (isset($parametros["clave"]) && $parametros["clave"] != "") {

            if (!isset($parametros["columna"]) && !$parametros["columna"] || $parametros["columna"] == "") {
                $columna = "cedula";
            }

            if (!isset($parametros["clave"]) && !$parametros["clave"]) {
                throw new Exception("No se ha definido una clave");
            }

            return $this->select(
                "SELECT * FROM $tabla WHERE $columna = ?",
                ["i", $parametros["clave"]]
            );
        } else if ($tabla == "equipo") {
            return $this->select(
                "SELECT * FROM $tabla LIMIT ?",
                ["i", $limit]
            );
        } else {

            $columna = "fechaDeCreacion";
            if (isset($parametros["columna"]) && $parametros["columna"] != "") {
                $columna = $parametros["columna"];
            }

            return $this->select(
                "SELECT * FROM $tabla ORDER BY $columna ASC LIMIT ?",
                ["i", $limit]
            );
        }
    }

    public function _nuevoCliente($params = [])
    {
        $params["nombreTabla"] = "clientes";
        return $this->insert(
            "INSERT INTO clientes (
                fechaDeCreacion,
                cedula,
                nombres,
                apellidos,
                correo,
                celular,
                direccionDeResidencia,
                fechaDeNacimiento,
                lugarDeNacimiento,
                sexo,
                estatura,
                etnia,
                estadoCivil,
                escolaridad,
                colegio-institucion,
                estudiaActualmente,
                universidad-institucion,
                actividadEconomica,
                ingresoMensual,
                intereses
            ) VALUES (NOW(),?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
            $params
        );
    }

    public function _nuevaVisita($params = [])
    {
        $params["nombreTabla"] = "visitas";
        return $this->insert(
            "INSERT INTO visitas (
                fechaDeCreacion,
                establecimiento,
                tematica,
                cedula,
                consumo,
                calificacion,
                horaDeIngreso,
                horaDeSalida
            ) VALUES (NOW(),?,?,?,?,?,NOW(),?)",
            $params
        );
    }

    public function _nuevoIntegranteEquipo($params = [])
    {
        $params["nombreTabla"] = "equipo";
        return $this->insert(
            "INSERT INTO visitas (   
                    cedula,   
                    nombres,    
                    apellidos,    
                    correo,    
                    celular,    
                    fechaDeNacimiento,    
                    permisos,    
                    usuario,
                    clave
            ) VALUES (?,?,?,?,?,?,?,?)",
            $params
        );
    }

    public function _actualizarCliente($clave = 0, $params = [])
    {
        $keys = array_keys($params);
        $sql = "UPDATE clientes SET ";
        $k = 0;
        foreach ($keys as $key) {
            $sql .= $key . " = " . $params[$key];
            if ($k <= count($keys) - 1) {
                $sql .= ", ";
            }
            $k++;
        }
        $sql .= " WHERE cedula = $clave";

        $params["nombreTabla"] = "clientes";

        return $this->update($sql);
    }

    public function _actualizarVisita($clave = 0, $params = [])
    {
        $keys = array_keys($params);
        $sql = "UPDATE visitas SET ";
        $k = 0;
        foreach ($keys as $key) {
            $sql .= $key . " = " . $params[$key];
            if ($k <= count($keys) - 1) {
                $sql .= ", ";
            }
            $k++;
        }
        $sql .= " WHERE cedula = $clave";

        $params["nombreTabla"] = "visitas";

        return $this->update($sql);
    }

    public function _actualizarIntegranteEquipo($clave = "", $params = [])
    {
        $keys = array_keys($params);
        $sql = "UPDATE equipo SET ";
        $k = 0;
        foreach ($keys as $key) {
            $sql .= $key . " = " . $params[$key];
            if ($k <= count($keys) - 1) {
                $sql .= ", ";
            }
            $k++;
        }
        $sql .= " WHERE usuario = $clave";

        $params["nombreTabla"] = "equipo";

        return $this->update($sql);
    }

    public function _eliminarRegistro($tabla = "", $columna = "", $clave = "")
    {
        return $this->update("DELETE FROM $tabla WHERE $columna = $clave");
    }
}
