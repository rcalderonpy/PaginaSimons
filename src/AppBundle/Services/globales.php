<?php

namespace AppBundle\Services;


class globales
{
    private $cliente;

    /**
     * @return mixed
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * @param mixed $usuario
     * @return globales
     */
    public function setCliente($cliente)
    {
        $this->cliente = $cliente;
        return $this;
    }


}