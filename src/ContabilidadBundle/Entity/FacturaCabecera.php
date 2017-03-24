<?php

namespace ContabilidadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FacturaCabecera
 *
 * @ORM\Table(name="factura_cabecera")
 * @ORM\Entity(repositoryClass="ContabilidadBundle\Repository\FacturaCabeceraRepository")
 */
class FacturaCabecera
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="condicion", type="string", length=50)
     */
    private $condicion;

    /**
     * @var string
     *
     * @ORM\Column(name="nsuc", type="string", length=5)
     */
    private $nsuc;

    /**
     * @var string
     *
     * @ORM\Column(name="npe", type="string", length=5)
     */
    private $npe;

    /**
     * @var string
     *
     * @ORM\Column(name="ncomp", type="string", length=10)
     */
    private $ncomp;

    /**
     * @var string
     *
     * @ORM\Column(name="timbrado", type="string", length=10)
     */
    private $timbrado;


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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return FacturaCabecera
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set condicion
     *
     * @param string $condicion
     *
     * @return FacturaCabecera
     */
    public function setCondicion($condicion)
    {
        $this->condicion = $condicion;

        return $this;
    }

    /**
     * Get condicion
     *
     * @return string
     */
    public function getCondicion()
    {
        return $this->condicion;
    }

    /**
     * Set nsuc
     *
     * @param string $nsuc
     *
     * @return FacturaCabecera
     */
    public function setNsuc($nsuc)
    {
        $this->nsuc = $nsuc;

        return $this;
    }

    /**
     * Get nsuc
     *
     * @return string
     */
    public function getNsuc()
    {
        return $this->nsuc;
    }

    /**
     * Set npe
     *
     * @param string $npe
     *
     * @return FacturaCabecera
     */
    public function setNpe($npe)
    {
        $this->npe = $npe;

        return $this;
    }

    /**
     * Get npe
     *
     * @return string
     */
    public function getNpe()
    {
        return $this->npe;
    }

    /**
     * Set ncomp
     *
     * @param string $ncomp
     *
     * @return FacturaCabecera
     */
    public function setNcomp($ncomp)
    {
        $this->ncomp = $ncomp;

        return $this;
    }

    /**
     * Get ncomp
     *
     * @return string
     */
    public function getNcomp()
    {
        return $this->ncomp;
    }

    /**
     * Set timbrado
     *
     * @param string $timbrado
     *
     * @return FacturaCabecera
     */
    public function setTimbrado($timbrado)
    {
        $this->timbrado = $timbrado;

        return $this;
    }

    /**
     * Get timbrado
     *
     * @return string
     */
    public function getTimbrado()
    {
        return $this->timbrado;
    }
}

