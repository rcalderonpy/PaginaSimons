<?php

namespace ContabilidadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Moneda
 *
 * @ORM\Table(name="moneda")
 * @ORM\Entity(repositoryClass="ContabilidadBundle\Repository\MonedaRepository")
 */
class Moneda
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="moneda", type="string", length=100)
     */
    private $moneda;

    /**
     * @var string
     *
     * @ORM\Column(name="simbolo", type="string", length=10)
     */
    private $simbolo;

    public function __toString()
    {
        return $this->getMoneda();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set moneda
     *
     * @param string $moneda
     *
     * @return Moneda
     */
    public function setMoneda($moneda)
    {
        $this->moneda = $moneda;

        return $this;
    }

    /**
     * Get moneda
     *
     * @return string
     */
    public function getMoneda()
    {
        return $this->moneda;
    }

    /**
     * Set simbolo
     *
     * @param string $simbolo
     *
     * @return Moneda
     */
    public function setSimbolo($simbolo)
    {
        $this->simbolo = $simbolo;

        return $this;
    }

    /**
     * Get simbolo
     *
     * @return string
     */
    public function getSimbolo()
    {
        return $this->simbolo;
    }
}

