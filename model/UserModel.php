<?php
require_once PROJECT_ROOT_PATH . "/model/DataBase.php";

class UserModel extends Database
{
    public function getUsers($tabla = "", $parametros = [], $limit = 100)
    {
        try {
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
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function _nuevoCliente($params = [])
    {
        try {
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
                colegioInstitucion,
                estudiaActualmente,
                universidadInstitucion,
                actividadEconomica,
                ingresoMensual,
                intereses
            ) VALUES (now(),?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                $params
            );
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function _nuevaVisita($params = [])
    {
        try {
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
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function _nuevoIntegranteEquipo($params = [])
    {
        try {
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
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function _actualizarCliente($clave = 0, $params = [])
    {
        try {
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
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function _actualizarVisita($clave = 0, $params = [])
    {
        try {
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
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function _actualizarIntegranteEquipo($clave = "", $params = [])
    {
        try {
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
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function _eliminarRegistro($tabla = "", $columna = "", $clave = "")
    {
        try {
            return $this->update("DELETE FROM $tabla WHERE $columna = $clave");
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
