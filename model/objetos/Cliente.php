<?php

class Cliente
{

    public function codificar($cliente = [])
    {
        $nuevoCliente = $cliente;
        $nuevoCliente["nombre"] = $nuevoCliente["nombres"] . " " . $nuevoCliente["apellidos"];

        return $nuevoCliente;
    }
}
