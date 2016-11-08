<?php

namespace PersonalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Empresa
 *
 * @ORM\Table(name="empresa")
 * @ORM\Entity(repositoryClass="PersonalBundle\Repository\EmpresaRepository")
 */
class Empresa
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
     * @ORM\Column(name="nombre", type="string", length=200)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=200)
     */
    private $apellido;

    /**
     * @var string
     *
     * @ORM\Column(name="npat_mtess", type="string", length=20)
     */
    private $npatMtess;

    /**
     * @var string
     *
     * @ORM\Column(name="npat_ips", type="string", length=20)
     */
    private $npatIps;

    /**
     * @var string
     *
     * @ORM\Column(name="pw_mtess", type="string", length=20, nullable=true)
     */
    private $pwMtess;

    /**
     * @var string
     *
     * @ORM\Column(name="pw_ips", type="string", length=20, nullable=true)
     */
    private $pwIps;


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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Empresa
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellido
     *
     * @param string $apellido
     *
     * @return Empresa
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set npatMtess
     *
     * @param string $npatMtess
     *
     * @return Empresa
     */
    public function setNpatMtess($npatMtess)
    {
        $this->npatMtess = $npatMtess;

        return $this;
    }

    /**
     * Get npatMtess
     *
     * @return string
     */
    public function getNpatMtess()
    {
        return $this->npatMtess;
    }

    /**
     * Set npatIps
     *
     * @param string $npatIps
     *
     * @return Empresa
     */
    public function setNpatIps($npatIps)
    {
        $this->npatIps = $npatIps;

        return $this;
    }

    /**
     * Get npatIps
     *
     * @return string
     */
    public function getNpatIps()
    {
        return $this->npatIps;
    }

    /**
     * Set pwMtess
     *
     * @param string $pwMtess
     *
     * @return Empresa
     */
    public function setPwMtess($pwMtess)
    {
        $this->pwMtess = $pwMtess;

        return $this;
    }

    /**
     * Get pwMtess
     *
     * @return string
     */
    public function getPwMtess()
    {
        return $this->pwMtess;
    }

    /**
     * Set pwIps
     *
     * @param string $pwIps
     *
     * @return Empresa
     */
    public function setPwIps($pwIps)
    {
        $this->pwIps = $pwIps;

        return $this;
    }

    /**
     * Get pwIps
     *
     * @return string
     */
    public function getPwIps()
    {
        return $this->pwIps;
    }
}

