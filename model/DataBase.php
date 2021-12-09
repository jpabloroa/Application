<?php
class Database
{
    protected $connection = null;

    public function __construct()
    {
        try {
            $this->connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);

            if (mysqli_connect_errno()) {
                throw new Exception("Could not connect to database.");
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function select($query = "", $params = [])
    {
        try {
            $stmt = $this->executeStatement($query, $params[0], $params[1]);
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            return $result;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return false;
    }

    public function insert($query = "", $params = [])
    {
        try {
            $stmt = $this->connection->prepare($query);

            if ($stmt === false) {
                throw new Exception("No es posible ejecutar la sentencia: " . $query . " Detalles del error: " . $this->connection->error);
            }

            switch ($params["nombreTabla"]) {
                case "clientes":
                    $stmt->bind_param(
                        "isssssssiissssissis",
                        $params["cedula"],
                        $params["nombres"],
                        $params["apellidos"],
                        $params["correo"],
                        $params["celular"],
                        $params["direccionDeResidencia"],
                        $params["fechaDeNacimiento"],
                        $params["lugarDeNacimiento"],
                        $params["sexo"],
                        $params["estatura"],
                        $params["etnia"],
                        $params["estadoCivil"],
                        $params["escolaridad"],
                        $params["colegioInstitucion"],
                        $params["estudiaActualmente"],
                        $params["universidadInstitucion"],
                        $params["actividadEconomica"],
                        $params["ingresoMensual"],
                        $params["intereses"]
                    );
                    break;
                case "visitas":
                    $stmt->bind_param(
                        "ssisis",
                        $params["establecimiento"],
                        $params["tematica"],
                        $params["cedula"],
                        $params["consumo"],
                        $params["calificacion"],
                        $params["horaDeSalida"]
                    );
                    break;
                case "clientes":
                    $stmt->bind_param(
                        "issssssss",
                        $params["cedula"],
                        $params["nombres"],
                        $params["apellidos"],
                        $params["correo"],
                        $params["celular"],
                        $params["fechaDeNacimiento"],
                        $params["permisos"],
                        $params["usuario"],
                        $params["clave"]
                    );
                    break;
            }

            $stmt->execute();

            if ($stmt == TRUE) {
                return $params;
            } else {
                return null;
            }
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return false;
    }

    public function update($query)
    {
        try {
            $stmt = $this->connection->prepare($query);

            if ($stmt === false) {
                throw new Exception("No es posible ejecutar la sentencia: " . $query . " Detalles del error: " . $this->connection->error);
            }

            $stmt->execute();

            if ($stmt == TRUE) {
                return $stmt;
            } else {
                return null;
            }
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return false;
    }

    private function executeStatement($query = "", $typeValue = "", $value = "")
    {
        try {
            $stmt = $this->connection->prepare($query);

            if ($stmt === false) {
                throw new Exception("No es posible ejecutar la sentencia: " . $query);
            }

            if (strlen($typeValue) == 1) {
                $stmt->bind_param($typeValue, $value);
            } else {
                throw new Exception("Error de sintáxis, compruebe el tamaño del typeOfValues y params ");
            }

            $stmt->execute();

            return $stmt;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
