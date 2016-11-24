<?php

namespace ContabilidadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Cliente
 *
 * @ORM\Table(name="cliente")
 * @ORM\Entity(repositoryClass="ContabilidadBundle\Repository\ClienteRepository")
 */
class Cliente
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
     * @ORM\Column(name="ruc", type="string", length=20)
     * @Assert\Length(min="5")
     * @Assert\NotBlank()
     */
    private $ruc;

    /**
     * @var string
     *
     * @ORM\Column(name="dv", type="string", length=5)
     * @Assert\NotBlank()
     * @Assert\Length(max="1")
     */
    private $dv;

    /**
     * @var string
     *
     * @ORM\Column(name="nombres", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $nombres;

    /**
     * @var string
     *
     * @ORM\Column(name="ape1", type="string", length=100, nullable=true)
     */
    private $ape1;

    /**
     * @var string
     *
     * @ORM\Column(name="ape2", type="string", length=100, nullable=true)
     */
    private $ape2;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=20)
     * @Assert\NotBlank()
     */
    private $estado;


    public function __toString()
    {
        return $this->getNombres().' '.$this->getApe1().' '.$this->getApe2();
    }

    public function __construct()
    {
        $this->setApe2("")->setApe1("");
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
     * Set ruc
     *
     * @param string $ruc
     *
     * @return Cliente
     */
    public function setRuc($ruc)
    {
        $this->ruc = $ruc;

        return $this;
    }

    /**
     * Get ruc
     *
     * @return string
     */
    public function getRuc()
    {
        return $this->ruc;
    }

    /**
     * Set dv
     *
     * @param string $dv
     *
     * @return Cliente
     */
    public function setDv($dv)
    {
        $this->dv = $dv;

        return $this;
    }

    /**
     * Get dv
     *
     * @return string
     */
    public function getDv()
    {
        return $this->dv;
    }

    /**
     * Set nombres
     *
     * @param string $nombres
     *
     * @return Cliente
     */
    public function setNombres($nombres)
    {
        $this->nombres = strtoupper($nombres);

        return $this;
    }

    /**
     * Get nombres
     *
     * @return string
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * Set ape1
     *
     * @param string $ape1
     *
     * @return Cliente
     */
    public function setApe1($ape1)
    {
        $this->ape1 = strtoupper($ape1);

        return $this;
    }

    /**
     * Get ape1
     *
     * @return string
     */
    public function getApe1()
    {
        return $this->ape1;
    }

    /**
     * Set ape2
     *
     * @param string $ape2
     *
     * @return Cliente
     */
    public function setApe2($ape2)
    {
        $this->ape2 = strtoupper($ape2);

        return $this;
    }

    /**
     * Get ape2
     *
     * @return string
     */
    public function getApe2()
    {
        return $this->ape2;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return Cliente
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return bool
     */
    public function getEstado()
    {
        return $this->estado;
    }
}

